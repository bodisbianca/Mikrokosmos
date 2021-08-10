<?php
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}
?>

<?=head_rel('Produse și comenzi - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
    <link rel="stylesheet" href="../css_personal/profil.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>


	<body>
    <div class="container">
        <div class="header-profil" id="titlu-principal">
            <i class="fas fa-store"></i>
            <h2> GESTIONARE PRODUSE ȘI COMENZI</h2>          
        </div>
        <div class="row sectiuni-profil">
            <div class="col-sm-4">
                <i class="fas fa-tags"></i>
                <h5> PRODUSE </h5>
                <button type="button" class="buton" onclick="location.href='magazinadmin-produse.php'">Vizualizează produse</button>
            </div>

            <div class="col-sm-4">
                <i class="fas fa-cash-register"></i>
                <h5> COMENZI </h5>
                <button type="button" class="buton" onclick="location.href='magazinadmin-comenzi.php'">Vizualizează comenzi</button>
            </div>
        </div>
    </div>

    <div class="deconectare">
        <a href="../admin/logout.php"><i class="fas fa-sign-out-alt"></i> Deconectare</a>
    </div>
	</body>
    <?=template_footer()?>
</html>
