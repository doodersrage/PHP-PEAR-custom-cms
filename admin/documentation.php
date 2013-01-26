<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Admin Index</title>
<?PHP require('includes/header_inc.php'); ?>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('includes/menu.php'); ?></td>
    <td valign="top" class="content_area">
    <h1 align="center">Documentation</h1>
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="3">
      <tr>
        <td width="8%" valign="top" bgcolor="#EFEFEF">
        <? require('documentation/docmenu.php'); ?>        </td>
        <td width="92%">&nbsp;</td>
      </tr>
    </table>
    <p align="center">&nbsp;</p>
    </td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?>