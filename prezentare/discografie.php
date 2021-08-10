<?php 
require_once "../layout/Layout.php";
require_once "Prezentare.php";
session_start();

$info = new Prezentare();
$album_subcategory = $info->getKoreanYears();

if (! empty($_GET["categ"])) 
{
    $albume_array = $info->getAlbumsByYear($_GET['categ']);
}
else
{
    $albume_array = $info->getKoreanAlbums();
}

?>


<?=head_rel('Discografie - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/magazin.css">
    <link rel="stylesheet" href="../css_personal/prezentare.css">
</head>

<?=template_meniuri()?>

    <div class="titlu">
        <h3><strong>DISCOGRAFIE</strong></h3>
        <p>Explorați poveștile din spatele discografiei coreene a formației BTS!</p>
    </div>

    <div id="container_categ_mag">
        <div class="categorii_magazin">
          <ul>
            <li id=""><a href="discografie.php">TOȚI ANII</a></li>
            <?php 
            if(!empty($album_subcategory))
            {
                foreach($album_subcategory AS $key => $categorie)
                {?>
                    <li id=""><a href="discografie.php?categ=<?=$categorie['an_aparitie'];?>"><?php echo $categorie ['an_aparitie']; ?></a></li>
                <?php 
                }
            }
            ?>
          </ul>
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
                        <h4><strong><a href='discografie-album.php?id=<?=$album['id_album']?>'><?php echo strtoupper($album['titlu']);?></a></strong></h4>
                        <p>
                            <?php echo "ALBUM ". strtoupper($album['tip_album']);?><br>
                            <?php echo $album['an_aparitie'];?>
                        </p>
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