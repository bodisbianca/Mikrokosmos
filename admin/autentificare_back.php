<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'mikrokosmos';


$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) 
{
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ($stmt = $con->prepare('SELECT id_admin, parola FROM administratori WHERE username = ?')) 
{
	$stmt->bind_param('s', $_POST['username-login']);
	$stmt->execute();
	
	$stmt->store_result();
	if ($stmt->num_rows > 0) 
	{
		$stmt->bind_result($id, $password);
		$stmt->fetch();

		if (password_verify($_POST['parola-login'], $password)) 
		{
			session_regenerate_id();
			$_SESSION['adminlogged'] = TRUE;
			$_SESSION['admin_username'] = $_POST['username-login'];
			$_SESSION['id_admin'] = $id;
			header('Location: index-admin.php');
		} 
		else 
		{
			header('Location: autentificare-admin.php?error=password');
		}
	}
	else 
	{
		header('Location: autentificare-admin.php?error=nomatch');
	}
	
	$stmt->close();
}
?>
