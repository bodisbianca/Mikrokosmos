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
$video_subcategory = $infoAdmin->getAllVideoCategories();

if (! empty($_GET["categ"])) 
{
    $video_array = $info->getVideosByCategory($_GET['categ']);
}
else 
{
    $video_array = $infoAdmin->getAllVideos();
}


if(isset($_GET['action']))
{
    switch($_GET['action'])
    {
        case "eliminare":
            $infoAdmin->deleteVideo($_GET['id']);
            header('Location: videoclipuriadmin.php');
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
        <i class="fas fa-video"></i>
        <h2> GESTIONARE VIDEOCLIPURI</h2>
    </div>
    <div id="container_categ_mag">
        <div class="categorii_magazin">
          <ul>
            <li id=""><a href="videoclipuriadmin.php">TOATE</a></li>
            <?php 
            if(!empty($video_subcategory))
            {
                foreach($video_subcategory AS $key => $categorie)
                {?>
                    <li id=""><a href="videoclipuriadmin.php?categ=<?=$categorie['categorie'];?>"><?php echo strtoupper($categorie ['categorie']); ?></a></li>
                <?php 
                }
            }
            ?>
          </ul>
        </div>
    </div>
    <button type="button" class="buton buton-new" onclick="location.href='videoclipuriadmin-nou.php'">Videoclip nou</button>
    <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>TITLU VIDEOCLIP</th>
                    <th>DATA</th>
                    <th>LINK YOUTUBE</th>
                    <th>CATEGORIE</th>
                    <th colspan="2">ACȚIUNI</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach($video_array AS $video) 
                {
            ?>
                <tr>
                    <td><?=$video['titlu']?></td>
                    <td><?=date('d.m.Y', strtotime ($video['data']))?></td>
                    <td><?=$video['link']?></td>
                    <td><?=$video['categorie']?></td>
                    <td><a href="videoclipuriadmin-nou.php?id=<?=$video['id_video']?>">Actualizare</a></td>
                    <td><a href="videoclipuriadmin.php?id=<?=$video['id_video']?>&action=eliminare">Eliminare</a></td>
                </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
	</body>
    <?=template_footer()?>
</html>
