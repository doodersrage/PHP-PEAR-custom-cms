<?PHP
require('includes/application_top.php'); 

// run login attempt
if ($_POST['try_login'] == 1) {
	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		  $query = "SELECT count(*) as rcount FROM admin_users WHERE username = '".str_replace("'","\'",$_POST['username'])."' AND password = '".sha1($_POST['password'])."';";
		  $result = $db->query($query);
		  if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
		  }
		  $result_row = $result->fetchRow();
		  if ($result_row[0] > 0) {
			$_SESSION['admin_logged_in'] = 1;
			header('Location: '.SITE_URL.'admin/');
		  } else {
			$error = '<center><font color="red">Login information does not appear to match.</font></center>';	
		  }
		
	} else {
		$error = '<center><font color="red">You did not enter a username or a password.</font></center>';	
	}
}
// clear session data
if($_GET['mode'] == 'log_off') {
  session_destroy();
  session_start();
  $error = '<center><font color="red">You have successfully logged out.</font></center>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login Page</title>
<style>
body {
	font-family:Arial, Helvetica, sans-serif;
}
.login_form {
	border:1px solid #666;
}
.login_form th {
	background:#EEE;
	padding:5px;
	font-weight:700;
	font-size:16px;
}
.login_form td {
	padding:5px;
	font-size:12px;
	border-top:1px solid #999;
	background:#F7F7F7;
}
</style>
</head>

<body>
<?PHP echo $error; ?>
<form id="form1" name="form1" method="post" action="">
<table class="login_form" width="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th colspan="2" align="center">Site Admin Login</th>
  </tr>
  <tr>
    <td align="right">Username:</td>
    <td><input type="text" name="username" id="username" /></td>
  </tr>
  <tr>
    <td align="right">Password:</td>
    <td><input type="password" name="password" id="password" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="hidden" name="try_login" id="try_login" value="1" />      <input type="submit" name="button" id="button" value="Login" /></td>
  </tr>
</table>
</form>
</body>
</html>