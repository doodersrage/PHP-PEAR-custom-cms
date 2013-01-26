<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cz">

<?PHP 
echo $page_header; 
echo $body_tag
?>
	<div id="WholePage">

		    <div id="Inner">
			<div id="Container">
			
		
					<div id="Head">
					
                        <div id="Menu">
							<?PHP
                            echo $top_nav;
                            ?>
						</div>
						
					</div>
					
					<div id="TopPart">
					
					    <div id="Top_left">
					    <span class="company"><?PHP echo site_name; ?></span><br/>
					    <a class="link" href="<?PHP echo SITE_URL; ?>"><span><?PHP echo SITE_URL; ?></span></a>
						</div>
						<div id="Top_right">
						<span class="first_line"> </span><br/>
						<span class="second_line">Welcome</span><br/>
						<span class="third_line"> </span>
						</div>

					</div>
					
					<div id="CentralPart">

					    <div id="FillContent">
					  <?PHP 
                      echo $body_content;
                      ?>
					    </div>
						
                        <div class="cleaner"></div>
					<div id="Bottom">
						<?PHP 
                        echo $footer_content;
                        ?>
						</div>

					</div>

			</div>
			</div>
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
