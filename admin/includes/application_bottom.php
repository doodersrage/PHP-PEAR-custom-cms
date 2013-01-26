<?PHP

// print alert message is message global has been set

if ($_SESSION['message']) {

echo '<script type="javascript">alert('.$_SESSION['message'].');</script>';

// unset session var
unset($_SESSION['message']);

}

?>

</body>
</html>