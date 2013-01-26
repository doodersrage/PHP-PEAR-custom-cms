<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');

require(ADMIN_CLASSES_DIRECTORY.'write_input.php');

$write_input = new write_input;

// get vars
$groupid = $_GET['groupid'];
$settingid = $_GET['settingid'];
//  settings update vals
$submit_form = $_POST['submit_form'];
$field_type = $_POST['field_type'];
$edit_settings_id = $_POST['edit_settings_id'];
$setting_val = $_POST['setting_val'];

// if settings value has been updated through form update value within db
if ($submit_form == 1) {

if ($field_type == "file") {
$target_path = IMAGES_DIRECTORY;
$target_path = $target_path . basename( $_FILES['setting_val']['name']); 
move_uploaded_file($_FILES['setting_val']['tmp_name'], $target_path);
$setting_val = basename($_FILES['setting_val']['name']);
}

$values = array($setting_val,$edit_settings_id);
$sql = "UPDATE site_settings SET value=? WHERE site_settings_id = ?;";
$sth = $db->prepare($sql);
$res = $db->execute($sth,$values);

update_constants_file();

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Global Settings</title>
<?PHP require('includes/header_inc.php'); ?>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('includes/menu.php'); ?></td>
    <td valign="top" class="content_area"><div align="center">
      <h1>Global Settings</h1>
    </div>
      <form enctype="multipart/form-data" id="form1" name="form1" action="global_settings.php?groupid=<?PHP echo $groupid; ?>" method="post" >
        <table width="100%">
          <tr>
            <td valign="top">
            <?PHP
			// load group settings selections if group id has been set
			if (!empty($groupid)) {
			
			echo '<table class="global_settings_group_table" align="center">
  					<tr>
    					<th>Setting Info:</th>
    					<th>Current Setting Value:</th>
  					</tr>';
					
  			$query = "SELECT site_settings_id, title, description, value, type FROM site_settings WHERE group_id = '".$groupid."';";
			$result = $db->query($query);

			if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
			}

			while ($result_row = $result->fetchRow()) {
			
  			echo '<tr'.($settingid != $result_row[0] ? ' onclick="document.location.href=\'global_settings.php?groupid='.$groupid.'&settingid='.$result_row[0].'\'"' : '').' class="global_group" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
    				<td><strong>'.$result_row[1].'</strong><br>'.$result_row[2].'</td>
    				<td>';
					
					if ($settingid == $result_row[0]) {
					
						echo '<center>'.$write_input->determine_input($result_row[4],$result_row[3]);
						echo '<input name="submit_form" type="hidden" value="1" />
							<input name="field_type" type="hidden" value="'.$result_row[4].'" />
							<input name="edit_settings_id" type="hidden" value="'.$result_row[0].'" />
							<br><input name="Submit Changes" type="submit" value="Submit Changes" /></center>';
					
					} else {
						echo $result_row[3];
					}
					
			echo '</td>
  				</tr>';

			}

  
			echo '</table>';
			
			}
            ?>            </td>
          </tr>
        </table>
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?>