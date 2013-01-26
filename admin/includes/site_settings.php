<?PHP

require ADMIN_INCLUDES_DIRECTORY . '/constants.php';

// update constants static file
function update_constants_file() {
$myFile = ADMIN_INCLUDES_DIRECTORY . "/constants.php";

$fh = fopen($myFile, 'w') or die("can't open file");

$constants_query = mysql_query('SELECT name, value FROM site_settings;');

// write set constants as static variables
$stringData =  "<?PHP" . "\r\n";
while ($constants_result = mysql_fetch_array($constants_query)) {
$stringData .= "define('".$constants_result['name']."','".str_replace(array("\'","'"),"\'",$constants_result['value'])."');" . "\r\n";
}
$stringData .=  "?>";

fwrite($fh, $stringData);
fclose($fh);
}
?>