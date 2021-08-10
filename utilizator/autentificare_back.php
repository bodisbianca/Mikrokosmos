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

if ($stmt = $con->prepare('SELECT id_user, parola FROM utilizatori WHERE email = ?')) 
{
	$stmt->bind_param('s', $_POST['email-login']);
	$stmt->execute();
	
	$stmt->store_result();
	if ($stmt->num_rows > 0) 
	{
		$stmt->bind_result($id, $password);
		$stmt->fetch();

		if (password_verify($_POST['parola-login'], $password)) 
		{
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['email'] = $_POST['email-login'];
			$_SESSION['id'] = $id;
			header('Location: index-utilizator.php');
		} 
		else 
		{
			header('Location: autentificare.php?error=password');
		}
	}
	else 
	{
		header('Location: autentificare.php?error=nomatch');
	}
	
	$stmt->close();
}
?>
