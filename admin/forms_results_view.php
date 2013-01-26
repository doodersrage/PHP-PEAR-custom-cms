<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');

$formid = $_GET['formid'];
$date = $_GET['date'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Form Results Display</title>
<?PHP require('includes/header_inc.php'); ?>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('includes/menu.php'); ?></td>
    <td valign="top" class="content_area">
    <h1 align="center">Form Results Display</h1>
    <form id="form1" name="form1" method="post" action="">
      <table align="center" class="list_table">
        <tr>
          <td>
          <table align="center" class="list_table">
            <?PHP
			$query = "SELECT fr.result, ff.question FROM forms_results fr LEFT JOIN forms_fields ff ON fr.forms_fields_id = ff.form_fields_id WHERE fr.added = '".$date."';";
			$result = $db->query($query);

			if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
			}
			
            echo '<tr><td><table>';
			while ($result_row = $result->fetchRow()) {
			
            echo  '<tr><td style="text-align:right;"><strong>' . $result_row[1] . '</strong>: </td><td style="text-align:left;">' . $result_row[0].'<br></td></tr>';

			}
            echo '</table></td></tr>';
			
			?>
          </table></td>
        </tr>
        <tr>
          <td><p><a href="form_results_view.php?formid=<?PHP echo $formid; ?>">Back to form results view</a></p>
            </td>
        </tr>
      </table>
      </form>
    </td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?>