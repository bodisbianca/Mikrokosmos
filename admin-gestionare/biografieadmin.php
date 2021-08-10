<?php
require_once "PrezentareAdmin.php";
require_once "../prezentare/Prezentare.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}

$info = new Prezentare();

$infoAdmin = new PrezentareAdmin();
$biografie = $infoAdmin->getAllBiographyEntries();



if(isset($_GET['action']))
{
    switch($_GET['action'])
    {
        case "eliminare":
            $infoAdmin->deleteSubChapter($_GET['id']);
            header('Location: biografieadmin.php');
        break;
    }
}
?>

<?=head_rel('Videoclipuri - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
    <link rel="stylesheet" href="../css_personal/profil.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>


<br>
	<body>
    <div class="header-profil header-update" id="titlu-principal">
        <i class="fas fa-book"></i>
        <h2> GESTIONARE DATE BIOGRAFICE</h2>
    </div>

    <button type="button" class="buton buton-new" onclick="location.href='biografieadmin-nou.php'">Subcapitol nou</button>
    <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>SUBTITLU</th>
                    <th>INFORMAȚII</th>
                    <th>IMAGINE</th>
                    <th colspan="2">ACȚIUNI</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach($biografie AS $subcapitol) 
                {
            ?>
                <tr>
                    <td><strong><?=$subcapitol['subtitlu']?></strong></td>
                    <td id="informatii-bio"><?=$subcapitol['informatii']?></td>
                    <td><?=$subcapitol['imagine']?></td>
                    <td><a href="biografieadmin-nou.php?id=<?=$subcapitol['id']?>">Actualizare</a></td>
                    <td><a href="biografieadmin.php?id=<?=$subcapitol['id']?>&action=eliminare">Eliminare</a></td>
                </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
	</body>
    <?=template_footer()?>
</html>
