<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?PHP 
echo $page_header; 
echo $body_tag
?>
<div id="container">
	<!-- header -->
    <div id="header">
    	<div id="logo"><a href="#"><span class="orange"><?PHP echo site_name; ?></span></a></div>
        <div id="menu">
		<?PHP
        echo $top_nav;
        ?>
        </div>
    </div>
    <!--end header -->
    <!-- main -->
    <div id="main">
        <div id="content">
        <div id="head_image">
        	<div id="slogan"><strong> </strong></div>
            <div id="under_slogan_text"> </div>
        </div>
        <div id="text">
	  <?PHP 
      echo $body_content;
      ?>
       </div>
       </div>
    </div>
    <!-- end main -->
    <!-- footer -->
    <div id="footer">
  	<div id="left_footer">
	<?PHP 
    echo $footer_content;
    ?>
    </div>
    </div>
    <!-- end footer -->
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
