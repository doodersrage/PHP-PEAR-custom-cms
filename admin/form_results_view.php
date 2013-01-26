<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');

$formid = $_GET['formid'];
$delete = $_POST['delete'];

if (!empty($delete)) {

foreach($delete as $formsid) {

mysql_query("DELETE FROM forms_results WHERE forms_results_id = '".$formsid."';");

}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Form Results View</title>
<?PHP require('includes/header_inc.php'); ?>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('includes/menu.php'); ?></td>
    <td valign="top" class="content_area">
    <h1 align="center">Form Results View</h1>
    <form id="form1" name="form1" method="post" action="">
      <table align="center" class="list_table">
        <tr>
          <td>
          <table align="center" class="list_table">
            <tr>
              <th>Date</th>
              <th>Delete</th>
            </tr>
            <?PHP
			$query = "SELECT DISTINCT added FROM forms_results WHERE forms_id = '".$formid."' ORDER BY added ASC;";
			$result = $db->query($query);

			if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
			}

			while ($result_row = $result->fetchRow()) {
			
            echo '<tr>';
            echo   '<td><a href="forms_results_view.php?formid='.$formid.'&date='.$result_row[0].'">'.$result_row[0].'</a></td>';
            echo   '<td><input type="checkbox" name="delete[]" id="delete" value="'.$result_row[0].'" /></td>';
            echo '</tr>';

			}
			
			?>
          </table></td>
        </tr>
        <tr>
          <td><a href="forms_view.php">Back to forms</a></td>
        </tr>
        <tr>
          <td><input type="submit" name="button" id="button" value="Delete Selected" onclick="return confirm('Are you sure you want to delete the selected items?')" /></td>
        </tr>
      </table>
      </form>
    </td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?>