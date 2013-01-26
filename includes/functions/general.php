<?PHP

// print site link
function write_site_link($link_name,$article_id,$class='',$search_safe_link = '') {

$link = '<a href="'.SITE_URL.(enable_search_engine_friendly_names == 'Y' && !empty($search_safe_link) ? $search_safe_link . '/' : '?artid='.$article_id).'" '.(!empty($class) ? 'class="'.$class.'" ' : '' ).'>'.$link_name.'</a>';

return $link;
}

// print front top nav
function draw_top_nav() {
global $db;

$link_query = "SELECT article_id, title, link_name FROM articles WHERE enabled = 1 AND nav_link = 1 AND (parent_article_id IS NULL OR parent_article_id = '') ORDER BY sort_order DESC;";

$link_result = $db->query($link_query);

$top_nav = '<ul>';

while($link_result_row = $link_result->fetchRow()) {

$top_nav .= '<li>'.write_site_link($link_result_row[1],$link_result_row[0],'button',$link_result_row[2]).'</li>';

}

$top_nav .= '<li><a class="button" href="'.SITE_URL.'">Home</a></li>';

$top_nav .= '</ul>';

return $top_nav;
}

// print front top nav
function draw_left_nav($artid,$artname) {
global $db;

$link_query = "SELECT article_id, title, link_name FROM articles WHERE enabled = 1 AND nav_link = 1 AND parent_article_id = '".$artid."' ORDER BY sort_order ASC;";

$link_result = $db->query($link_query);

$left_nav .= '<div class="left_nav">';
$left_nav .= '<div class="left_nav_title">'.$artname.'</div>';
		
while($link_result_row = $link_result->fetchRow()) {

$left_nav .= write_site_link($link_result_row[1],$link_result_row[0],'',$link_result_row[2]);

}
$left_nav .= '</div>';

return $left_nav;
}

// write user stats to db
function get_user_stats($article_title,$article_id = ''){
	global $db;

// load browser check class file
require(ADMIN_CLASSES_DIRECTORY.'browser.php');
$br = new Browser;

$insert_query = "INSERT INTO article_views (client_ip,referrer,article_title,user_agent,host,browser,operating_system,article_id) VALUES (?,?,?,?,?,?,?,?);";
$insert_vars = array(gethostbyname($_SERVER['REMOTE_ADDR']),$_SERVER['HTTP_REFERER'],$article_title,$_SERVER['HTTP_USER_AGENT'],gethostbyaddr($_SERVER['REMOTE_ADDR']),$br->Name.' '.$br->Version,$br->Platform,$article_id);
$sth = $db->prepare($insert_query);
$res = $db->execute($sth,$insert_vars);
}


// send email
function send_email($fromeml,$comment,$subject) {

//add From: header
$headers = "From: " . contact_email_address . "\r\n";

//specify MIME version 1.0
$headers .= "MIME-Version: 1.0\r\n";

//unique boundary
$boundary = uniqid("HTMLEMAIL");

//tell e-mail client this e-mail contains//alternate versions
$headers .= "Content-Type: multipart/alternative; boundary = $boundary\r\n\r\n";

//plain text version of message
$body = "--$boundary\r\n" .
   "Content-Type: text/plain; charset=ISO-8859-1\r\n" .
   "Content-Transfer-Encoding: base64\r\n\r\n";
$body .= chunk_split(base64_encode(strip_tags($comment)));

//HTML version of message
$body .= "--$boundary\r\n" .
   "Content-Type: text/html; charset=ISO-8859-1\r\n" .
   "Content-Transfer-Encoding: base64\r\n\r\n";
$body .= chunk_split(base64_encode($comment));

//send message
mail($fromeml, $subject, $body, $headers);

}
?>