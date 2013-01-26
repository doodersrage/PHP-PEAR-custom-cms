<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');

// get vars
$artid = $_GET['artid'];
$delete = $_POST['delete'];

// delete selected articles
if (!empty($delete)) {

foreach($delete as $articleid) {

mysql_query("DELETE FROM articles WHERE article_id = '".$articleid."';");
mysql_query("DELETE FROM article_views WHERE article_id = '".$articleid."';");

}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Articles Listing</title>
<?PHP require('includes/header_inc.php'); ?>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('includes/menu.php'); ?></td>
    <td valign="top" class="content_area"><div align="center"><h1>Articles List</h1></div>
      <form id="form1" name="form1" method="post" action="">
      <table align="center" class="list_table">
        <tr>
          <td>
          
          <div class="article_hostory"> 
          <a href="articles.php">Main Article Listing</a>
            <?PHP	
			
			$linked_articles = '';
			$article_history_list = print_article_history($artid);
			
			if (is_array($article_history_list)) {
			arsort($article_history_list);
			
			//print_r($article_history_list);
			
			foreach($article_history_list as $cur_hist_item) {
			foreach($cur_hist_item as $art_id => $art_name) {
			if (!empty($art_id)) echo ' &rarr; <a href="articles.php?artid='.$art_id.'">'.$art_name.'</a>';
			}}
			}
			?>
          </div>
          
          <table align="center" class="list_table">
            <tr>
              <th>Type</th>
              <th>Title</th>
              <th>CSV</th>
              <th>Form</th>
              <th>Sort Order</th>
              <th>Status</th>
              <th>Delete</th>
            </tr>
            <?PHP
			$query = "SELECT article_id, title, article_csv, form_id, enabled, sort_order FROM articles WHERE parent_article_id = '".$artid."' ORDER BY sort_order ASC;";
			$result = $db->query($query);

			if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
			}

			while ($result_row = $result->fetchRow()) {
			
            echo '<tr>';
            echo   '<td>';
			
			// check for child assignments
			$child_check = mysql_query("SELECT parent_article_id FROM articles WHERE parent_article_id = '".$result_row[0]."';");
			
			if (mysql_num_rows($child_check) > 0) {
			echo '<a href="articles.php?artid='.$result_row[0].'"><img src="images/document-open_22x22.png"  border="0" /></a>';
			$delcheck = '';
			} else {
			echo '<a href="articles_edit.php?artid='.$result_row[0].'"><img src="images/doc_16x16.png" border="0" /></a>';
			$delcheck = '<input type="checkbox" name="delete[]" id="delete" value="'.$result_row[0].'" />';
			}
			
			echo '</td>';
            echo   '<td><a href="articles_edit.php?artid='.$result_row[0].'">'.$result_row[1].'</a></td>';
            echo   '<td><a href="'.SITE_CSV_URL.$result_row[2].'" target="_blank">'.$result_row[2].'</a></td>';
            echo   '<td>';
			
			if (!empty($result_row[3])) {
			
			$form_query = "SELECT name FROM forms WHERE form_id = '".$result_row[3]."';";
			$form_result = $db->query($form_query);

			if (DB::isError($form_result)){
			die("Could not query the database: <br />".$form_query." ".DB::errorMessage($form_result));
			}

			$form_result_row = $form_result->fetchRow();

			
			echo $form_result_row[0];
			
			}
			
			echo   '</td>';
            echo   '<td>'.$result_row[5].'</td>';
            echo   '<td>'.($result_row[4] == 1 ? 'Enabled' : '&nbsp;').'</td>';
            echo   '<td>'.$delcheck.'</td>';
            echo '</tr>';

			}
			
			?>
          </table></td>
        </tr>
        <tr>
          <td><a href="articles_edit.php<?PHP if (!empty($artid)) echo '?parid='.$artid; ?>">New Article</a></td>
        </tr>
        <tr>
          <td><input type="submit" name="button" id="button" value="Delete Selected" onclick="return confirm('Are you sure you want to delete the selected items?')" /></td>
        </tr>
      </table>
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?>