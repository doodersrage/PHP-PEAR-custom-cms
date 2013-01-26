<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');
include_once("includes/fckeditor/fckeditor.php");

// parent article drop down menu
function parent_category_drop_down($selected_id = '') {
		global $db;
	
	$parent_drop_down = '<select name="parent_article_id" id="parent_article_id">'."\n";
	$parent_drop_down .= '<option></option>'."\n";
	
	$stmt = "SELECT
				article_id,
				title,
				parent_article_id
			 FROM
				articles
			 WHERE
				parent_article_id = 0
			 ;";
	$rows = $db->getAll($stmt, DB_FETCHMODE_ASSOC);
	
	foreach ($rows as $categories) {
	$ind = '--';
	
	$parent_drop_down .= '<option value="'.$categories['article_id'].'" '.($selected_id == $categories['article_id'] ? 'selected="selected" ' : '').'>'.$categories['title'].'</option>'."\n";
	
	$parent_drop_down .= parent_dd_child_chk($categories['article_id'],$ind,$selected_id);
	}
	
	$parent_drop_down .= '</select>'."\n";
	
return $parent_drop_down;
}

// check for child articles
function parent_dd_child_chk($cid,$ind,$selected_id = '') {
		global $db;
		
	$stmt = "SELECT
				article_id,
				title,
				parent_article_id
			 FROM
				articles
			 WHERE
				parent_article_id = '".$cid."'
			 ;";
	$rows = $db->getAll($stmt, DB_FETCHMODE_ASSOC);
	
	foreach ($rows as $categories) {
	$parent_drop_down .= '<option value="'.$categories['article_id'].'" '.($selected_id == $categories['article_id'] ? 'selected="selected" ' : '').'>'.$ind.' '.$categories['title'].'</option>'."\n";
	
	$parent_drop_down .= parent_dd_child_chk($categories['article_id'],$ind.'--');
	}
	
return $parent_drop_down;
}

// get/post vars
$artid = $_GET['artid'];
$parid = $_GET['parid'];
$head_content = $_POST['head_content'];
$footer_content = $_POST['footer_content'];
$article_csv = $_POST['article_csv'];
$parent_article_id = $_POST['parent_article_id'];
$link_name = $_POST['link_name'];
$title_tag = $_POST['title_tag'];
$meta_description = $_POST['meta_description'];
$meta_keywords = $_POST['meta_keywords'];
$sort_order = $_POST['sort_order'];
$enabled = $_POST['enabled'];
$title = $_POST['title'];
$form_id = $_POST['form_id'];
$nav_link = $_POST['nav_link'];
$edit_submit = $_POST['edit_submit'];
$old_csv = $_POST['old_csv'];
$template = $_POST['template'];
$googmap = $_POST['googmap'];


// write changes
if ($edit_submit == 1) {

if (!empty($title)) {
// check for and upload new CSV if found
if (!empty($_FILES['csv_file']['name'])) {
$target_path = CSV_DIRECTORY;
$target_path = $target_path . basename( $_FILES['csv_file']['name']); 
move_uploaded_file($_FILES['csv_file']['tmp_name'], $target_path);
$article_csv = basename($_FILES['csv_file']['name']);
} elseif (!empty($old_csv)) {
$article_csv = $old_csv;
}

// set insert values
$values = array($head_content,$footer_content,$article_csv,$parent_article_id,$link_name,$title_tag,$meta_description,$meta_keywords,$sort_order,$enabled,$title,$form_id,$nav_link,$template,$googmap);
// check for update or insert routine
if (!empty($artid)) {

$sql = 'UPDATE articles SET head_content=?, footer_content=?, article_csv=?, parent_article_id=?, link_name=?, title_tag=?, meta_description=?, meta_keywords=?, sort_order=?, enabled=?, title=?, form_id=?, nav_link=?, template=?, googmap=? WHERE article_id = "'.$artid.'";';

$_SESSION['message'] = 'Article Updated';

// if else insert new article
} else {

$sql = 'INSERT INTO articles (head_content, footer_content, article_csv, parent_article_id, link_name, title_tag, meta_description, meta_keywords, sort_order, enabled, title, form_id, nav_link,template,googmap) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

$_SESSION['message'] = 'New Article Added';

}

// write new data to database
$sth = $db->prepare($sql);
$res = $db->execute($sth,$values);

if (enable_search_engine_friendly_names == 'Y') {
search_engine_htaccess();
}

// redirect to article listing page
header("Location: articles.php".(!empty($parent_article_id) ? '?artid='.$parent_article_id : '' ));
} else {

$error_message = 'You must assign a form title.';
}

}


