<?PHP 
require('includes/application_top.php'); 
require('includes/admin_login_check.php');

$submit = $_POST['submit'];
$user_select = $_POST['user_select'];
$username = $_POST['username'];
$password = $_POST['password'];

switch ($submit) {
case 'Delete':
  mysql_query("DELETE FROM admin_users WHERE id = '".$_POST['user_select']."';");
break;
case 'Edit':
  $query = "SELECT id, username FROM admin_users WHERE id = '".$_POST['user_select']."';";
  $result = $db->query($query);
  if (DB::isError($result)){
	die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
  }
 $result_row = $result->fetchRow();
  $username = $result_row[1];
  $id = $result_row[0];
break;
case 'Update':
	// first check for errors
	if (empty($_POST['username']) || empty($_POST['password'])) { 
	  $error_message = '<center><font color="red">You did not enter a username or password.</font></center>';
	} else {
	  if (!empty($_POST['id'])) {
		  // check for existing username
		  $query = "SELECT count(*) as rcount FROM admin_users WHERE username = '".str_replace("'","\'",$_POST['username'])."' AND id != '".$_POST['id']."';";
		  $result = $db->query($query);
		  if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
		  }
		  $result_row = $result->fetchRow();
		  if ($result_row[0] > 0) {
			$error_message = '<center><font color="red">Username already exists. Please choose another.</font></center>';
			$query = "SELECT id, username FROM admin_users WHERE id = '".$_POST['id']."';";
			$result = $db->query($query);
			if (DB::isError($result)){
			  die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
			}
		   $result_row = $result->fetchRow();
		   $username = $result_row[1];
		   $id = $result_row[0];
		  } else {
			$sql = "UPDATE admin_users SET username = ?, password = ? WHERE id = ?;";
			$values = array($_POST['username'],sha1($_POST['password']),$_POST['id']);
			$sth = $db->prepare($sql);
			$res = $db->execute($sth,$values);
			$username = '';
			$password = '';
			$id = '';
		  }
	  } else {
		  // check for existing username
		  $query = "SELECT count(*) as rcount FROM admin_users WHERE username = '".$_POST['username']."';";
		  $result = $db->query($query);
		  if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
		  }
		  $result_row = $result->fetchRow();
		  if ($result_row[0] > 0) {
			$error_message = '<center><font color="red">Username already exists. Please choose another.</font></center>';
		  } else {
			$sql = "INSERT INTO admin_users (username,password) VALUES (?,?);";
			$values = array($_POST['username'],sha1($_POST['password']));
			$sth = $db->prepare($sql);
			$res = $db->execute($sth,$values);
			$username = '';
			$password = '';
		  }
	  }
	} 
break;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo site_name; ?>: Admin Index</title>
<?PHP require('includes/header_inc.php'); ?>
</head>

<body>
<table width="100%" class="admin_box">
  <tr>
    <td width="150" valign="top" class="left_nav"><?PHP require('includes/menu.php'); ?></td>
    <td valign="top" class="content_area">
    <h1 align="center">User Manager</h1>
    <table width="80%" border="0" align="center" cellpadding="3" cellspacing="3">
      <tr>
        <td width="250" valign="top" bgcolor="#EFEFEF"><form id="form1" name="form1" method="post" action="">
        <center>
          <strong>Edit Existing Users</strong>
        </center>
          <div align="center">
            <select name="user_select" size="6" id="user_select">
	<?PHP
			$query = "SELECT id, username FROM admin_users;";
			$result = $db->query($query);

			if (DB::isError($result)){
			die("Could not query the database: <br />".$query." ".DB::errorMessage($result));
			}

			while ($result_row = $result->fetchRow()) {
			
            echo  '<option value="'.$result_row[0].'">'.$result_row[1].'</option>'."\n";

			}
			
			?>
            </select>
            <br />
            <input type="submit" name="submit" id="button" value="Edit" />
            <input type="submit" name="submit" id="button2" value="Delete" />
          </div>
        </form>        </td>
        <td width="92%" align="center">
        <form id="form2" name="form2" method="post" action="">
          <table border="0" class="new_account">
            <tr>
              <td colspan="2" align="center" bgcolor="#CCCCCC"><?PHP echo $error_message; ?><strong>Add User</strong> </td>
            </tr>
            <tr>
              <td>Username:</td>
              <td><input type="text" name="username" id="username" value="<?PHP echo $username; ?>" /></td>
            </tr>
            <tr>
              <td>Password:</td>
              <td><input type="text" name="password" id="password" value="<?PHP echo $password; ?>" /></td>
            </tr>
            <tr>
              <td colspan="2" align="center" bgcolor="#CCCCCC"><input type="hidden" name="id" id="id" value="<?PHP echo $id; ?>" />                <input type="submit" name="submit" id="button3" value="Update" /></td>
              </tr>
          </table>
            </form>
        </td>
      </tr>
    </table>
    <p align="center">&nbsp;</p>
    </td>
  </tr>
</table>
<?PHP require("includes/application_bottom.php"); ?>