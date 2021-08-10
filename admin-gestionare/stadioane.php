<?php
require_once "ConcerteAdmin.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin-autentificare/autentificare-admin.php');
	exit;
}

$stadioane = new ConcerteAdmin();
$lista_stadioane = $stadioane->getAllStadiums();

if(isset($_GET['action']))
{
    switch($_GET['action'])
    {
        case "eliminare":
            $stadioane->deleteStadium($_GET['id']);
            header('Location: stadioane.php');
        break;
    }
}

?>

<?=head_rel('Stadioane - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
    <link rel="stylesheet" href="../css_personal/profil.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>

<br>
	<body>
    <div class="header-profil header-update">
        <img src="../layout/logo-admin.png"> 
        <h2> STADIOANE </h2>
    </div>
    <button type="button" class="buton buton-new" onclick="location.href='stadion-structura.php'">Stadion nou</button>
    <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>STADION</th>
                    <th>LOCALITATE</th>
                    <th>CAPACITATE</th>
                    <th colspan="3">ACȚIUNI</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach($lista_stadioane AS $stadion) 
                {
                    $capacitate = $stadioane->getStadiumCapacity($stadion['id_stadion']);
            ?>
                <tr>
                    <td><?=$stadion['denumire']?></td>
                    <td><?=$stadion['oras']?></td>
                    <td><?=$capacitate?></td>
                    <td><a href="stadion-actualizare.php?id=<?=$stadion['id_stadion']?>">Actualizare</a></td>
                    <td><a href="stadion-config.php?id=<?=$stadion['id_stadion']?>">Configurare hartă</a></td>
                    <td><a href="stadioane.php?action=eliminare&id=<?=$stadion['id_stadion']?>">Eliminare</a></td>
                </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
	</body>
    <?=template_footer()?>
</html>
