<?php
require_once "DiscografieAdmin.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}


$adminAlbume = new DiscografieAdmin();


if(isset($_GET['id']))
{
    $id_album = $_GET['id'];
    $id_prod = $adminAlbume->getAlbumProdId($id_album);
    $album = $adminAlbume->getInformatiiGenerale($id_prod);
    $versiuni = $adminAlbume->getAlbumVersions($id_prod);
}


if(!empty($_GET['action']))
{
    switch($_GET['action'])
    {
        case "update-album":
            $denumire = $_POST['denumire'];
            $poza = $_POST['poza'];
            $categorie_prod = $_POST['categorie'];
            $pret = $_POST['pret'];
            $cantitate = $_POST['cantitate'];
            $descriere = $_POST['descriere'];

            $adminAlbume->updateAlbumProd($id_prod, $denumire, $poza, $categorie_prod, $pret, $cantitate, $descriere);

            $limba = $_POST['limba'];
            $an_aparitie = $_POST['an_aparitie'];
            $durata = $_POST['durata'];
            $nr_cantece = $_POST['nr_cantece'];
            $tip_album = $_POST['tip_album'];

            $adminAlbume->updateAlbum($id_prod, $limba, $an_aparitie, $durata, $nr_cantece, $tip_album);

            header('Location: discografieadmin-update.php?update=alsucces&id='.$id_album);
        break;
;

        case "update_imagini-link":
            $poza_fizic = $_POST['poza_fizic'];
            $poza_grup = $_POST['poza_grup'];
            $poza_tracklist = $_POST['poza_tracklist'];
            $link_spotify = $_POST['link_spotify'];
            $link_youtube = $_POST['link_youtube'];
            $link_itunes = $_POST['link_itunes'];

            if($poza_fizic == '../media/')
                $poza_fizic = NULL;
            if($poza_grup == '../media/')
                $poza_grup = NULL;
            if($poza_tracklist == '../media/')
                $poza_tracklist = NULL;
            
            $adminAlbume->updateImagesLinks($id_prod, $poza_fizic, $poza_grup, $poza_tracklist, $link_spotify, $link_itunes, $link_youtube);
            header('Location: discografieadmin-update.php?update=imgsucces&id='.$id_album); 
        break;

        case "update-versions":
                if(isset($versiuni['0']))
                {
                    if($_POST['versiune1']!=$versiuni['0']['versiune'] || $_POST['versiune1Img']!=$versiuni['0']['poza_ver'])
                        $adminAlbume->updateVersion($versiuni['0']['id_ver'], $_POST['versiune1'], $_POST['versiune1Img']);

                    if(empty($_POST['versiune1']) && empty($_POST['versiune1Img']))
                        $adminAlbume->deleteVersion($versiuni['0']['id_ver']);
                } 
                else 
                {
                    if(!empty($_POST['versiune1']) && !empty($_POST['versiune1Img']))
                        $adminAlbume->addNewVersion($id_prod, $_POST['versiune1'], $_POST['versiune1Img']);
                }

                if(isset($versiuni['1']))
                {
                    if($_POST['versiune2']!=$versiuni['1']['versiune'] || $_POST['versiune2Img']!=$versiuni['1']['poza_ver'])
                        $adminAlbume->updateVersion($versiuni['1']['id_ver'], $_POST['versiune2'], $_POST['versiune2Img']);

                    if(empty($_POST['versiune2']) && empty($_POST['versiune2Img']))
                        $adminAlbume->deleteVersion($versiuni['1']['id_ver']);
                } 
                else 
                {
                    if(!empty($_POST['versiune2']) && !empty($_POST['versiune2Img']))
                        $adminAlbume->addNewVersion($id_prod, $_POST['versiune2'], $_POST['versiune2Img']);
                }   

                if(isset($versiuni['2']))
                {
                    if($_POST['versiune3']!=$versiuni['2']['versiune'] || $_POST['versiune3Img']!=$versiuni['2']['poza_ver'])
                        $adminAlbume->updateVersion($versiuni['2']['id_ver'], $_POST['versiune3'], $_POST['versiune3Img']);

                    if(empty($_POST['versiune3']) && empty($_POST['versiune3Img']))
                        $adminAlbume->deleteVersion($versiuni['2']['id_ver']);
                }
                else
                {
                    if(!empty($_POST['versiune3']) && !empty($_POST['versiune3Img']))
                        $adminAlbume->addNewVersion($id_prod, $_POST['versiune3'], $_POST['versiune3Img']);
                }

                if(isset($versiuni['3']))
                {
                    if ($_POST['versiune4']!=$versiuni['3']['versiune'] || $_POST['versiune4Img']!=$versiuni['3']['poza_ver'])
                        $adminAlbume->updateVersion($versiuni['3']['id_ver'], $_POST['versiune4'], $_POST['versiune4Img']);

                    if(empty($_POST['versiune4']) && empty($_POST['versiune4Img']))
                        $adminAlbume->deleteVersion($versiuni['3']['id_ver']);
                }
                else 
                {
                    if(!empty($_POST['versiune4']) && !empty($_POST['versiune4Img']))
                        $adminAlbume->addNewVersion($id_prod, $_POST['versiune4'], $_POST['versiune4Img']);
                }
                    
            header('Location: discografieadmin-update.php?update=versucces&id='.$id_album);
        break;
    }
}
?>

