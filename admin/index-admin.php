<?php
require_once "Admin.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: autentificare-admin.php');
	exit;
}

$id_admin=$_SESSION['id_admin'];
$adminData = new Admin();
$informatii_admin = $adminData->getAdmin($id_admin);
?>

<?=head_rel('Index administrator - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
    <link rel="stylesheet" href="../css_personal/profil.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>


	<body>
    <div class="container">
        <div class="header-profil">
            <img src="../layout/logo-admin.png"> 
            <h2> Bun venit, <?php echo $informatii_admin['nume'] . " " . $informatii_admin['prenume'];?> ! </h2>
            <p> Actualizează conținutul website-ului MIKROKOSMOS </p>
        </div>
        <div class="row sectiuni-profil sectiuni-admin">
            <div class="col-lg-6">
                <i class="fas fa-id-card"></i>
                <h5> ELEMENTE DE PREZENTARE </h5>
                <button type="button" class="buton" onclick="location.href='../admin-gestionare/biografieadmin.php'">Biografie</button>
                <button type="button" class="buton" onclick="location.href='../admin-gestionare/discografieadmin-index.php'">Discografie</button>
                <button type="button" class="buton" onclick="location.href='../admin-gestionare/videoclipuriadmin.php'">Videoclipuri</button>
            </div>

            <div class="col-lg-6">
                <i class="fas fa-drum"></i>
                <h5>CONCERTE ȘI STADIOANE</h5>
                <button type="button" class="buton" onclick="location.href='../admin-gestionare/concerte-lista.php'">Concerte</button>
                <button type="button" class="buton" onclick="location.href='../admin-gestionare/stadioane.php'">Stadioane</button>
            </div>

            <div class="col-lg-6">
                <i class="fas fa-shopping-bag"></i>
                <h5>MAGAZIN</h5>
                <button type="button" class="buton" onclick="location.href='../admin-gestionare/magazinadmin-produse.php'">Produse</button>
                <button type="button" class="buton" onclick="location.href='../admin-gestionare/magazinadmin-comenzi.php'">Comenzi</button>
            </div>

        </div>
    </div>

    <div class="deconectare">
        <a href="../admin/logout.php"><i class="fas fa-sign-out-alt"></i> Deconectare</a>
    </div>
	</body>
    <?=template_footer()?>
</html>
