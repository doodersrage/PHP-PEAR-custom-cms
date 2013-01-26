<?PHP

class form_field {


function determine_field($form_fields_id, $question, $description = '', $field_type, $field_values = '', $field_default = '', $required = '') {

// determine field type
switch ($field_type) {
case 'checkbox':
$question_ouput = $this->draw_checkbox_field($form_fields_id, $question, $description, $field_type, $field_values, $field_default);
break;
case 'textbox':
$question_ouput = $this->draw_textbox_field($form_fields_id, $question, $description, $field_type, $field_values, $field_default);
break;
case 'textarea':
$question_ouput = $this->draw_textarea_field($form_fields_id, $question, $description, $field_type, $field_values, $field_default);
break;
case 'radiobutton':
$question_ouput = $this->draw_radiobutton_field($form_fields_id, $question, $description, $field_type, $field_values, $field_default);
break;
}


return $question_ouput;
}

function draw_checkbox_field($form_fields_id, $question, $description = '', $field_type, $field_values = '', $field_default = ''){

$values_array = explode("\n",$field_values);

foreach($values_array as $cur_val) {
$field .= '<div style="padding:5px;float:left;">' . $cur_val . '<input name="question[fields]['.$form_fields_id.'][]" type="checkbox" value="'.$cur_val.'"'.($cur_val == $field_default ? ' checked ' : '' ).'></div>'."\n";
}

return $field;
}

function draw_textbox_field($form_fields_id, $question, $description = '', $field_type, $field_values = '', $field_default = ''){

$field = '<input name="question[fields]['.$form_fields_id.']" type="text" value="'.$field_default.'">'."\n";

return $field;
}

function draw_textarea_field($form_fields_id, $question, $description = '', $field_type, $field_values = '', $field_default = ''){

$field = '<textarea name="question[fields]['.$form_fields_id.']" cols="35" rows="5">'.$field_default.'</textarea>'."\n";

return $field;
}

function draw_radiobutton_field($form_fields_id, $question, $description = '', $field_type, $field_values = '', $field_default = ''){

$values_array = explode("\n",$field_values);

foreach($values_array as $cur_val) {
$field .= '<div style="padding:5px;float:left;">' . $cur_val . ' <input name="question[fields]['.$form_fields_id.'][]" type="radio" value="'.$cur_val.'"'.($cur_val == $field_default ? ' checked ' : '' ).'></div>'."\n";
}

return $field;
}

}

?>