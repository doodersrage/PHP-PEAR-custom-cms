<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');

$set_theme = $_GET['set_theme'];

if (!empty($set_theme)) {

update_theme_file($set_theme);

header("Location: theme_directory.php");

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Theme Setting</title>
<?PHP require('includes/header_inc.php'); ?>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('includes/menu.php'); ?></td>
    <td valign="top" class="content_area" align="center">
    <h1>Theme Setting</h1>
    <p>The theme selection made here will be used as the default when loading articles on the front end of the site.</p>
    <table><tr><td>
    <?
	$directory_listing = templates_array_set();


    // Loop through the files
    foreach($directory_listing as $cur_dir) {


    if($cur_dir == "." || $cur_dir == ".." || $cur_dir == "index.php" )

        continue;

        echo "<div style='float:left;padding:8px;'><a href=\"?set_theme=$cur_dir\"><img border='0' src='".SITE_URL."includes/templates/".$cur_dir."/thumbnail.jpg'</a><br /><center><strong>$cur_dir".(current_them_set == $cur_dir ? " (Selected) " : "")."</strong></center></div>";

    }

?>
	</td></tr></table>
    </td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?> 