<?PHP

require ADMIN_INCLUDES_DIRECTORY . '/theme.php';

// update constants static file
function update_theme_file($theme_set) {
$myFile = ADMIN_INCLUDES_DIRECTORY . "/theme.php";

$fh = fopen($myFile, 'w') or die("can't open file");

// write set constants as static variables
$stringData =  "<?PHP" . "\r\n";
$stringData .= "define('current_them_set','".$theme_set."');" . "\r\n";
$stringData .=  "?>";

fwrite($fh, $stringData);
fclose($fh);
}
?>