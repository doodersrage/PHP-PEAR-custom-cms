<?PHP

// write page header
function load_header($meta_keywords = '',$meta_description = '',$title_tag = '',$article_csv = '',$title = '',$googmap = '') {
	global $article_csv;
	
$header = '<head>'."\n";
$header .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n";
$header .= '<meta name="keywords" content="'.(empty($meta_keywords) ? default_keyword_meta : $meta_keywords).'" />'."\n";
$header .= '<meta name="description" content="'.(empty($meta_description) ? default_description_meta : $meta_description).'" />'."\n";
$header .= '<title>'.(empty($title_tag) ? default_title_tag : $title_tag).'</title>'."\n";
$header .= '<base href="' . SITE_URL . '" />'."\n";
$header .= (current_them_set == 'default' ? '<link href="includes/global.css" rel="stylesheet" type="text/css" />'."\n" : '<link href="includes/templates/'.current_them_set.'/global.css" rel="stylesheet" type="text/css" />'."\n");
$header .= '<link href="includes/table.css" rel="stylesheet" type="text/css" />'."\n";
if (!empty($article_csv)) {
  $header .= '<script type="text/javascript" src="includes/jquery-1.2.6.min.js"></script>'."\n";
  $header .= '<script type="text/javascript" src="includes/jquery.tablesorter.min.js"></script>'."\n";
}

if ($googmap == 1) {

$header .= '<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='.google_maps_acc.'" type="text/javascript"></script>'."\n";
$header .= '<script src="googlemaps.js" type="text/javascript"></script>'."\n";

}

if (!empty($article_csv)) {

$header .= '<script>'."\n";
$header .= '$(document).ready(function() { '."\n";
$header .= '    // call the tablesorter plugin '."\n";
$header .= '    $("table").tablesorter({ '."\n";
$header .= '        // sort on the first column and third column, order asc '."\n";
$header .= '        sortList: [[0,0],[2,0]] '."\n";
$header .= '    }); '."\n";
$header .= '}); '."\n";
$header .= '</script>'."\n";

}

$header .= '</head>'."\n";

return $header;
}

// write page body tag
function load_body_tag($title = '',$googmap = ''){

$body = '<body'.($googmap == 1 ? ' onload="load()" onunload="GUnload()"' : '').'>';

return $body;
}

// write page body
function page_body($artid='',$article_csv='',$head_content='',$footer_content='',$form_id = '') {
global $db;

  $child_query_check = "SELECT parent_article_id FROM articles WHERE article_id = '".$artid."';";
  $child_result = $db->query($child_query_check);
  $child_result_row = $child_result->fetchRow();

  $child_assign_query_check = "SELECT article_id FROM articles WHERE parent_article_id = '".$artid."';";
  $child_assign_result = $db->query($child_assign_query_check);
  $child_assign_result_row = $child_assign_result->fetchRow();

  if (($child_result_row[0] > 0 || $child_assign_result_row[0] > 0) && !empty($artid)) {

$page_body = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="24%" valign="top" class="left_content">';

		// print left nav
		if (!empty($artid)) {
		$article_history_list = print_article_history($artid);
		
		if (is_array($article_history_list)) {
		arsort($article_history_list);
		
		foreach($article_history_list as $cur_hist_item) {
		foreach($cur_hist_item as $art_id => $art_name) {
		  
		  $child_query_check = mysql_num_rows(mysql_query("SELECT article_id FROM articles WHERE parent_article_id = '".$art_id."';"));

		if (!empty($art_id) && $child_query_check > 0) $page_body .= draw_left_nav($art_id,$art_name);
		}}
		}
		}

$page_body .= '</td>
        <td width="76%" valign="top" class="right_content">';

          $page_body .= $head_content;
		  
		  // load form if assigned
		  if (!empty($form_id)) {
          $page_body .= load_form($form_id); 
		  }
		  
		  // load csv if assigned
		  if (!empty($article_csv)) { 
          $page_body .= load_csv($article_csv); 
		  }
          $page_body .= $footer_content; 

$page_body .= '</td>
      </tr>
    </table>';

  } else {
$page_body .= $head_content; 
  // load form if assigned
  if (!empty($form_id)) {
  $page_body .= load_form($form_id); 
  }
  // load csv if assigned
  if (!empty($article_csv)) { 
$page_body .= load_csv($article_csv); 
  }
$page_body .= $footer_content; 
  }

return $page_body;
}

function print_breadcrumbs($artid=''){


// print breadcrumbs
	if (!empty($artid)) {
		$breadcrumbs .= '<a href="'.SITE_URL.'">HOME</a>';
		$article_history_list = print_article_history($artid);
	
	if (is_array($article_history_list)) {
	arsort($article_history_list);
	
	foreach($article_history_list as $cur_hist_item) {
	foreach($cur_hist_item as $art_id => $art_name) {
		
		if (enable_search_engine_friendly_names == 'Y') $search_friendly_name = get_search_friendly_name($art_id);
	
	if (!empty($art_id)) $breadcrumbs .= ' <img src="../images/nav_arrow.gif" width="10" height="10" /> ' . write_site_link($art_name,$art_id,'',$search_friendly_name);
	}}
	}
	}
	
return $breadcrumbs;
}

function set_footer_content($artid = ''){

	$footer_content = footer_area_content;
	
	if (empty($artid)) {
		$footer_content = str_replace('{$sitemap}',' | <a href="http://www.hyperioninc.com/sitemap.html">Sitemap</a>',$footer_content);
	} else {
		$footer_content = str_replace('{$sitemap}','',$footer_content);
	}
	
return $footer_content; 
}
?>