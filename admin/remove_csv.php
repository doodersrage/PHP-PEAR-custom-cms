<?PHP
require('includes/application_top.php');

// set vars
$artid = $_POST['artid'];
$filename = $_POST['filename'];

// remove article CSV value
$values = array($artid);
$sql = "UPDATE articles SET article_csv=NULL WHERE article_id = ?;";
$sth = $db->prepare($sql);
$res = $db->execute($sth,$values);

// remove selected file from server
unlink(CSV_DIRECTORY.$filename);
?>