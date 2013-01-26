<p align="center"><img src="<?PHP echo SITE_IMAGES_URL.site_logo_img; ?>" alt="Hyperion, Inc logo" width="60" height="90" border="0" /></p>
<div class="admin_menu">
<p><a href="<?PHP echo SITE_URL; ?>admin/articles.php">Articles</a></p>
<p><a href="<?PHP echo SITE_URL; ?>admin/forms_view.php">Forms</a></p>
<p class="menu">Article Views</p>
<table>
  <tbody><tr>
    <td class="settings_nav"> <div class="global_group" onclick="document.location.href='article_views.php?view=1'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"><strong>Browser Views</strong><br>
        Provides a list of browsers used.<br>
    </div>
    <div class="global_group" onclick="document.location.href='article_views.php?view=2'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"><strong>Operating Systems</strong><br>
      Provides a list of operating systems used.<br>
    </div>
    <div class="global_group" onclick="document.location.href='article_views.php?view=3'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"><strong>Hosts</strong><br>
      Provides a list of hosts used.<br>
    </div>
    <div class="global_group" onclick="document.location.href='article_views.php?view=5'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"><strong>Article Views</strong><br>
      Displays hits per article.<br>
    </div>
    </td>
  </tr>
</tbody></table>
<p class="menu">Global Settings</p>
<table>
  <tr>
    <td class="settings_nav"> <?PHP
			$query = "SELECT site_settings_groups_id, name, description FROM site_settings_groups;";
			$result = $db->query($query);

			if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
			}

			while ($result_row = $result->fetchRow()) {
			
            echo   '<div class="global_group" onclick="document.location.href=\'global_settings.php?groupid='.$result_row[0].'\'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"><strong>'.$result_row[1].'</strong><br>';
            echo   $result_row[2].'<br></div>';

			}
			
			?></td>
  </tr>
</table>
<p><a href="<?PHP echo SITE_URL; ?>admin/theme_directory.php">Site Theme</a></p>
<p><a href="<?PHP echo SITE_URL; ?>admin/documentation.php">Documentation</a></p>
<p><a href="<?PHP echo SITE_URL; ?>admin/server_info.php">Server Info</a></p>
<p><a href="<?PHP echo SITE_URL; ?>admin/user_config.php">Admin Users</a></p>
<p><a href="<?PHP echo SITE_URL; ?>admin/login.php?mode=log_off">Log Off</a></p>
</div>
