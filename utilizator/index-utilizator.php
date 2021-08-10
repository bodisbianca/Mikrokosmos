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
?>

<?=head_rel('Index utilizator - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
	<link rel="stylesheet" href="../css_personal/magazin.css">
    <link rel="stylesheet" href="../css_personal/profil.css">
<?=template_meniuri()?>


	<body>
    <div class="container">
        <div class="header-profil">
            <img src="../layout/logo.png"> 
            <h2> Bun venit, <?php echo $informatii_user['nume'] . " " . $informatii_user['prenume'];?> ! </h2><br>
            <p> Navighează înspre secțiunea dorită a profilului tău. </p>
        </div>
        <div class="row sectiuni-profil">
            <div class="col-sm-3">
                <i class="fas fa-id-card"></i>
                <h5> PROFIL </h5>
                <button type="button" class="buton" onclick="location.href='profil.php'">Actualizează informațiile personale</button>
            </div>

            <div class="col-sm-3">
                <i class="fas fa-shopping-bag"></i>
                <h5>PRODUSE COMANDATE</h5>
                <button type="button" class="buton" onclick="location.href='comenzi-produse.php'">Vizualizează comenzile plasate</button>
            </div>

            <div class="col-sm-3">
                <i class='fa fa-ticket' aria-hidden='true'></i>
                <h5>BILETE REZERVATE</h5>
                <button type="button" class="buton" onclick="location.href='rezervari-bilete.php'">Vizualizează rezervările realizate</button>
            </div>
        </div>
    </div>

    <div class="deconectare">
        <a href="../utilizator/logout.php"><i class="fas fa-sign-out-alt"></i> Deconectare</a>
    </div>
	</body>
    <?=template_footer()?>
</html>
