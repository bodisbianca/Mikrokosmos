<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = "";
$DATABASE_NAME = 'mikrokosmos';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (empty($_POST['nume-signup']) || empty($_POST['prenume-signup']) || empty($_POST['parola-signup']) || empty($_POST['email-signup'])) 
{
	header('Location: autentificare.php?errorsignup=nodata'); //nu sunt introduse toate datele
	exit;
}

if (!filter_var($_POST['email-signup'], FILTER_VALIDATE_EMAIL)) 
{
	header('Location: autentificare.php?errorsignup=email'); //emailul nu e valid
	exit;
}

if (!preg_match('/[A-Za-z]/', $_POST['nume-signup'])) 
{
	header('Location: autentificare.php?errorsignup=nume'); //numele nu e valid
	exit;
}

if (!preg_match('/[A-Za-z]/', $_POST['prenume-signup'])) 
{
	header('Location: autentificare.php?errorsignup=prenume');//prenumele nu e valid
	exit;
}

if (strlen($_POST['parola-signup']) < 5) 
{
	header('Location: autentificare.php?errorsignup=passlength');//parola e prea scurta
	exit;
}

if ($stmt = $con->prepare('SELECT id_user, parola FROM utilizatori WHERE email = ?')) 
{
	$stmt->bind_param('s', $_POST['email-signup']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) 
	{
		header('Location: autentificare.php?errorsignup=nomatch'); //nu exista user
	} 
	else 
	{
		if ($stmt = $con->prepare('INSERT INTO utilizatori (nume, prenume, email, parola) VALUES(?, ?, ?, ?)')) 
		{
			$password = password_hash($_POST['parola-signup'], PASSWORD_DEFAULT);
			$stmt->bind_param('ssss', $_POST['nume-signup'], $_POST['prenume-signup'], $_POST['email-signup'], $password);
			$stmt->execute();

			$_SESSION['loggedin'] = TRUE;
			$_SESSION['email'] = $_POST['email-signup'];
			$_SESSION['id'] = $id;
			header('Location: autentificare.php?signup=succes');
		} 
		else 
		{
			header('Location: autentificare.php?errorsignup=dberror'); //eroare la conexiune 
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