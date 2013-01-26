<?PHP
// class written to draw dynamic config fields

class write_input {
 
 function determine_input($input_type,$input_val) {
 
 	switch($input_type) {
	case 'text_field':
		$field = $this->draw_text_field($input_val);
	break;
	case 'text_area':
		$field = $this->draw_text_area($input_val);
	break;
	case 'file':
		$field = $this->draw_file_field();
	break;
	case 'yn_combo':
		$field = $this->draw_yn_box($input_val);
	break;
	}
 
 return $field;
 }
 
 
 function draw_text_field($input_val){
 
 	$field = '<input name="setting_val" type="text" size="35" value="'.$input_val.'" />';
 
 return $field;
 }
 
 function draw_text_area($input_val){
 
 	$field = '<textarea name="setting_val" cols="35" rows="5">'.$input_val.'</textarea>';
 
 return $field;
 }

 function draw_file_field(){
 
 	$field = '<input name="setting_val" type="file" />';
 
 return $field;
 }

 function draw_yn_box($input_val){
 
 	$field = '<select name="setting_val">
	<option value="Y"'.($input_val == 'Y' ? 'selected="selected"' : '').'>Yes</option>
	<option value="N"'.($input_val == 'N' ? 'selected="selected"' : '').'>No</option>
	</select>';
 
 return $field;
 }

}
?>