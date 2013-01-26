<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Server Info</title>
<?PHP require('includes/header_inc.php'); ?>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('includes/menu.php'); ?></td>
    <td valign="top" class="content_area">
    <style type="text/css">
#phpinfo {}
#phpinfo pre {}
#phpinfo a:link {}
#phpinfo a:hover {}
#phpinfo table {}
#phpinfo .center {}
#phpinfo .center table {}
#phpinfo .center th {}
#phpinfo td, th {}
#phpinfo h1 {}
#phpinfo h2 {}
#phpinfo .p {}
#phpinfo .e {}
#phpinfo .h {}
#phpinfo .v {}
#phpinfo .vr {}
#phpinfo img {}
#phpinfo hr {}
</style>

<div id="phpinfo">
<?php

ob_start () ;
phpinfo () ;
$pinfo = ob_get_contents () ;
ob_end_clean () ;

// the name attribute "module_Zend Optimizer" of an anker-tag is not xhtml valide, so replace it with "module_Zend_Optimizer"
echo ( str_replace ( "module_Zend Optimizer", "module_Zend_Optimizer", preg_replace ( '%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo ) ) ) ;
?>
<style type="text/css">
.e, .v {
font-size:12px;
}
img {float:none; border: 0px;}
</style>
    </td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?>