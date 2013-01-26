<?PHP 
require('admin/includes/application_top.php'); 
// load general functions
require(FUNCTIONS_DIRECTORY.'general.php');
// load template functions
require(FUNCTIONS_DIRECTORY.'templates.php');
// capture user info
get_user_stats('HTML SITEMAP');

$sitemap_content_ext = '';

		function write_sitemap_subs($artid) {
		global $db,$sitemap_content_ext;
						
				$link_sub_query = "SELECT article_id, title, link_name FROM articles WHERE enabled = 1 AND nav_link = 1 AND parent_article_id = '".$artid."' ORDER BY sort_order ASC;";
		
				$link_sub_result = $db->query($link_sub_query);
				
				$result_count = mysql_num_rows(mysql_query($link_sub_query));
				if ($result_count > 0) {
				$sitemap_content_ext .= '<ul>'."\n";
		
				while($link_sub_result_row = $link_sub_result->fetchRow()) {
		
				$sitemap_content_ext .= '<li>'.write_site_link($link_sub_result_row[1],$link_sub_result_row[0],'',$link_sub_result_row[2])."\n";
				
//				  $child_assign_query_check = "SELECT article_id FROM articles WHERE parent_article_id = '".$link_sub_result_row[0]."';";
//				  $child_assign_result = $db->query($child_assign_query_check);
//				  $child_assign_result_row = $child_assign_result->fetchRow();
				  
//				if ($child_assign_result_row[0] > 0) {
				write_sitemap_subs($link_sub_result_row[0]);
//				}
				
				$sitemap_content_ext .= '</li>'."\n";

				}
				
				$sitemap_content_ext .= '</ul>'."\n";
				} else {
				$sitemap_content_ext .= '<br>'."\n";
				}
				
		return $sitemap_content_ext;
		}
		
		$link_query = "SELECT article_id, title, link_name FROM articles WHERE enabled = 1 AND nav_link = 1 AND (parent_article_id IS NULL OR parent_article_id = '') ORDER BY sort_order ASC;";
		
		$link_result = $db->query($link_query);
		
		$sitemap_content = '<table align="center"><tr><td>'."\n";
		
		while($link_result_row = $link_result->fetchRow()) {
		
		$sitemap_content .= write_site_link($link_result_row[1],$link_result_row[0],'',$link_result_row[2])."\n";
		
		$sitemap_content_ext = '';
		$sitemap_content .= write_sitemap_subs($link_result_row[0]);
		
		}
		
		$sitemap_content .= '</td></tr></table>'."\n";
		

// load page header
$page_header = load_header('','',site_name.': Sitemap','','sitemap');
// load top nav
$top_nav = draw_top_nav();
// load body tag
$body_tag = load_body_tag('sitemap');
// set body content
$body_content = page_body('','',$sitemap_content,'');
// set breadcrumbs
$bread_crumbs = print_breadcrumbs('');
// set footer value
$footer_content = set_footer_content(1);

// load template file
require(TEMPLATES_DIRECTORY.current_them_set.'/index.php');
?>