<?php 
require_once "../layout/Layout.php";
require_once "../prezentare/Prezentare.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}

$info = new Prezentare();
$id_album = $_GET['id'];
$album = $info->getAlbumMainInformation($id_album);

if (! empty($_GET["detalii"])) 
{
    switch ($_GET["detalii"]) 
    {
        case "versiuni":
            $nr_versiuni = 1;
            $versiuni_album = $info->getAlbumVersions($album['id_prod']);
            if(empty($versiuni_album))
            {
                $versiune = $info->getAlbumSingleVersion($id_album);
                $nr_versiuni=0;
            }
        break;
        case "descriere":
            $descriere_album = explode(". ", $album['descriere']);
        break;
        case "cantece":
            $muzica_album = $info->getAlbumMusic($id_album);
        break;
    }
}
?>

<?=head_rel('Album - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/magazin.css">
    <link rel="stylesheet" href="../css_personal/prezentare.css">
    <link rel="stylesheet" href="../css_personal/prezentare-album.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
</head>

<?=template_meniuriADMIN()?>

    
    <div class="prezentare">
        
        <div class="container">  
            <input type="button" value="Înapoi la discografie" onclick="location.href='discografieadmin-index.php'" class="buton-back" id="back">
            <input type="button" value="Actualizare" onclick="location.href='discografieadmin-update.php?id=<?=$id_album?>'" class="buton buton-update" id="back">
            <?php 
            if(!isset($_GET['detalii']))
            { 
            ?> 
            <div class="row album"> <!-- TITLU, POZA DE COPERTA, CHENARE CARE DUC SPRE DESCRIERE, VERSIUNI SI LINK-URI EXTERNE -->
                <div class="col-lg-3 titlu-album">
                    <div>
                        <a href="discografie-album.php?id=<?=$id_album?>"><h3><strong><?=$album['denumire']?></strong></h3></a>
                        <p>
                            <?php echo "ALBUM ". strtoupper($album['tip_album']);?><br>
                            <?php echo $album['an_aparitie'];?>
                        </p>
                    </div>
                    <br>
                    <div>
                        <div class="stream">
                            <p>Ascultă online</p> 
                            <a href="<?=$album['spotify']?>" target="_blank"><i class="fab fa-spotify"></i></a>
                            <a href="<?=$album['itunes']?>" target="_blank"><i class="fab fa-itunes"></i></a>
                        </div>
                        <input type="button" value="Comandă albumul" onclick="location.href='../magazin/produs_album.php?id=<?=$album['id_prod']?>'" class="buton"></br>
                    </div>
                </div>
                <div class="col-lg-6 coperta-album">
                    <div class="">
                        <img src="<?=$album['coperta']?>">
                    </div>
                </div>
                <div class="col-lg-3 meniu-album">
                    <div>
                        <input type="button" value="DESCRIERE" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=descriere'" class="buton-back">
                    </div>
                    <div>
                        <input type="button" value="VERSIUNI" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=versiuni'" class="buton-back">
                    </div>
                    <div>
                        <input type="button" value="CÂNTECE" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=cantece'" class="buton-back">
                    </div>
                </div>
            </div>


            <?php }  
            else if($_GET['detalii']=='descriere')
            {        
            ?> 
            <div class="row album descriere"> <!-- DESCRIERE -->
                <div class="col-lg-3 titlu-album">
                    <div>
                        <a href="discografie-album.php?id=<?=$id_album?>"><h3><strong><?=$album['denumire']?></strong></h3></a>
                        <p>
                            <?php echo "ALBUM ". strtoupper($album['tip_album']);?><br>
                            <?php echo $album['an_aparitie'];?>
                        </p>
                    </div>
                    <br>
                    <div>
                        <div class="stream">
                            <p>Ascultă online</p> 
                            <a href="<?=$album['spotify']?>" target="_blank"><i class="fab fa-spotify"></i></a>
                            <a href="<?=$album['itunes']?>" target="_blank"><i class="fab fa-itunes"></i></a>
                        </div>
                        <input type="button" value="Comandă albumul" onclick="location.href='../magazin/produs_album.php?id=<?=$album['id_prod']?>'" class="buton"></br>
                    </div>
                </div>
                <div class="col-lg-6 descriere-album">
                    <?php 
                    foreach($descriere_album AS $paragraf)
                    {
                        echo "<p>".$paragraf."</p>";
                    }
                    ?>
                </div>
                <div class="col-lg-3 meniu-album">
                    <div>
                        <input type="button" value="DESCRIERE" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=descriere'" class="buton-back">
                    </div>
                    <div>
                        <input type="button" value="VERSIUNI" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=versiuni'" class="buton-back">
                    </div>
                    <div>
                        <input type="button" value="CÂNTECE" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=cantece'" class="buton-back">
                    </div>
                </div>
            </div>


            <?php } 
            else if($_GET['detalii']=='versiuni')
            {        
            ?> 
            <div class="row album"> <!-- VERSIUNI -->
                <div class="col-lg-2 titlu-album">
                    <div>
                        <h3><strong>VERSIUNI</strong></h3>
                        <a href="discografie-album.php?id=<?=$id_album?>"><h5><?=$album['denumire']?></h5></a>
                    </div>
                    <br>
                    <div>
                        <div class="stream">
                            <p>Ascultă online</p> 
                            <a href="<?=$album['spotify']?>" target="_blank"><i class="fab fa-spotify"></i></a>
                            <a href="<?=$album['itunes']?>" target="_blank"><i class="fab fa-itunes"></i></a>
                        </div>
                        <input type="button" value="Comandă albumul" onclick="location.href='../magazin/produs_album.php?id=<?=$album['id_prod']?>'" class="buton"></br>
                    </div>
                </div>

                <div class="col-lg-8 poza-versiune">
                    <?php if($nr_versiuni==1) { ?>
                    <div id="versiuni-slideshow" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php 
                            $slide = 0;
                            foreach($versiuni_album AS $versiune)
                            {
                                if($slide==0)
                                { echo '<li data-target="#versiuni-slideshow" data-slide-to="0" class="active"></li>';}
                                else
                                { echo '<li data-target="#versiuni-slideshow" data-slide-to="' . $slide . '"></li>';}
                                $slide++;
                            }?>                            
                        </ol>
                        <div class="carousel-inner">
                            <?php 
                            $first_slide = 0;
                            foreach($versiuni_album AS $key => $versiune)
                            { 
                                if($first_slide==0)
                                { 
                                    echo '<div class="carousel-item active">';
                                    $first_slide=1;
                                }
                                else 
                                {   echo '<div class="carousel-item">';}?>
                                <img src="<?= $versiune['poza_ver'];?>">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5><?php echo "VERSIUNEA " . strtoupper($versiune['versiune']); ?></h5>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                        <a class="carousel-control-prev" href="#versiuni-slideshow" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only"></span></a>
                        <a class="carousel-control-next" href="#versiuni-slideshow" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only"></span></a>
                    </div>
                    <?php }
                    else { ?>
                    <div id="versiune-slideshow">
                        <img src="<?= $versiune['poza_grup'];?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo strtoupper($album['denumire']); ?></h5>
                        </div>
                    </div>
                    <?php }?>
                </div>

                <div class="col-lg-2 meniu-album versiuni">
                    <div>
                        <input type="button" value="DESCRIERE" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=descriere'" class="buton-back">
                    </div>
                    <div>
                        <input type="button" value="VERSIUNI" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=versiuni'" class="buton-back">
                    </div>
                    <div>
                        <input type="button" value="CÂNTECE" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=cantece'" class="buton-back">
                    </div>
                </div>
            </div>


            <?php } 
            else
            {        
            ?> 
            <div class="row album"><!-- VIDEO -->
                <div class="col-lg-3 titlu-album">
                    <div>
                        <a href="discografie-album.php?id=<?=$id_album?>"><h3><strong><?=$album['denumire']?></strong></h3></a>
                        <p>
                            <?php echo $muzica_album['nr_cantece'] . " cantece, " . $muzica_album['durata'] . " minute";?>
                        </p>
                    </div>
                    <br>
                    <div>
                        <div class="stream">
                            <p>Ascultă online</p> 
                            <a href="<?=$album['spotify']?>" target="_blank"><i class="fab fa-spotify"></i></a>
                            <a href="<?=$album['itunes']?>" target="_blank"><i class="fab fa-itunes"></i></a>
                        </div>
                        <input type="button" value="Comandă albumul" onclick="location.href='../magazin/produs_album.php?id=<?=$album['id_prod']?>'" class="buton"></br>
                    </div>
                </div>
                <div class="col-lg-6 coperta-album tracklist">
                    <div class="">
                        <img src="<?=$muzica_album['tracklist']?>">
                    </div>
                </div>
                <div class="col-lg-3 meniu-album">
                    <div>
                        <input type="button" value="DESCRIERE" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=descriere'" class="buton-back">
                    </div>
                    <div>
                        <input type="button" value="VERSIUNI" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=versiuni'" class="buton-back">
                    </div>
                    <div>
                        <input type="button" value="CÂNTECE" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>&detalii=cantece'" class="buton-back">
                    </div>
                </div>
            </div>
            <div class="row album"> 
                <div class="col video">
                    <div class="embed-responsive embed-responsive-16by9 videoclip">
                        <iframe class="embed-responsive-item" src="<?=$muzica_album['youtube']?>" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>
    </body>
    <?=template_footer()?>
</html>