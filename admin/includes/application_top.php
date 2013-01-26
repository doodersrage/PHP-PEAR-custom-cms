<?PHP

// disable magic quotes if enabled
if (get_magic_quotes_gpc()) {
   function stripslashes_deep($value)
   {
       $value = is_array($value) ?
                   array_map('stripslashes_deep', $value) :
                   stripslashes($value);

       return $value;
   }

   $_POST = array_map('stripslashes_deep', $_POST);
   $_GET = array_map('stripslashes_deep', $_GET);
   $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
   $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}


// load config file
require('config.php');
// load db connection script
require('dbcon.php');
// connect to configured db
dbconnect();

// load constants file
require('site_settings.php');

// load theme settings file
require('theme_settings.php');

// load general function file
require(ADMIN_FUNCTIONS_DIRECTORY.'general.php');
?>