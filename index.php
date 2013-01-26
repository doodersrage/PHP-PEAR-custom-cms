<?PHP 
require('admin/includes/application_top.php'); 
// load general functions
require(FUNCTIONS_DIRECTORY.'general.php');
// load template functions
require(FUNCTIONS_DIRECTORY.'templates.php');
// load form handler functions
require(FUNCTIONS_DIRECTORY.'form_handler.php');

// get page vars
$artid = (int)$_GET['artid'];
$dyn_form_submit = $_POST['dyn_form_submit'];

// process dynamic form if submitted
if ($dyn_form_submit == 1) {

process_form($_POST);

}

if (empty($artid)) {

$check_query = "SELECT article_id FROM articles WHERE enabled = 1 AND (parent_article_id IS NULL OR parent_article_id = '') ORDER BY sort_order ASC;";

$check_result = $db->query($check_query);

if (DB::isError($result)){
die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
}

while($check_result_row = $check_result->fetchRow()) {

$found_cnt = mysql_num_rows(mysql_query("SELECT article_id FROM articles WHERE parent_article_id = '".$check_result_row[0]."';"));

if ($found_cnt == 0) {
$found_art_id = $check_result_row[0];
break;
}
}

$query = "SELECT article_id, article_csv, head_content, footer_content, parent_article_id, link_name, title_tag, meta_description, meta_keywords, sort_order, enabled, title, form_id, nav_link, template, googmap FROM articles WHERE article_id = '".$found_art_id."';";

// if artid is set load selected page
} else {

$query = "SELECT article_id, article_csv, head_content, footer_content, parent_article_id, link_name, title_tag, meta_description, meta_keywords, sort_order, enabled, title, form_id, nav_link, template, googmap FROM articles WHERE article_id = '".$artid."';";

}

$result = $db->query($query);

if (DB::isError($result)){
die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
}

$result_row = $result->fetchRow();

// assign variables
$article_csv = $result_row[1];
$head_content = $result_row[2];
$footer_content = $result_row[3];
$parent_article_id = $result_row[4];
$link_name = $result_row[5];
$title_tag = $result_row[6];
$meta_description = $result_row[7];
$meta_keywords = $result_row[8];
$sort_order = $result_row[9];
$enabled = $result_row[10];
$title = $result_row[11];
$form_id = $result_row[12];
$nav_link = $result_row[13];
$template = $result_row[14];
$googmap = $result_row[15];

// capture user info
get_user_stats($title,$artid);


// load page header
$page_header = load_header($meta_keywords,$meta_description,$title_tag,$article_csv,$title,$googmap);
// load top nav
$top_nav = draw_top_nav();
// load body tag
$body_tag = load_body_tag($title,$googmap);
// set body content
$linked_articles = '';
$body_content = page_body($artid,$article_csv,$head_content,$footer_content,$form_id);
// set breadcrumbs
$linked_articles = '';
$bread_crumbs = print_breadcrumbs($artid);
// set footer value
$footer_content = set_footer_content($artid);

// start output buffer
ob_start('ob_gzhandler');

// load template file
require(TEMPLATES_DIRECTORY.'/'.(!empty($template) ? $template : current_them_set).'/index.php');

// flush output buffer
ob_end_flush();

?>