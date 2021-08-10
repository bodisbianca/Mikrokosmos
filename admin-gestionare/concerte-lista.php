<?php
require_once "ConcerteAdmin.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}

$concerte = new ConcerteAdmin();
$lista_concerte = $concerte->getAllConcerts();

if(isset($_GET['action']))
{
    switch($_GET['action'])
    {
        case "eliminare":
            $concerte->deleteConcert($_GET['id']);
            header('Location: concerte-lista.php');
        break;
    }
}
?>

<?=head_rel('Index administrator - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
    <link rel="stylesheet" href="../css_personal/profil.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>


<br>
	<body>
    <div class="header-profil header-update">
        <img src="../layout/logo-admin.png"> 
        <h2> CONCERTE </h2>
    </div>
    <button type="button" class="buton buton-new" onclick="location.href='concert-info.php'">Concert nou</button>
    <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th colspan="2">CONCERT</th>
                    <th>STADION</th>
                    <th>DATA</th>
                    <th>ORA</th>
                    <th>DURATA</th>
                    <th colspan="2">ACȚIUNI</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach($lista_concerte AS $concert) 
                {
            ?>
                <tr>
                    <td class="img">
						<img src="../concerte/<?=$concert['poster']?>" width="70" height="50"alt="<?=$concert['nume_concert']?>">
					</td>
                    <td><?=$concert['nume_concert']?></td>
                    <td><a href="stadion-config.php?id=<?=$concert['stadionID']?>"><?php echo $concert['stadion']."<br>".$concert['oras'];?></a></td>
                    <td><?php echo date('d.m.Y', strtotime ($concert['data']));?></td>
                    <td><?php echo date('H:i', strtotime ($concert['ora']));?></td>
                    <td><?=$concert['durata']?> minute</td>
                    <td><a href="concert-info.php?id=<?=$concert['id_concert']?>">Informatii</a></td>
                    <td><a href="concert-tarife.php?id=<?=$concert['id_concert']?>">Tarife</a></td>
                    <td><a href="concerte-lista.php?id=<?=$concert['id_concert']?>&action=eliminare">Eliminare</a></td>
                </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
	</body>
    <?=template_footer()?>
</html>
