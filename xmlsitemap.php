<?PHP 
require('admin/includes/application_top.php'); 

header('Content-Type: text/xml');

function draw_xml_link($art_id,$search_safe_name = '') {

$link = SITE_URL.(!empty($search_safe_name) && enable_search_engine_friendly_names == 'Y' ? $search_safe_name.'/' : 'index.php?artid='.$art_id);

return $link;
}


// print sitemap header
echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
echo '<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">'."\n";

// prints link to landing page

	echo "\t".'<url>'."\n";
	echo "\t"."\t".'<loc>'.SITE_URL.'</loc>'."\n";
	echo "\t".'</url>'."\n";

$link_query = "SELECT article_id, link_name, modified FROM articles WHERE enabled = 1 AND nav_link = 1;";

$link_result = $db->query($link_query);

while($link_result_row = $link_result->fetchRow()) {
	echo "\t".'<url>'."\n";
	echo "\t"."\t".'<loc>'.draw_xml_link($link_result_row[0],$link_result_row[1]).'</loc>'."\n";
	echo "\t"."\t".'<lastmod>'.date("Y-m-d",strtotime($link_result_row[2])).'</lastmod>'."\n";
	echo "\t".'</url>'."\n";
}

// print sitemap footer
echo '</urlset>'."\n";
?>