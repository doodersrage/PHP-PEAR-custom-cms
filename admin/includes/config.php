<?PHP
// directory settings
define('SITE_DIRECTORY','/home3/dir/public_html/');
define('ADMIN_DIRECTORY',SITE_DIRECTORY.'admin/');
define('ADMIN_INCLUDES_DIRECTORY',ADMIN_DIRECTORY.'includes/');
define('ADMIN_CLASSES_DIRECTORY',ADMIN_INCLUDES_DIRECTORY.'classes/');
define('ADMIN_FUNCTIONS_DIRECTORY',ADMIN_INCLUDES_DIRECTORY.'functions/');
define('FUNCTIONS_DIRECTORY',SITE_DIRECTORY.'includes/functions/');
define('CLASSES_DIRECTORY',SITE_DIRECTORY.'includes/classes/');
define('TEMPLATES_DIRECTORY',SITE_DIRECTORY.'includes/templates/');
define('CSV_DIRECTORY',SITE_DIRECTORY.'csvfiles/');
define('IMAGES_DIRECTORY',SITE_DIRECTORY.'images/');

// site link settings
define('SITE_URL','http://www.domain.com/');
define('SITE_URL_SSL','https://www.domain.com/');
define('SITE_IMAGES_URL',SITE_URL.'images/');
define('SITE_CSV_URL',SITE_URL.'csvfiles/');

// database settings
define('DB_HOST','localhost');
define('DB_DATABASE','db');
define('DB_USERNAME','user');
define('DB_PASSWORD','pass');

// sets session sace path
ini_set( "session.save_path", ADMIN_DIRECTORY."sessions/" );
session_start();

if (empty($pear_set)) {
  // set Pear directory
  ini_set("include_path", (ADMIN_INCLUDES_DIRECTORY."PEAR/" . ini_get("include_path")));
  $pear_set = 1;
}
?>
