<?PHP


// load form
function load_form($form_id) {
global $db;

// load selected form
$form_query = "SELECT name, reply_email_addresses FROM forms WHERE form_id = '".$form_id."' AND enabled = 1;";

$form_result = $db->query($form_query);
		
$form_result_row = $form_result->fetchRow();

$form_name = $form_result_row[0];
$form_reply_email_addresses = $form_result_row[1];


$form_print = '<form action="" method="post" name="dyn_form"><input name="dyn_form_submit" type="hidden" value="1" /><input name="form_id" type="hidden" value="'.$form_id.'" /><input name="reply_email" type="hidden" value="'.$form_reply_email_addresses.'" /><table align="center"><tr><td>'."\n";

// pull form questions
$questions_query = "SELECT form_fields_id, question, description, field_type, field_values, field_default, required FROM forms_fields WHERE form_id = '".$form_id."' ORDER BY sort_order ASC;";

$questions_result = $db->query($questions_query);

require(CLASSES_DIRECTORY.'form_fields.php');

$form_field = new form_field;

while($questions_result_row = $questions_result->fetchRow()) {

$form_fields_id = $questions_result_row[0];
$question = $questions_result_row[1];
$description = $questions_result_row[2];
$field_type = $questions_result_row[3];
$field_values = $questions_result_row[4];
$field_default = $questions_result_row[5];
$required = $questions_result_row[6];

$form_print .= '<table><tr><td style="padding:2px;width:150px;" valign="top"><p align="right"><strong>' . $question . ':</strong></p>' . $description . '</td><td style="text-align:left;padding:3px;">'.$form_field->determine_field($form_fields_id, $question, $description, $field_type, $field_values, $field_default, $required) . '</td></tr></table>'."\n";

}

$form_print .= '<center><input name="Submit" type="submit" value="Submit" /></center></td></tr></table>'."\n";


return $form_print;
}


// process form data
function process_form($form_post) {

$form_errors = check_form_errors($form_post);

if ($form_errors <= 0) {
insert_form_data($form_post);
} else {
$GLOBALS['warning'] = "You did not fill out the form correctly.";
}

}


// check submitted form for errors
function check_form_errors($form_post) {
global $db;

// pull form questions
$questions_query = "SELECT form_fields_id, required FROM forms_fields WHERE form_id = '".$form_post['form_id']."' AND required = 1 ORDER BY sort_order ASC;";

$questions_result = $db->query($questions_query);

$errors = 0;
while($questions_result_row = $questions_result->fetchRow()) {

if (empty($form_post['question']['fields'][$questions_result_row[0]])) $errors++;

}

return $errors;
}


// insert successful form data
function insert_form_data($form_post) {
global $db;

$form_id = $form_post['form_id'];
$form_name = form_name($form_id);
$reply_email = $form_post['reply_email'];

$form_email = '<strong>Form submitted:</strong> '.$form_name.'<br>';
$form_email .= '<strong>Date Submitted:</strong> '.date('l jS \of F Y h:i:s A').'<br>';

foreach($form_post['question']['fields'] as $id => $value) {

// if form submission value is array process array
if (is_array($value)) {

foreach($value as $array_val) {
$values = array($form_id,$id,$array_val);
$sql = 'INSERT INTO forms_results (forms_id,forms_fields_id,result) VALUES (?,?,?)';
$sth = $db->prepare($sql);
$res = $db->execute($sth,$values);

$form_email .= '<strong>'.question_name($id).' :</strong> '.$array_val.'<br>';
}

} else {
$values = array($form_id,$id,$value);
$sql = 'INSERT INTO forms_results (forms_id,forms_fields_id,result) VALUES (?,?,?)';
$sth = $db->prepare($sql);
$res = $db->execute($sth,$values);

$form_email .= '<strong>'.question_name($id).' :</strong> '.$value.'<br>';
}
}

if (!empty($reply_email)) {
$emailer_list = explode(';',$reply_email);
foreach($emailer_list as $cur_email) {
send_email($cur_email,$form_email,SITE_URL.' Form: '.$form_name.' Submission');
}
}

$GLOBALS['warning'] = "Thank you for contacting us. We will get back to you shortly.";
}

// get question name
function question_name($question_id) {
global $db;

$questions_query = "SELECT question FROM forms_fields WHERE form_fields_id = '".$question_id."';";
$questions_result = $db->query($questions_query);
$questions_result_row = $questions_result->fetchRow();

$question_name = $questions_result_row[0];

return $question_name;
}


// get form name
function form_name($form_id) {
global $db;

$questions_query = "SELECT name FROM forms WHERE form_id = '".$form_id."';";
$questions_result = $db->query($questions_query);
$questions_result_row = $questions_result->fetchRow();

$form_name = $questions_result_row[0];

return $form_name;
}

?>