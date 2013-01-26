<?PHP require('../includes/application_top.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Admin Index</title>
<link href="../includes/styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-style: italic;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('../includes/menu.php'); ?></td>
    <td valign="top" class="content_area">
    <h1 align="center">Documentation</h1>
    <table width="100%" border="1" align="center" cellpadding="3" cellspacing="3">
      <tr>
        <td width="8%" valign="top" bgcolor="#EFEFEF">
        <? require('docmenu.php'); ?></td>
        <td>
        <h1>Forms</h1>
        <p>Within this section you can create forms, form questions and review responses.<br />
        </p>
          <p><span class="style1">Adding a new form:</span><br />
          1. Click the &quot;New Form&quot; link. <br />
          2. Populate the form name and form the optional description field.<br />
          3. If you would like to receive an email each time a form has been filled out enter your email address into the &quot;Reply To Email Addresses&quot; field. You can have the results forwarded to multiple addresses by entering as many as you want separating each by a semi-colin.<br />
            <br />
            <span class="style1">Adding Questions to a form:</span><br />
          1. Click the "# Questions" count link.<br />
          2. Click the "New Question" link.<br />
          3. Fill in the fields as required for the question you would like to add.<br />
          4. Question types include: checkbox ,textbox ,textarea ,radiobutton<br />
          <br />
          <span class="style1">Edit a question or form:</span><br />
          1. Simply click the name of the question or form within the form or question view.</p>
          <p><span class="style1">Creating an array of checkboxes or radiobuttons:</span><br />
            1. Select question type checkbox or radiobutton<br />
              2. Enter the values you would like to have assigned to each selectable checkbox or radio button separated by line breaks. (Each line will equal one option)<br />
          </p></td>
      </tr>
    </table>
    <p align="center">&nbsp;</p>
    </td>
  </tr>
</table>
<?PHP require("../includes/application_bottom.php"); ?>