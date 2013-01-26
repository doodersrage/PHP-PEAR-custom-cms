<?PHP
require('includes/application_top.php');

// set vars
$artid = $_POST['artid'];
$linkname = $_POST['linkname'];

if (!empty($artid)) {
$sql = "SELECT article_id FROM articles WHERE link_name = '".str_replace("'","''",$linkname)."' AND article_id <> '".$artid."';";
} else {
$sql = "SELECT article_id FROM articles WHERE link_name = '".str_replace("'","''",$linkname)."';";
}

$match_cnt = mysql_num_rows(mysql_query($sql));

echo $match_cnt;
?>