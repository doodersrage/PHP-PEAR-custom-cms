<?php

require_once 'DB.php';
#session_start();
function dbconnect() {
	global $db;
	if ( is_object($db) ) {
		return $db;
	}

	$dsn = array(
	    'phptype'  => 'mysql',
		'hostspec' => DB_HOST,
		'database' => DB_DATABASE,
		'username' => DB_USERNAME,
		'password' => DB_PASSWORD
	);
//echo 'test' /*. DB_HOST . DB_DATABASE . DB_USERNAME . DB_PASSWORD*/;
	$db = DB::connect($dsn,true);
	if (DB::isError($db)) {
		die($db->getMessage());
	}
	return $db;
}


define ('DEBUG_ENV', true);
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'handle_pear_error');

function handle_pear_error ($error_obj) {
	echo "</TD></TD></TD></TR></TR></TR></TABLE></TABLE></TABLE></CENTER></CENTER>";
	echo "<HR><H2>Error (Programming exception)</H2>";
	if (DEBUG_ENV) {
		echo "<H3>Information:</H3>";
		echo "<pre>";
		#echo print_r($error_obj);
		#echo "</pre>";
		#echo "<hr>\n";
		die ("<B>Error:</B><BR>".$error_obj->getMessage()."<BR>\n<B>Debug:</B><BR>".$error_obj->getDebugInfo());
	} else {
		die ('Sorry you request can not be processed now. Try again later');
	}
}


?>