//pull db set vars if $artid is set
if (!empty($artid)) {

$query = "SELECT article_id, article_csv, head_content, footer_content, parent_article_id, link_name, title_tag, meta_description, meta_keywords, sort_order, enabled, title, form_id, nav_link, template, googmap FROM articles WHERE article_id = '".$artid."';";
$result = $db->query($query);

if (DB::isError($result)){
die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
}

$result_row = $result->fetchRow();

// assign variables
//disabled since not needed $article_id = $result_row[0];
$article_csv = $result_row[1];
$head_content = $result_row[2];
$footer_content = $result_row[3];
$parent_article_id = $result_row[4];
$link_name = $result_row[5];
$title_tag = $result_row[6];
$meta_description = $result_row[7];
$meta_keywords = $result_row[8];
$sort_order = $result_row[9];
$enabled = $result_row[10];
$title = $result_row[11];
$form_id = $result_row[12];
$nav_link = $result_row[13];
$template = $result_row[14];
$googmap = $result_row[15];

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Articles Edit</title>
<?PHP require('includes/header_inc.php'); ?>
<script language="javascript">

function remove_csv(article_id,file_name) {

$.ajax({
   type: "POST",
   url: "remove_csv.php",
   data: "artid="+article_id+"&filename="+file_name,
 });
 
$("#current_file").hide();
 
alert('CSV File Removed');
}

function link_name_check() {

found_cnt = '';
cur_articleid = <?PHP echo (!empty($artid) ? $artid : 0); ?>;
link_name = $("#link_name").val();

if (link_name != '') {
$.ajax({
   type: "POST",
   url: "link_name_chk.php",
   data: "artid="+cur_articleid+"&linkname="+link_name,
   success: function(found_cnt){

if (found_cnt > 0) {
$("#link_error").html('<font color="#FF0000">Link name already exists within database. Please choose another.</font>');
$("#submit_button").hide();
} else {
$("#link_error").html('');
$("#submit_button").show()
}

   }

 });
 
} else {
$("#link_error").html('');
$("#submit_button").show();
}

$("#link_name").val($("#link_name").val().replace(/[^a-zA-Z0-9_-]+/, "-")); 
$("#link_name").val($("#link_name").val().replace(" ", "-")); 
}

function change_link_name(){
$("#link_name").val($("#link_name").val().replace(/[^a-zA-Z0-9_-]+/, "-")); 
$("#link_name").val($("#link_name").val().replace(" ", "-")); 
}
</script>
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
    <td valign="top" class="content_area"><div align="center"><h1>Articles Edit</h1></div>
      <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
        <table align="center" class="form_table">
          <tr>
            <td align="right" valign="top" class="title_column" colspan="2"><div align="center">* indicates required field <?PHP echo '<br><span class="style1">'.$error_message.'</span>'; ?></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column style1">*Title:</td>
            <td class="field_column"><input name="title" type="text" id="title" value="<?PHP echo $title; ?>" size="50" maxlength="180" /></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Status:</td>
            <td class="field_column"><select name="enabled" id="enabled">
            <?PHP
			$enabled_array = array(0 => 'Disabled',1 => 'Enabled');
			foreach($enabled_array as $id => $title) {
			echo '<option value="'.$id.'" '.($enabled == $id ? 'selected="selected"' : '').'>'.$title.'</option>';
			}
			?>
                                      </select>            </td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Sort Order:</td>
            <td class="field_column"><input name="sort_order" type="text" id="sort_order" value="<?PHP echo $sort_order; ?>" size="10" maxlength="10" /></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Display Nav Link:</td>
            <td class="field_column"><input type="checkbox" name="nav_link" id="nav_link" value="1" <?PHP if ($nav_link == 1) echo 'checked'; ?>/></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Allow Google Maps Linking:</td>
            <td class="field_column"><input type="checkbox" name="googmap" id="googmap" value="1" <?PHP if ($googmap == 1) echo 'checked'; ?>/></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Head Content:</td>
            <td class="field_column">
            <?php
$oFCKeditor = new FCKeditor('head_content') ;
$oFCKeditor->BasePath = 'includes/fckeditor/' ;
$oFCKeditor->Value = $head_content;
$oFCKeditor->Create() ;
?>			</td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Footer Content:</td>
            <td class="field_column">
             <?php
$oFCKeditor = new FCKeditor('footer_content') ;
$oFCKeditor->BasePath = 'includes/fckeditor/' ;
$oFCKeditor->Value = $footer_content;
$oFCKeditor->Create() ;
?>           </td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">CSV:</td>
            <td class="field_column"><input type="file" name="csv_file" id="csv_file" /> <?PHP echo (!empty($article_csv) ? '<span id="current_file">Current CSV: ' . $article_csv . '<input name="old_csv" type="hidden" value="'.$article_csv.'" /> <a href="javascript: remove_csv(\''.$artid.'\',\''.$article_csv.'\')">Delete current file</a></span>' : ''); ?></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Parent Article:</td>
            <td class="field_column">
             <?PHP
			 $parent_article_id = (!empty($parid) ? $parid : $parent_article_id);
			 echo parent_category_drop_down($parent_article_id);
			?>
            </td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Form:</td>
            <td class="field_column"><select name="form_id" id="form_id">
            						 <option></option>
            <?PHP
			 
			$query = "SELECT form_id, name FROM forms ;";
			$result = $db->query($query);

			if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
			}

			while ($result_row = $result->fetchRow()) {
			
            echo '<option value="'.$result_row[0].'" '.($form_id == $result_row[0] || $parid == $result_row[0] ? 'selected="selected"' : '').'>'.$result_row[1].'</option>';

			}
			?>

              </select>            </td>
          </tr>

          <tr>
            <td align="right" valign="top" class="title_column">Theme:</td>
            <td class="field_column"><select name="form" id="template">
              						 <option></option>
                                     <?PHP
									 // print template options
									foreach(templates_array_set() as $template_opt) {
									if($template_opt == "." || $template_opt == ".." || $template_opt == "index.php" )
										continue;
										echo '<option'.($template == $template_opt ? ' selected="selected" ' : '').'>'.$template_opt.'</option>';
									}
									 ?>
                                     </select>              </td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="title_column">Search Engine Meta Data</td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Link Name:</td>
            <td class="field_column"><input name="link_name" type="text" id="link_name" onchange="javascript: link_name_check();" onkeyup="javascript: link_name_check();" value="<?PHP echo $link_name; ?>" size="50" maxlength="160" /><div id="link_error"></div></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Title Tag:</td>
            <td class="field_column"><input name="title_tag" type="text" id="title_tag" value="<?PHP echo $title_tag; ?>" size="50" maxlength="255" /></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Meta Description:</td>
            <td class="field_column"><textarea name="meta_description" id="meta_description" cols="45" rows="5"><?PHP echo $meta_description; ?></textarea></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="title_column">Meta Keywords:</td>
            <td class="field_column"><textarea name="meta_keywords" id="meta_keywords" cols="45" rows="5"><?PHP echo $meta_keywords; ?></textarea></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="hidden" name="edit_submit" id="edit_submit" value="1" />
            <input type="submit" name="button" id="submit_button" value="Submit" /></td>
          </tr>
        </table>
      </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?>