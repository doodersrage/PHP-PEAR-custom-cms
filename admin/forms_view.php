<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');

$delete = $_POST['delete'];

if (!empty($delete)) {

foreach($delete as $formsid) {

mysql_query("DELETE FROM forms WHERE form_id = '".$formsid."';");
mysql_query("DELETE FROM forms_fields WHERE form_id = '".$formsid."';");
mysql_query("DELETE FROM forms_results WHERE form_id = '".$formsid."';");

}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Site Forms</title>
<?PHP require('includes/header_inc.php'); ?>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('includes/menu.php'); ?></td>
    <td valign="top" class="content_area">
    <h1 align="center">Forms View</h1>
    <form id="form1" name="form1" method="post" action="">
      <table align="center" class="list_table">
        <tr>
          <td>
          <table align="center" class="list_table">
            <tr>
              <th>Name</th>
              <th>Status</th>
              <th># Questions</th>
              <th>Reply Emails</th>
              <th>Added</th>
              <th>Results</th>
              <th>Delete</th>
            </tr>
            <?PHP
			$query = "SELECT form_id, name, enabled, reply_email_addresses, added FROM forms ORDER BY added ASC;";
			$result = $db->query($query);

			if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
			}

			while ($result_row = $result->fetchRow()) {
			
            echo '<tr>';
            echo   '<td><a href="forms_edit.php?formid='.$result_row[0].'">'.$result_row[1].'</a></td>';
            echo   '<td>'.($result_row[2] == 1 ? 'Enabled' : '&nbsp;').'</td>';
            echo   '<td>';
			
			// check for child assignments
			$child_check = mysql_query("SELECT form_fields_id FROM forms_fields WHERE form_id = '".$result_row[0]."';");
			
			echo '<a href="questions_view.php?formid='.$result_row[0].'">' . mysql_num_rows($child_check) . '</a>';
			
			echo '</td>';
            echo   '<td>'.$result_row[3].'</td>';
            echo   '<td>'.$result_row[4].'</td>';
            echo   '<td><a href="form_results_view.php?formid='.$result_row[0].'">View</a></td>';
            echo   '<td><input type="checkbox" name="delete[]" id="delete" value="'.$result_row[0].'" /></td>';
            echo '</tr>';

			}
			
			?>
          </table></td>
        </tr>
        <tr>
          <td><a href="forms_edit.php">New Form</a></td>
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