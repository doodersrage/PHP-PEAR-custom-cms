<?PHP 
require('admin/includes/application_top.php'); 
// load general functions
require(FUNCTIONS_DIRECTORY.'general.php');
// load template functions
require(FUNCTIONS_DIRECTORY.'templates.php');

		switch ($_GET['errorid']) {
		case 404:
			$error_content = fof_error_page;
		break;
		case 401:
			$error_content = foi_error_page;
		break;
		case 403:
			$error_content = foe_error_page;
		break;
		}	

// load page header
$page_header = load_header('','','Hyperion Inc.: Error Page','','error-page');
// load top nav
$top_nav = draw_top_nav();
// load body tag
$body_tag = load_body_tag('error-page');
// set body content
$body_content = page_body('','',$error_content,'');
// set breadcrumbs
$bread_crumbs = print_breadcrumbs('');
// set footer value
$footer_content = set_footer_content(1);

// load template file
require(TEMPLATES_DIRECTORY.current_them_set.'/index.php');
?>