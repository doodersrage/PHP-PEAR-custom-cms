<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?PHP 
echo $page_header; 
echo $body_tag
?>
<div class="container">
  <div class="content">
  <?PHP 
  echo $body_content;
  ?>
  </div>
  <div class="cur_loc">
  <?PHP
  echo $bread_crumbs;
  ?>
  </div>
  <div class="header">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20" rowspan="2" class="left_header_border">&nbsp;</td>
        <td width="6%" rowspan="2" class="logo_area"><a href="<?PHP echo SITE_URL; ?>"><img src="<?PHP echo SITE_IMAGES_URL.site_logo_img; ?>" alt="<?PHP echo site_name; ?>" width="60" height="90" border="0" /></a></td>
        <td width="87%" height="60" align="center" class="header_title_logo">&nbsp;</td>
        <td width="20" rowspan="2" align="center" class="right_header_border">&nbsp;</td>
      </tr>
      <tr>
        <td height="50" align="right" valign="middle" class="top_nav">
        <?PHP echo $top_nav; ?>
        </td>
      </tr>
    </table>
  </div>
  
  <div class="footer">
    <?PHP 
	echo $footer_content;
	?>
  </div>
</div>
<?PHP
if (!empty($GLOBALS['warning'])) {
echo '<script language="javascript">alert(\''.$GLOBALS['warning'].'\');</script>';
}
?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("<?PHP echo google_analytics_account_id; ?>");
pageTracker._initData();
pageTracker._trackPageview();
</script>
</body>
</html>