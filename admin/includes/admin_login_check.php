<?PHP
// this document is used to check if the admin user is logged in
if ($_SESSION['admin_logged_in'] != 1) header('Location: '.SITE_URL.'admin/login.php'); 
?>