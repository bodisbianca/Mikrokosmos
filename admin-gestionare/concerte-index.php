<?php
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}
?>

<?=head_rel('Concerte și stadioane - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
    <link rel="stylesheet" href="../css_personal/profil.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>


	<body>
    <div class="container">
        <div class="header-profil" id="titlu-principal">
            <i class="fas fa-drum"></i>
            <h2> GESTIONARE CONCERTE ȘI STADIOANE</h2>          
        </div>
        <div class="row sectiuni-profil">
            <div class="col-sm-4">
                <i class="far fa-calendar-alt"></i>
                <h5> CONCERTE CURENTE</h5>
                <button type="button" class="buton" onclick="location.href='concerte-lista.php'">Vizualizeaza concerte</button>
            </div>

            <div class="col-sm-4">
                <i class="fas fa-map-marked-alt"></i>
                <h5> STADIOANE</h5>
                <button type="button" class="buton" onclick="location.href='stadioane.php'">Vizualizează stadioane</button>
            </div>
        </div>
    </div>

    <div class="deconectare">
        <a href="../admin/logout.php"><i class="fas fa-sign-out-alt"></i> Deconectare</a>
    </div>
	</body>
    <?=template_footer()?>
</html>
