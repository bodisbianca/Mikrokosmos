<?php 
require_once "../layout/Layout.php";
require_once "../prezentare/Prezentare.php";
require_once "DiscografieAdmin.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}

$info = new Prezentare();
$album_subcategory = $info->getAlbumYears();

$albums = new DiscografieAdmin();
$category_array = $albums->getAllCategories();

if (! empty($_GET["categ"])) 
    {$albume_array = $albums->getAlbumsByYear($_GET['categ']);}
else
    {$albume_array = $albums->getAllAlbums();}

if(!empty($_GET['action']))
{
    if($_GET['action']=="eliminare")
        $albums->deleteAlbum($_GET['id_prod']);
    header('Location: discografieadmin-index.php?id='.$_GET['id']);
}

?>


<?=head_rel('Albume - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/magazin.css">
    <link rel="stylesheet" href="../css_personal/prezentare.css">
    <link rel="stylesheet" href="../css_personal/profil.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
</head>

<?=template_meniuriADMIN()?>
<body>
    <div class="header-profil header-update" id="titlu-principal">
        <i class="fas fa-compact-disc"></i>
        <h2>GESTIONARE ALBUME</h2>
    </div>

    <div id="container_categ_mag">
        <div class="categorii_magazin">
          <ul>
            <li id=""><a href="discografieadmin-index.php">TOȚI ANII</a></li>
            <?php 
            if(!empty($album_subcategory))
            {
                foreach($album_subcategory AS $key => $categorie)
                {?>
                    <li id=""><a href="discografieadmin-index.php?categ=<?=$categorie['an_aparitie'];?>"><?php echo $categorie ['an_aparitie']; ?></a></li>
                <?php 
                }
            }
            ?>
          </ul>
        </div>
        <div id="buton-album-nou">
            <button type="button" class="buton buton-new" onclick="location.href='discografieadmin-nou.php'">ALBUM NOU</button>
        </div>
    </div>

    <div class="container albume">    
        <div class="row discografie">
            <?php
            if (! empty($albume_array)) 
            { 
                foreach ($albume_array as $key => $album) 
                {
            ?>
            <div class="col-lg-4 album">
                <img src="<?php echo $album['coperta']; ?>">
                <div class="detalii-album">
                    <div class="informatii">
                        <h4><strong><a href='discografieadmin-album.php?id=<?=$album['id_album']?>'><?php echo strtoupper($album['titlu']);?></a></strong></h4>
                        <p>
                            <?php echo "ALBUM ". strtoupper($album['tip_album']);?><br>
                            <?php echo $album['an_aparitie'];?>
                        </p>
                        <div>
                            <button type="button" class="buton buton-delete" onclick="location.href='discografieadmin-index.php?action=eliminare&id_prod=<?=$album['id_prod']?>&id=<?=$album['id_album']?>'">Eliminare</button>    
                            <button type="button" class="buton buton-update" onclick="location.href='discografieadmin-update.php?id=<?=$album['id_album']?>'">Actualizare</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>    
    </div>
        <?php }?>
    </body>
    <?=template_footer()?>
</html>