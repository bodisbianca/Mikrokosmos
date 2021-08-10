<?php 
require_once "../layout/Layout.php";

?>

<?=head_rel('Autentificare - ADMIN')?>
<link rel="stylesheet" href="../css_personal/login_register.css">
<link rel="stylesheet" href="../css_personal/formular_admin.css">
</head>
<?=template_meniuriADMIN()?>


<body>
	<div class="container-fluid">
       <div class="row justify-content-center"><?php 
			if(isset($_GET['signup']))
				{
					if($_GET['signup']=='succes')
						echo "<div class='col-md-12'><div class='alert alert-success' role='alert'>Înregistrare realizată cu succes! Autentificați-va pentru a accesa contul dvs.</div></div>";
				}	
				?>
			<div class="col-md-6 col-lg-6">
				<br>
				<div class="formular-login">
					<h2 id="titlu-formular">Conectare</h2>
					<br>
					<form action="autentificare_back.php" method="post" class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-2 form-icons" for="username-login">
								<i class="fas fa-user-cog"></i>
							</label>
							<span class="col-sm-2">
								<input type="text" name="username-login" placeholder="Administrator" id="username-login" required>
							</span>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2 form-icons" for="parola-login">
								<i class="fas fa-lock"></i>
							</label>
							<span class="col-sm-2">
								<input type="password" name="parola-login" placeholder="Parola" id="parola-login" required>
							</span>
						</div>
						<?php 
						if(isset($_GET['error']))
						{
							if($_GET['error']=='password')
								echo "<p id='eroare'>Parola introdusă este gresita!</p>";
							if($_GET['error']=='nomatch')
								echo "<p id='eroare'>Administratorul nu există!</p>";
						}
						?>
						<div class="form-group">        
							<div>
								<input class="buton" type="submit" value="Autentificare">
							</div>
						</div>
					</form>
				</div>
				<div class="logo">
					<img src="../layout/logo-admin.png"> 
				</div>
			</div>
			
			<div class="col-md-6 col-lg-6">
				<br>
				<?php 
					if(isset($_GET['errorsignup']))
					{
						if($_GET['errorsignup']=='nume')
							echo "<div class='alert alert-danger' role='alert'>Formatul numelui este incorect!</div>";
						if($_GET['errorsignup']=='prenume')
							echo "<div class='alert alert-danger' role='alert'>Formatul prenumelui este incorect!</div>";
						if($_GET['errorsignup']=='passlength')
							echo "<div class='alert alert-danger' role='alert'>Parola trebuie să aibă minim 5 caractere!</div>";
						if($_GET['errorsignup']=='username')
							echo "<div class='alert alert-danger' role='alert'>Formatul identificatorului administrator este incorect!</div>";
					}
				?>
				<div class="formular-signup">
					<h2 id="titlu-formular">Înregistrare</h2>
					<br>
					<form action="inregistrare_back.php" method="post" autocomplete="off" class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-4 form-icons" for="nume-signup">
								<i class="fas fa-user-plus"></i>
							</label>
							<span class="col-sm-4">
								<input type="text" name="nume-signup" placeholder="Nume" id="nume-signup" required>
							</span>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4 form-icons" for="prenume-signup">
								<i class="fas fa-user-plus"></i>
							</label>
							<span class="col-sm-4">
								<input type="text" name="prenume-signup" placeholder="Prenume" id="prenume-signup" required>
							</span>
						</div>						
						<div class="form-group">
							<label class="control-label col-sm-3 form-icons" for="username-signup">	
								<i class="fas fa-id-card-alt"></i>
							</label>
							<span class="col-sm-3">
								<input type="text" name="username-signup" placeholder="Admin (ex. nume.prenume)" id="username-signup" required>
							</span>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2 form-icons" for="parola-signup">
								<i class="fas fa-lock"></i>
							</label>
							<span class="col-sm-2">
								<input type="password" name="parola-signup" placeholder="Parola" id="parola-signup" required>
							</span>
							
						</div>
						<br>
						<div class="form-group">        
							<div>
								<input class="buton" type="submit" value="Înregistrare">
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</body>
<?=template_footer()?>
</html>