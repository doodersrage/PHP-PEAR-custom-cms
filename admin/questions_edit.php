<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');

// set vars
$form_submit = $_POST['form_submit'];
$formid = (!empty($_GET['formid']) ? $_GET['formid'] : $_POST['formid']);
$form_fields_id = $_GET['form_fields_id'];
$question = $_POST['question'];
$description = $_POST['description'];
$type = $_POST['type'];
$values = $_POST['values'];
$default = $_POST['default'];
$sort_order = $_POST['sort_order'];
$required = $_POST['required'];

// check form form submission
if (!empty($form_submit)) {

if (!empty($question) && !empty($type)) {
$values = array($formid, $question, $description, $type, $values, $default, $sort_order, $required);

// check for form update or post new
if (!empty($form_fields_id)) {

$sql = 'UPDATE forms_fields SET form_id=?, question=?, description=?, field_type=?, field_values=?, field_default=?, sort_order=?, required=? WHERE form_fields_id = "'.$form_fields_id.'";';

// if $formid not set insert new form data
} else {

$sql = 'INSERT INTO forms_fields (form_id, question, description, field_type, field_values, field_default, sort_order, required) VALUES (?,?,?,?,?,?,?,?)';

}

// write new data to database
$sth = $db->prepare($sql);
$res = $db->execute($sth,$values);

// redirect to article listing page
header("Location: questions_view.php?formid=".$formid);
} else {

$error_message = 'You must assign a form title.';
}

}


//pull db set vars if $formid is set
if (!empty($form_fields_id)) {

$query = "SELECT form_id, form_fields_id, question, description, field_type, field_values, field_default, sort_order, required FROM forms_fields WHERE form_fields_id = '".$form_fields_id."';";
$result = $db->query($query);

if (DB::isError($result)){
die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
}

$result_row = $result->fetchRow();

// assign variables
$formid = $result_row[0];
//$form_fields_id = $result_row[1];
$question = $result_row[2];
$description = $result_row[3];
$type = $result_row[4];
$values = $result_row[5];
$default = $result_row[6];
$sort_order = $result_row[7];
$required = $result_row[8];

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Questions Edit</title>
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
    <h1 align="center">Questions Edit</h1>
    <form id="form1" name="form1" method="post" action="">
      <table align="center" class="admin_box">
          <tr>
            <td align="right" valign="top" class="title_column" colspan="2"><div align="center">* indicates required field <?PHP echo '<br><span class="style1">'.$error_message.'</span>'; ?></div></td>
          </tr>
        <tr>
          <td align="right" valign="top" class="title_column style1">*Question:</td>
          <td class="field_column"><input name="question" type="text" id="question" size="45" value="<?PHP echo $question; ?>" /></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="title_column">Description:</td>
          <td class="field_column"><textarea name="description" cols="45" rows="3" id="description"><?PHP echo $description; ?></textarea></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="title_column style1">*Type:</td>
          <td class="field_column"><select name="type" id="type">
            <?PHP
			$type_array = array('checkbox','textbox','textarea','radiobutton');
			foreach($type_array as $title) {
			echo '<option '.($type == $title ? 'selected="selected"' : '').'>'.$title.'</option>';
			}
			?>
          </select>
          </td>
        </tr>
        <tr>
          <td align="right" valign="top" class="title_column">Values:</td>
          <td class="field_column"><textarea name="values" cols="45" rows="3" id="values"><?PHP echo $values; ?></textarea></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="title_column">Default:</td>
          <td class="field_column"><input name="default" type="text" id="default" value="<?PHP echo $default; ?>" size="45" /></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="title_column">Sort Order:</td>
          <td class="field_column"><input name="sort_order" type="text" id="sort_order" size="10" value="<?PHP echo $sort_order; ?>"/></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="title_column">Required:</td>
          <td class="field_column"><input type="checkbox" name="required" id="required" value="1" <?PHP if ($required == 1) echo 'checked'; ?> /></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><input type="hidden" name="form_fields_id" id="form_fields_id"  value="<?PHP echo $form_fields_id; ?>"/>
          <input type="hidden" name="formid" id="formid" value="<?PHP echo $formid; ?>"/>
          <input type="hidden" name="form_submit" id="form_submit" value="1" />
            <input type="submit" name="Submit" id="Submit" value="Submit" /></td>
        </tr>
      </table>
      </form>
    <p align="center">&nbsp;</p></td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?>