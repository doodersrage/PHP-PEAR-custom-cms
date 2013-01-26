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
        <td valign="top">
        <h1>Articles</h1>
        <p><span class="style1">Article Listing:</span><br />
        <img src="../images/doc_16x16.png" border="0" /> - Click this image to edit an article.<br />
        <br />
		<img src="../images/document-open_22x22.png"  border="0" />
        - Click this image to expand an article group.<br />
        <br />
        Editing an article can be done by directly click the articles name. This applies to grouped and single articles.<br />
        <br />
        Deleting an article or a group of articles can be done by clicking the delete checkbox and then click the <strong>&quot;Delete Selected&quot;</strong> button.<br />
        <br />
        <span class="style1">Other Article Listing information:</span><br />
        <strong>CSV column</strong> displays a link to the CSV assigned to an article.<br />
        <strong>Form column</strong> displays the name of the form assigned to an article.<br />
        <strong>Sort Order column</strong> displays the current sort order number assigned to an article. The article listing is sorted by first the sort order then article title.<br />
        <strong>Status column</strong> displays whether or the article has been enabled.</p>
        <p><span class="style1">Article Edit:</span><br />
          <strong>Title</strong> - The value used for displaying the article within the listing and used as the link names on the sites front end.<br />
          <strong>Status</strong> - Allows you to enable or disable an article.<br />
          <strong>Sort Order</strong> - The order ascending in which article links will be displayed.<br />
          <strong>Display Nav Link</strong> - If this option is left unchecked the article will not be linked to within the front end of the site.<br />
          <strong>Allow Google Maps Linking</strong> - Enable linking to extenal documents required for google maps.<br />
          <strong>Head Content</strong> - Page content area displayed above the CSV and footer content.<br />
          <strong>Footer Content </strong>- Page content to be displayed below the Head Content and CSV.<br />
          <strong>Parent Article</strong> - To group an article with an parent select an article from this list.<br />
          <strong>Form</strong> - To display a user submittable form select a form name from this drop down.<br />
          <strong>Theme</strong> - If you do not want an article to use the sites default theme select a theme name from this drop down.<br />
          <strong>Link Name</strong> - This is the simplified name to be used when linking to the article on the front end of the site. Keep entry letters in lowercase, refrain from using special characters, and use hyphens instead of spaces. Entries should look like this: test-link<br />
          <strong>Title Tag</strong> - This input will assign a special title tag for any article with an assigned value.<br />
          <strong>Meta Description</strong> - This field will populate the meta description tag on the articles view page. Data written into the meta description field is read by search engines and can be used to help describe a page.<br />
          <strong>Meta Keywords</strong> - In this section should be comma separated all lowercase keyword values which describes the content of a page.</p>
        <p><span class="style1">Google Maps:</span><br />
          To use Google maps as it is configured first enable the &quot;Allow Google Maps Linking&quot; option for an article. Then place &lt;div id=&quot;map&quot;&gt;&amp;nbsp;&lt;/div&gt;, &lt;div id=&quot;map1&quot;&gt;&amp;nbsp;&lt;/div&gt; or &lt;div id=&quot;map2&quot;&gt;&amp;nbsp;&lt;/div&gt;into your article. Each map idea corresponds to a different map. Existing map assignments can be edited within the &quot;/googlemaps.js&quot; document.</p>
        <p><span class="style1">Homepage article assignment:<br />
        </span>Any article that is set to the lowest sort order or if sort orders are not assigned the lowest alphabetical order within the root listing of articles will be assigned as the homepage article. If you do not disable the &quot;Display Nav Link&quot; option for this homepage article it will be linked throughout the site making it appear as duplicate content to search engines. <br />
        </p></td>
      </tr>
    </table>
    <p align="center">&nbsp;</p>
    </td>
  </tr>
</table>
<?PHP require("../includes/application_bottom.php"); ?>