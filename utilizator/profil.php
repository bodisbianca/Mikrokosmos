<?php
require_once "UserInfo.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['loggedin'])) 
{
	header('Location: autentificare.php');
	exit;
}


$id_user=$_SESSION['id'];
$detaliiUser = new UserInfo();
$informatii_user = $detaliiUser->getUser($id_user);
$comenzi = $detaliiUser->getUserTotalOrders($id_user);
$rezervari = $detaliiUser->getUserTotalTickets($id_user);
?>
<?=head_rel('Profil utilizator - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
	<link rel="stylesheet" href="../css_personal/magazin.css">
	<link rel="stylesheet" href="../css_personal/profil.css">
<?=template_meniuri()?>

	<body>
		<div class="container profil">
			<br>
			<?php
			if(!empty($_GET["action"]))
			{
				switch ($_GET["action"]) 
				{
					case "update":
						if (password_verify($_POST['parola-old'], $informatii_user['parola'])) 
						{
							$detaliiUser->updateUserInfo($id_user, $_POST['nume-update'],$_POST['prenume-update'],$_POST['email-update'],$_POST['parola-update']);
							echo "<div class='alert alert-success'><strong>Actualizare realizata cu succes!</strong> Click <a href='profil.php'><strong>aici</strong></a> pentru a vizualiza modificarile.</div>";
						}
						else echo "<div class='alert alert-danger'><strong>Parola incorecta!</strong></div>";
					break;
				}
			}
			?>
			<div class="row">
				<div class="col-lg-7 date-actuale">
					<h2> Informații cont </h2>
					<ul>
						<li><strong>Nume </strong><span><?php echo	$informatii_user["nume"]; ?></span></li>
						<li><strong>Prenume </strong><span><?php echo	$informatii_user["prenume"]; ?></span></li>
						<li><strong>E-mail </strong><span><?php echo	$informatii_user["email"]; ?></span></li>
						<li><strong>Data înregistrării </strong><span><?php echo	date('d.m.Y H:i', strtotime ($informatii_user["data_inreg"])); ?></span></li>	
					</ul>
					<ul>
						<li><strong>Număr total de comenzi plasate </strong><span><?php echo	$comenzi . " comenzi"; ?></span></li>
						<li><strong>Număr total de rezervări realizate </strong><span><?php echo	$rezervari . " rezervari"; ?></span></li>
					</ul>
				</div>

				<div class="col-lg-5 actualizare">
					<h2> Actualizare </h2>
					<form action="profil.php?action=update" method="post" class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-4 form-icons" for="nume-update">
								<i class="fas fa-id-card"></i>
							</label>
							<span class="col-sm-4">
								<input type="text" name="nume-update" placeholder="Nume" id="nume-update" value="<?php echo	$informatii_user["nume"]; ?>"required>
							</span>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4 form-icons" for="prenume-update">
								<i class="fas fa-id-card"></i>
							</label>
							<span class="col-sm-4">
								<input type="text" name="prenume-update" placeholder="Prenume" id="prenume-update" value="<?php echo $informatii_user["prenume"]; ?>" required>
							</span>
						</div>						
						<div class="form-group">
							<label class="control-label col-sm-3 form-icons" for="email-update">	
								<i class="fas fa-envelope"></i>
							</label>
							<span class="col-sm-3">
								<input type="email" name="email-update" placeholder="Email" id="email-update" value="<?php echo	$informatii_user["email"]; ?>" required>
							</span>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2 form-icons" for="parola-old">
								<i class="fas fa-lock"></i>
							</label>
							<span class="col-sm-2">
								<input type="password" name="parola-old" placeholder="Parolă actuală" id="parola-old" required>
							</span>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2 form-icons" for="parola-update">
								<i class="fas fa-lock"></i>
							</label>
							<span class="col-sm-2">
								<input type="password" name="parola-update" placeholder="Parolă nouă" id="parola-update" required>
							</span>
						</div>
						<div class="form-group">        
							<div>
								<input class="buton" type="submit" value="Salvează modificările">
							</div>
						</div>
					</form>
				</div>
			</div>
			<input type="button" value="Înapoi la meniul principal" onclick="location.href='index-utilizator.php'" class="buton-back">
		</div>
	</body>
	<?=template_footer()?>
</html>
