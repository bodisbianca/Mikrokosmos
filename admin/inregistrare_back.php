<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = "";
$DATABASE_NAME = 'mikrokosmos';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);


if (empty($_POST['nume-signup']) || empty($_POST['prenume-signup']) || empty($_POST['parola-signup']) || empty($_POST['username-signup'])) 
{
	header('Location: autentificare-admin.php?errorsignup=nodata'); //nu sunt introduse toate datele
	exit;
}

if (!preg_match('/[A-Za-z]/', $_POST['nume-signup'])) 
{
	header('Location: autentificare-admin.php?errorsignup=nume'); //numele nu e valid
	exit;
}

if (!preg_match('/[A-Za-z]/', $_POST['prenume-signup'])) 
{
	header('Location: autentificare-admin.php?errorsignup=prenume');//prenumele nu e valid
	exit;
}

if (!preg_match('/[A-Za-z]/', $_POST['username-signup'])) 
{
	header('Location: autentificare-admin.php?errorsignup=username');//prenumele nu e valid
	exit;
}

if (strlen($_POST['parola-signup']) < 5) 
{
	header('Location: autentificare-admin.php?errorsignup=passlength');//parola e prea scurta
	exit;
}

if ($stmt = $con->prepare('SELECT id_admin FROM administratori WHERE username = ?')) 
{
	$stmt->bind_param('s', $_POST['username-signup']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) 
	{
		echo 'Identificatorul de administrator corespunde unui cont existent!';
	}
	else 
	{
		if ($stmt = $con->prepare('INSERT INTO administratori (nume, prenume, username, parola) VALUES(?, ?, ?, ?)')) 
		{
			$username = $_POST['username-signup'];
			$password = password_hash($_POST['parola-signup'], PASSWORD_DEFAULT);
			$stmt->bind_param('ssss', $_POST['nume-signup'], $_POST['prenume-signup'], $_POST['username-signup'], $password);
			$stmt->execute();

			header('Location: autentificare-admin.php?signup=succes');			
			
		} 
		else 
		{
			echo 'Nu se poate face prepare statement !';
		}
	}

	$stmt->close();
} 
else 
{
	header('Location: autentificare.php?errorsignup=dberror');//eroare la conexiune 
}
$con->close();
?>