<?=head_rel('Actualizare album - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/produs.css">
    <link rel="stylesheet" href="../css_personal/magazin.css">
    <link rel="stylesheet" href="../css_personal/profil.css"> 
    <link rel="stylesheet" href="../css_personal/prezentare.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
    <link rel="stylesheet" href="../css_personal/magazin_admin.css">
   
<?=template_meniuriADMIN()?>


<br>
	<body>                 
   
    <div class="titlu">
        <h3><strong>ACTUALIZARE ALBUM</strong></h3>
    </div>

    <div id="container_categ_mag">
        <div class="categorii_magazin">
            <ul>
                <li><a href="#info-generale">INFORMAȚII GENERALE</a></li>
                <li><a href="#img-links">IMAGINI ȘI LINK-URI EXTERNE</a></li>
                <li><a href="#versiuni">VERSIUNI</a></li>
            </ul>
        </div>
    </div>

    <?php 
        if(isset($_GET["update"]))
        {  
            if($_GET["update"]=="alsucces")
                {echo "<div class='alert alert-success' role='alert'>Actualizarea informațiilor generale a fost efectuată cu succes.</div>";} 
            if($_GET["update"]=="imgsucces")
                {echo "<div class='alert alert-success' role='alert'>Actualizarea imaginilor și link-urilor externe a fost efectuată cu succes.</div>";} 
            if($_GET["update"]=="versucces")
                {echo "<div class='alert alert-success' role='alert'>Actualizarea versiunilor a fost efectuată cu succes.</div>";} 
        }
    ?>

    <div class="container">
        <div class="new">
            <?php if(isset($_GET['id'])) { ?>

            <!-- INFORMATII PRINCIPALE -->
            <div class="header-profil header-update" id="info-generale"> 
                <img src="../layout/logo-admin.png"> 
                <h4><strong>INFORMAȚII GENERALE</strong></h4>       
            </div>
            <div class="formular-concert album-nou">
                <form action="discografieadmin-update.php?action=update-album&id=<?=$_GET['id']?>" method="post" class="form-horizontal">
                    <div class="form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="denumire">Titlu</label>
                                <span class="col-sm-8"><input type="text" name="denumire" id="denumire" value="<?=$album['denumire']?>" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="categorie">Categorie</label>
                                <span class="col-sm-6"><input type="text" name="categorie" id="categorie" value="albume" readonly></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="cantitate">Cantitate</label>
                                <span class="col-sm-6"><input type="number" name="cantitate" id="cantitate" value="<?=$album['cantitate']?>" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="pret">Preț</label>
                                <span class="col-sm-6"><input type="number" step=".01" name="pret" id="pret" value="<?=$album['pret']?>" required></span>
                            </div>
                            <div class="form-group link">
                                <label class="control-label col-sm-4 form-icons" for="poza">Copertă</label>
                                <span class="col-sm-6"><input type="text" name="poza" id="poza" value="<?=$album['poza']?>" required></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="tip_album">Tip album</label>
                                <span class="col-sm-6"><input type="text" name="tip_album" id="tip_album" value="<?=$album['tip_album']?>" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="limba">Limba</label>
                                <span class="col-sm-6"><input type="text" name="limba" id="limba" value="<?=$album['limba']?>" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="an_aparitie">An aparitie</label>
                                <span class="col-sm-6"><input type="number" name="an_aparitie" id="an_aparitie" value="<?=$album['an_aparitie']?>" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="durata">Durata</label>
                                <span class="col-sm-6"><input type="number" name="durata" id="durata" value="<?=$album['durata']?>" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="nr_cantece">Număr de cântece</label>
                                <span class="col-sm-6"><input type="number" name="nr_cantece" id="nr_cantece" value="<?=$album['nr_cantece']?>" required></span>
                            </div>
                        </div>
                        <div class="col descriere-album">
                            <div class="form-group">
                                <label class="control-label form-icons" for="descriere">Descriere</label>
                                <textarea class=" form-control" name="descriere" id="descriere" rows="4"><?=$album['descriere']?></textarea>  
                            </div>
                        </div>
                    </div>
                    <div class="buton-update">
                        <input class="buton buton-update" type="submit" value="Actualizare">
                    </div> 
                </form>
            </div>


            <!-- IMAGINI SUPLIMENTARE SI LINK-URI EXTERNE -->
            <div class="header-profil header-update" id="img-links">
                <img src="../layout/logo-admin.png"> 
                <h4><strong> IMAGINI ȘI LINK-URI EXTERNE </strong></h4> 
                <p>Obs: Introduceti link de tip <strong>embed</strong> pentru videoclipurile din sursa <strong>YouTube. </strong></p>      
            </div>
            <div class="formular-concert album-nou ">
                <form action="discografieadmin-update.php?action=update_imagini-link&id=<?=$_GET['id']?>" method="post" class="form-horizontal">
                    <div class="form-row link">
                        <div class="col-lg-6"> <!-- IMAGINI ALBUM -->
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="poza_fizic">Album fizic</label>
                                <span class="col-sm-6"><input type="text" name="poza_fizic" id="poza_fizic" value="<?=$album['poza_fizic']?>"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="poza_grup">Fotografie grup</label>
                                <span class="col-sm-6"><input type="text" name="poza_grup" id="poza_grup" value="<?=$album['poza_grup']?>"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="poza_tracklist">Conținut album</label>
                                <span class="col-sm-6"><input type="text" name="poza_tracklist" id="poza_tracklist" value="<?=$album['poza_tracklist']?>"></span>
                            </div>
                        </div>
                        <div class="col-lg-6"> <!-- LINK-URI -->
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="link_spotify">Spotify</label>
                                <span class="col-sm-6"><input type="url" name="link_spotify" id="link_spotify" value="<?=$album['link_spotify']?>"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="link_youtube">Youtube</label>
                                <span class="col-sm-6"><input type="url" name="link_youtube" id="link_youtube" value="<?=$album['link_youtube']?>"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="link_itunes">Apple Music</label>
                                <span class="col-sm-6"><input type="url" name="link_itunes" id="link_itunes" value="<?=$album['link_itunes']?>"></span>
                            </div>
                        </div>
                    </div>                      
                    <div class="buton-update">
                        <input class="buton buton-update" type="submit" value="Actualizare">
                    </div>
                </form>
            </div>


            <!-- VERSIUNI -->
            <div class="header-profil header-update" id="versiuni"> 
                <img src="../layout/logo-admin.png"> 
                <h4><strong> VERSIUNI ALBUM </strong></h4>
                <p> Introduceți denumirea și imaginea pentru maxim 4 versiuni diferite ale albumului. </p>       
            </div>
            <div class="formular-concert album-nou">
                <form action="discografieadmin-update.php?action=update-versions&id=<?=$_GET['id']?>" method="post" class="form-horizontal">
                    <div class="form-row versiuni-form">
                        <div class="col-lg-6"> 
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="versiune1">1. Denumire</label>
                                <span class="col-sm-6">
                                    <input type="text" name="versiune1" id="versiune1" value="<?php if(isset($versiuni['0'])) {echo $versiuni['0']['versiune'];} ?>">
                                </span>
                            </div>
                            <div class="form-group link">
                                <label class="control-label col-sm-4 form-icons" for="versiune1Img">Fotografie</label>
                                <span class="col-sm-6"><input type="text" name="versiune1Img" id="versiune1Img" value="<?php if(isset($versiuni['0'])) {echo $versiuni['0']['poza_ver'];} ?>"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="versiune2">2. Denumire</label>
                                <span class="col-sm-6"><input type="text" name="versiune2" id="versiune2" value="<?php if(isset($versiuni['1'])) {echo $versiuni['1']['versiune'];} ?>"></span>
                            </div>
                            <div class="form-group link">
                                <label class="control-label col-sm-4 form-icons" for="versiune2Img">Fotografie</label>
                                <span class="col-sm-6"><input type="text" name="versiune2Img" id="versiune2Img" value="<?php if(isset($versiuni['1'])) {echo $versiuni['1']['poza_ver'];} ?>"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="versiune3">3. Denumire</label>
                                <span class="col-sm-6"><input type="text" name="versiune3" id="versiune3" value="<?php if(isset($versiuni['2'])) {echo $versiuni['2']['versiune'];} ?>"></span>
                            </div>
                            <div class="form-group link">
                                <label class="control-label col-sm-4 form-icons" for="versiune3Img">Fotografie</label>
                                <span class="col-sm-6"><input type="text" name="versiune3Img" id="versiune3Img" value="<?php if(isset($versiuni['2'])) {echo $versiuni['2']['poza_ver'];} ?>"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="versiune4">4. Denumire</label>
                                <span class="col-sm-6"><input type="text" name="versiune4" id="versiune4" value="<?php if(isset($versiuni['3'])) {echo $versiuni['3']['versiune'];} ?>"></span>
                            </div>
                            <div class="form-group link">
                                <label class="control-label col-sm-4 form-icons" for="versiune4Img">Fotografie</label>
                                <span class="col-sm-6"><input type="text" name="versiune4Img" id="versiune4Img" value="<?php if(isset($versiuni['3'])) {echo $versiuni['3']['poza_ver'];} ?>"></span>
                            </div>
                        </div>
                    </div>                      
                    <div class="buton-update">
                        <input class="buton buton-update" type="submit" value="Actualizare">
                    </div>
                </form>
            </div>
    <?php } ?>
        </div>
    </div>

	</body>
    <?=template_footer()?>
</html>
