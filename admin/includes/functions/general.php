<?PHP

// print linked articles
function print_article_history($artid) {
global $db, $linked_articles;

	$query = "SELECT article_id, title, parent_article_id FROM articles WHERE article_id = '".$artid."';";
	$result = $db->query($query);

	if (DB::isError($result)){
	die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
	}

	$result_row = $result->fetchRow();

	$linked_articles[] = array($result_row[0] => $result_row[1]);
	

	if (!empty($result_row[2])) {
	print_article_history($result_row[2]);
	}

return $linked_articles;
}		

// print CSV to table in browser
function load_csv($csv_file) {

// load constants file
require(ADMIN_CLASSES_DIRECTORY.'parsecsv.lib.php');

# create new parseCSV object.
$csv = new parseCSV();

$csv->auto(CSV_DIRECTORY.$csv_file);

$csv_output = '
<table border="0" cellspacing="1" cellpadding="3" class="csv_table" id="csv_table">
	<thead><tr>';
		
foreach ($csv->titles as $value) {
$csv_output .= '<th>' . $value . '</th>';
		}
$csv_output .= '</tr></thead>';
foreach ($csv->data as $key => $row) {
$csv_output .= '<tr>';
	foreach ($row as $value) {
	$csv_output .= '<td>' . $value . '</td>';
	}
$csv_output .= '</tr>';
	}
$csv_output .= '</table>';


return $csv_output;
}

function search_engine_htaccess(){
	global $db;

	$HTACCESS=SITE_DIRECTORY.'.htaccess';
	$DELIM_BEGIN='#DYNAMIC URL LIST';
	$DELIM_END="#END DYNAMIC URL LIST";
	$newfilecontent='';
	$errors='';
		if (file_exists($HTACCESS)) {
			$fp=fopen($HTACCESS,"r");
			while (($current_line = fgets($fp)) !== false) {
				$newfilecontent .= $current_line;
			
				if (strpos($current_line,$DELIM_BEGIN)!== false) { 
					while (($trash=fgets($fp)) !==false)
					{ if (strpos($trash,$DELIM_END)!==false) {break ;}} break;}
			}
		} 
		$newfilecontent .=$DELIM_BEGIN."\n";
		$query="SELECT article_id, link_name FROM articles WHERE link_name IS NOT NULL OR link_name <> '';";
		$result = $db->query($query);

			if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
			}

		while ($result_row = $result->fetchRow()) {
			if (ereg("^[A-Za-z0-9-]+$",$result_row[1])) //is it a valid nav_link
			{
				$newfilecontent.="RewriteRule ^". $result_row[1] ."/ /index.php?artid=".$result_row[0]." [QSA,L,NS]\n";
			} else /*your nav_link is broke please fix!*/ {
				$errors.= "nav_link not adding '".$result_row[1]."' because it has invalid characters... <br>\n";
			}
		}
		$newfilecontent.=$DELIM_END."\n";
		if ($fp) /*got to read the rest of the file*/ {
			while (($current_line = fgets($fp)) !== false)
			{
				$newfilecontent .= $current_line;
			}
					fclose($fp);	
		}

		
	$fp=fopen($HTACCESS,'w+');
	fwrite($fp,$newfilecontent);
	fclose($fp);
	return ($errors);
}

function get_search_friendly_name($art_id) {
	global $db;

		$query="SELECT link_name FROM articles WHERE article_id = '".$art_id."';";
		$result = $db->query($query);

			if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
			}

		$result_row = $result->fetchRow();

return $result_row[0];
}


// set templates array
function templates_array_set() {

    $path = TEMPLATES_DIRECTORY;


    // Open the folder
    $dir_handle = @opendir($path) or die("Unable to open $path");


    // Loop through the files
    while($file = readdir($dir_handle)) {
	$files[] = $file;
	}

    // Close
    closedir($dir_handle);

return $files;
}
?>