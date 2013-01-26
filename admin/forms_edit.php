<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');

// set vars
$formid = $_GET['formid'];
$form_submit = $_POST['form_submit'];
$name = $_POST['name'];
$enabled = $_POST['enabled'];
$reply_email_addresses = $_POST['reply_email_addresses'];

// check form form submission
if (!empty($form_submit)) {

if (!empty($name)) {
$values = array($name,$enabled,$reply_email_addresses);

// check for form update or post new
if (!empty($formid)) {

$sql = 'UPDATE forms SET name=?, enabled=?, reply_email_addresses=? WHERE form_id = "'.$formid.'";';

// if $formid not set insert new form data
} else {

$sql = 'INSERT INTO forms (name, enabled, reply_email_addresses) VALUES (?,?,?)';

}

// write new data to database
$sth = $db->prepare($sql);
$res = $db->execute($sth,$values);

// redirect to article listing page
header("Location: forms_view.php");
} else {

$error_message = 'You must assign a form title.';
}

}


//pull db set vars if $formid is set
if (!empty($formid)) {

$query = "SELECT name, enabled, reply_email_addresses FROM forms WHERE form_id = '".$formid."';";
$result = $db->query($query);

if (DB::isError($result)){
die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
}

$result_row = $result->fetchRow();

// assign variables
$name = $result_row[0];
$enabled = $result_row[1];
$reply_email_addresses = $result_row[2];

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Form Edit</title>
<?PHP require('includes/header_inc.php'); ?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('includes/menu.php'); ?></td>
    <td valign="top" class="content_area">
    <h1 align="center">Forms Edit</h1>
    <form id="form1" name="form1" method="post" action="">
      <table align="center" class="admin_box">
          <tr>
            <td align="right" valign="top" class="title_column" colspan="2"><div align="center">* indicates required field <?PHP echo '<br><span class="style1">'.$error_message.'</span>'; ?></div></td>
          </tr>
        <tr>
          <td align="right" valign="top" class="title_column style1">*Name:</td>
          <td class="field_column"><input name="name" type="text" id="name" size="45" value="<?PHP echo $name; ?>" /></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="title_column">Status:</td>
          <td class="field_column">
          	<select name="enabled" id="enabled">
            <?PHP
			$enabled_array = array(0 => 'Disabled',1 => 'Enabled');
			foreach($enabled_array as $id => $title) {
			echo '<option value="'.$id.'" '.($enabled == $id ? 'selected="selected"' : '').'>'.$title.'</option>';
			}
			?>
            </select>
          </td>
        </tr>
        <tr>
          <td align="right" valign="top" class="title_column">Reply To Email Addresses:</td>
          <td class="field_column"><textarea name="reply_email_addresses" cols="45" rows="3" id="reply_email_addresses"><?PHP echo $reply_email_addresses; ?></textarea></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><input type="hidden" name="form_submit" id="form_submit" value="1" />
            <input type="submit" name="Submit" id="Submit" value="Submit" /></td>
        </tr>
      </table>
      </form>
    <p align="center">&nbsp;</p></td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?>