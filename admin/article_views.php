<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');
$view = $_GET['view'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Admin Index</title>
<?PHP require('includes/header_inc.php'); ?>
<script type="text/javascript" src="includes/jqchart/includes/json.js"></script>
<script type="text/javascript" src="includes/jqchart/includes/chartplugin.js"></script>
<script type="text/javascript" src="includes/jqchart/includes/excanvas.js"></script>
<script type="text/javascript" src="includes/jqchart/includes/wz_jsgraphics.js"></script>
<script type="text/javascript" src="includes/jqchart/includes/chart.js"></script>

<script type="text/javascript" src="includes/jqchart/includes/canvaschartpainter.js"></script>
<script type="text/javascript" src="includes/jqchart/includes/jgchartpainter.js"></script>
<link rel="stylesheet" type="text/css" href="includes/jqchart/styles.css" />
<link rel="stylesheet" type="text/css" href="includes/jqchart/includes/canvaschart.css" />
<?

// assign bar color array
$colors[] = '#FF00FF';
$colors[] = '#990000';
$colors[] = '#00FFFF';
$colors[] = '#FFFF00';
$colors[] = '#0000FF';
$colors[] = '#00FF00';
$colors[] = '#999999';

switch ($view){
case 1:
$chart_script = draw_browser_views();
break;
case 2:
$chart_script = draw_operating_systems();
break;
case 3:
$chart_script = draw_host_views();
break;
case 4:
$chart_script = draw_user_agent();
break;
case 5:
$chart_script = draw_article_views();
break;
}

function draw_browser_views(){
global $db;

$query="SELECT DISTINCT browser, count(browser) as cnt FROM article_views GROUP BY browser ORDER BY cnt DESC;";
$result = $db->query($query);

if (DB::isError($result)){
die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
}

while($result_row = $result->fetchRow()) {

$browser[] = $result_row[0];
$bcount[] = $result_row[1];
}

$chart_out = draw_chat_script($browser,$bcount,'Browser');
draw_chart($browser,$bcount);

return $chart_out;
}

function draw_operating_systems(){
global $db;

$query="SELECT DISTINCT operating_system, count(operating_system) as cnt FROM article_views GROUP BY operating_system ORDER BY cnt DESC;";
$result = $db->query($query);

if (DB::isError($result)){
die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
}

while($result_row = $result->fetchRow()) {

$browser[] = $result_row[0];
$bcount[] = $result_row[1];
}

$chart_out = draw_chat_script($browser,$bcount,'Operating System');
draw_chart($browser,$bcount);

return $chart_out;
}

function draw_host_views(){
global $db;

$query="SELECT DISTINCT host, count(host) as cnt FROM article_views GROUP BY host ORDER BY cnt DESC;";
$result = $db->query($query);

if (DB::isError($result)){
die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
}

while($result_row = $result->fetchRow()) {

$browser[] = $result_row[0];
$bcount[] = $result_row[1];
}

$chart_out = draw_chat_script($browser,$bcount,'Host');
draw_chart($browser,$bcount);

return $chart_out;
}

function draw_user_agent(){
global $db;

$query="SELECT DISTINCT user_agent, count(user_agent) as cnt FROM article_views GROUP BY user_agent ORDER BY cnt DESC;";
$result = $db->query($query);

if (DB::isError($result)){
die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
}

while($result_row = $result->fetchRow()) {

$browser[] = $result_row[0];
$bcount[] = $result_row[1];
}

$chart_out = draw_chat_script($browser,$bcount,'User Agent');
draw_chart($browser,$bcount);

return $chart_out;
}

function draw_article_views(){
global $db;

$query="SELECT DISTINCT article_title, count(article_title) as cnt FROM article_views GROUP BY article_title ORDER BY cnt DESC;";
$result = $db->query($query);

if (DB::isError($result)){
die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
}

while($result_row = $result->fetchRow()) {

$browser[] = $result_row[0];
$bcount[] = $result_row[1];
}

$chart_out = draw_chat_script($browser,$bcount,'Article Title');
draw_chart($browser,$bcount);

return $chart_out;
}

function draw_chat_script($names,$data,$label) {
global $colors;

$chart_script = '<script type="text/javascript">'."\n";
$chart_script .= '$(document).ready(function() {'."\n";
$chart_script .= '$(\'#mychart\')'."\n";
$chart_script .= '.chartInit({"painterType":"jsgraphics","backgroundColor":"","textColor":"","axesColor":"","yMin":"0","yMax":"50","xGrid":"0","yGrid":"10","xLabels":['.$name_string.'],"showLegend":false})'."\n";

$color_cnt=0;
$color_count = count($colors);
foreach($names as $id => $xnames){
if ($color_cnt >= $color_count) $color_cnt = 0;
$chart_script .= '.chartAdd({"label":"'.$xnames.'","type":"Bar","color":"'.$colors[$color_cnt].'","values":['.$data[$id].']})'."\n";
$color_cnt++;
}

$chart_script .= '.chartClear()'."\n".
'.chartDraw();'."\n";
$chart_script .= '});'."\n";
$chart_script .= '</script>'."\n";

return $chart_script;
}

function draw_chart($col_title,$col_vals) {
global $csv_output;

$csv_output = '
<table border="0" cellspacing="1" cellpadding="3" class="csv_table" id="csv_table">
	<thead><tr><th>Title</th><th>Value</th></tr></thead>';
foreach ($col_title as $key => $row) {
$csv_output .= '<tr>';
	$csv_output .= '<td>' . $row . '</td>';
	$csv_output .= '<td>' . $col_vals[$key] . '</td>';
$csv_output .= '</tr>';
	}
$csv_output .= '</table>';

}


if (!empty($chart_script)) { 
?>

<?PHP echo $chart_script; ?>

<?PHP } ?>

<script language="javascript" >
function rowOverEffect(object) {
  if (object.className == 'global_group') object.className = 'global_groupover';
}

function rowOutEffect(object) {
  if (object.className == 'global_groupover') object.className = 'global_group';
}
</script>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('includes/menu.php'); ?></td>
    <td valign="top" class="content_area">
    <div align="center">
      <h1>Article Views</h1>
    </div>
      <form enctype="multipart/form-data" id="form1" name="form1" action="global_settings.php?groupid=" method="post">
        <table width="100%">
          <tbody><tr>
            <td valign="top">
				<div id="mychart" class="chart" style="width: 900px; height: 500px;"></div>
                <?PHP
				echo $csv_output;
				?>
                        </td>
          </tr>
        </tbody></table>
      </form>
    <p>&nbsp;</p>
    </td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?>