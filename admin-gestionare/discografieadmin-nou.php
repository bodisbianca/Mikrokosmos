<?php
require_once "MagazinAdmin.php";
require_once "DiscografieAdmin.php";
require_once "../magazin/Magazin.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}

$produs = new Magazin();

$adminAlbume = new DiscografieAdmin();

$adminProduse = new MagazinAdmin();
$category_array = $adminProduse->getProductCategories();
$an_curent = date("Y");

if(isset($_GET['id']))
{
    $id_produs = $_GET['id'];
    $id_album = $adminAlbume->getAlbumId($id_produs);
}


if(!empty($_GET['action']))
{
    switch($_GET['action'])
    {
        case "album_nou":
            $denumire = $_POST['denumire'];
            $poza = $_POST['poza'];
            $categorie_prod = $_POST['categorie'];
            $pret = $_POST['pret'];
            $cantitate = $_POST['cantitate'];
            $descriere = $_POST['descriere'];
            $adminProduse->addNewProduct($denumire, $poza, $categorie_prod, $pret, $cantitate, $descriere);

            $id_produs = $adminProduse->getLastInsertedProductId();

            $limba = $_POST['limba'];
            $an_aparitie = $_POST['an_aparitie'];
            $durata = $_POST['durata'];
            $nr_cantece = $_POST['nr_cantece'];
            $tip_album = $_POST['tip_album'];

            $adminAlbume->addNewAlbum($id_produs, $limba, $an_aparitie, $durata, $nr_cantece, $tip_album);

            $id_produs = $adminAlbume->getLastInsertedAlbumId();

            header('Location: discografieadmin-nou.php?action=imagini-link&id='.$id_produs);
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
            
            $adminAlbume->updateImagesLinks($id_produs, $poza_fizic, $poza_grup, $poza_tracklist, $link_spotify, $link_itunes, $link_youtube);
            header('Location: discografieadmin-nou.php?action=versiuni&id='.$id_produs); 
        break;

        case "add-versions":
            if(!empty($_POST['versiune1']) && $_POST['versiune1Img'] != '../media/')
                $adminAlbume->addNewVersion($id_produs, $_POST['versiune1'], $_POST['versiune1Img']);
            if(!empty($_POST['versiune2']) && $_POST['versiune2Img'] != '../media/')
                $adminAlbume->addNewVersion($id_produs, $_POST['versiune2'], $_POST['versiune2Img']);
            if(!empty($_POST['versiune3']) && $_POST['versiune3Img'] != '../media/')
                $adminAlbume->addNewVersion($id_produs, $_POST['versiune3'], $_POST['versiune3Img']);
            if(!empty($_POST['versiune4']) && $_POST['versiune4Img'] != '../media/')
                $adminAlbume->addNewVersion($id_produs, $_POST['versiune4'], $_POST['versiune4Img']);

           header('Location: discografieadmin-album.php?id='.$id_album);
        break;
    }
}
?>

<?=head_rel('Actualizare produs - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/produs.css">
    <link rel="stylesheet" href="../css_personal/magazin.css">
    <link rel="stylesheet" href="../css_personal/profil.css"> 
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
    <link rel="stylesheet" href="../css_personal/magazin_admin.css">
   
<?=template_meniuriADMIN()?>


<br>
	<body>                 
    <!-- ALBUM NOU -->
    
    <div class="container">
        <div class="new">
            <?php if(!isset($_GET['id'])) { ?>

            <!-- INFORMATII PRINCIPALE -->
            <div class="header-profil header-update"> 
                <img src="../layout/logo-admin.png"> 
                <h4><strong> ALBUM NOU </strong></h4>       
            </div>
            <div class="formular-concert album-nou">
                <form action="discografieadmin-nou.php?action=album_nou" method="post" class="form-horizontal">
                    <div class="form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="denumire">Titlu</label>
                                <span class="col-sm-8"><input type="text" name="denumire" id="denumire" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="categorie">Categorie</label>
                                <span class="col-sm-6"><input type="text" name="categorie" id="categorie" value="ALBUME" readonly></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="cantitate">Cantitate</label>
                                <span class="col-sm-6"><input type="number" name="cantitate" id="cantitate" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="pret">Preț</label>
                                <span class="col-sm-6"><input type="number" step=".01" name="pret" id="pret" required></span>
                            </div>
                            <div class="form-group link">
                                <label class="control-label col-sm-4 form-icons" for="poza">Copertă</label>
                                <span class="col-sm-6"><input type="text" name="poza" id="poza" value="../media/" required></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-5 form-icons" for="tip_album">Tip album</label>
                                <span class="col-sm-6"><input type="text" name="tip_album" id="tip_album" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5 form-icons" for="limba">Limba</label>
                                <span class="col-sm-6"><input type="text" name="limba" id="limba" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5 form-icons" for="an_aparitie">An aparitie</label>
                                <span class="col-sm-6"><input type="number" name="an_aparitie" id="an_aparitie" max="<?=$an_curent?>" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5 form-icons" for="durata">Durata</label>
                                <span class="col-sm-6"><input type="number" name="durata" id="durata" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5 form-icons" for="nr_cantece">Număr de cântece</label>
                                <span class="col-sm-6"><input type="number" name="nr_cantece" id="nr_cantece" required></span>
                            </div>
                        </div>
                        <div class="col descriere-album">
                            <div class="form-group">
                                <label class="control-label form-icons" for="descriere">Descriere</label>
                                <textarea class=" form-control" name="descriere" id="descriere" rows="4"></textarea>  
                            </div>
                        </div>
                    </div>
                    <div class="buton-update">
                        <input class="buton buton-update" type="submit" value="Pasul următor">
                    </div> 
                </form>
            </div>
            <?php } ?>

            <?php if(isset($_GET['action'])) 
            {
                if($_GET['action']=='imagini-link')
                {
            ?> 


            <!-- IMAGINI SUPLIMENTARE SI LINK-URI EXTERNE -->
            <div class="header-profil header-update">
                <img src="../layout/logo-admin.png"> 
                <h4><strong> IMAGINI ȘI LINK-URI EXTERNE </strong></h4> 
                <p>Obs: Introduceti link de tip <strong>embed</strong> pentru videoclipurile din sursa <strong>YouTube. </strong></p>      
            </div>
            <div class="formular-concert album-nou ">
                <form action="discografieadmin-nou.php?action=update_imagini-link&id=<?=$id_produs?>" method="post" class="form-horizontal">
                    <div class="form-row link">
                        <div class="col-lg-6"> <!-- IMAGINI ALBUM -->
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="poza_fizic">Album fizic</label>
                                <span class="col-sm-6"><input type="text" name="poza_fizic" id="poza_fizic" value="../media/"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="poza_grup">Fotografie grup</label>
                                <span class="col-sm-6"><input type="text" name="poza_grup" id="poza_grup" value="../media/"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="poza_tracklist">Conținut album</label>
                                <span class="col-sm-6"><input type="text" name="poza_tracklist" id="poza_tracklist" value="../media/"></span>
                            </div>
                        </div>
                        <div class="col-lg-6"> <!-- LINK-URI -->
                            <div class="form-group">
                                <label class="control-label col-sm-5 form-icons" for="link_spotify">Spotify</label>
                                <span class="col-sm-6"><input type="url" name="link_spotify" id="link_spotify"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5 form-icons" for="link_youtube">Youtube</label>
                                <span class="col-sm-6"><input type="url" name="link_youtube" id="link_youtube"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5 form-icons" for="link_itunes">Apple Music</label>
                                <span class="col-sm-6"><input type="url" name="link_itunes" id="link_itunes"></span>
                            </div>
                        </div>
                    </div>                      
                    <div class="butoane-modif">
                        <input class="buton buton-update" type="submit" value="Pasul următor">
                        <button type="button" class="buton buton-delete" onclick="location.href='discografieadmin-nou.php?action=versiuni&id=<?=$id_produs?>'">Sari peste</button>
                    </div>
                </form>
            </div>


            <!-- VERSIUNI -->
            <?php }
                if($_GET['action']=='versiuni')
                { ?>
            <div class="header-profil header-update"> 
                <img src="../layout/logo-admin.png"> 
                <h4><strong> VERSIUNI ALBUM </strong></h4>
                <p> Introduceți denumirea și imaginea pentru maxim 4 versiuni diferite ale albumului. </p>       
            </div>
            <div class="formular-concert album-nou">
                <form action="discografieadmin-nou.php?action=add-versions&id=<?=$id_produs?>" method="post" class="form-horizontal">
                    <div class="form-row versiuni-form">
                        <div class="col-lg-6"> 
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="versiune1">1. Denumire</label>
                                <span class="col-sm-6"><input type="text" name="versiune1" id="versiune1" required></span>
                            </div>
                            <div class="form-group link">
                                <label class="control-label col-sm-4 form-icons" for="versiune1Img">Fotografie</label>
                                <span class="col-sm-6"><input type="text" name="versiune1Img" id="versiune1Img" value="../media/" required></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="versiune2">2. Denumire</label>
                                <span class="col-sm-6"><input type="text" name="versiune2" id="versiune2"></span>
                            </div>
                            <div class="form-group link">
                                <label class="control-label col-sm-4 form-icons" for="versiune2Img">Fotografie</label>
                                <span class="col-sm-6"><input type="text" name="versiune2Img" id="versiune2Img" value="../media/"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="versiune3">3. Denumire</label>
                                <span class="col-sm-6"><input type="text" name="versiune3" id="versiune3"></span>
                            </div>
                            <div class="form-group link">
                                <label class="control-label col-sm-4 form-icons" for="versiune3Img">Fotografie</label>
                                <span class="col-sm-6"><input type="text" name="versiune3Img" id="versiune3Img" value="../media/"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="versiune4">4. Denumire</label>
                                <span class="col-sm-6"><input type="text" name="versiune4" id="versiune4"></span>
                            </div>
                            <div class="form-group link">
                                <label class="control-label col-sm-4 form-icons" for="versiune4Img">Fotografie</label>
                                <span class="col-sm-6"><input type="text" name="versiune4Img" id="versiune4Img" value="../media/"></span>
                            </div>
                        </div>
                    </div>                      
                    <div class="butoane-modif">
                        <input class="buton buton-update" type="submit" value="Finalizare">
                        <button type="button" class="buton buton-delete" onclick="location.href='discografieadmin-album.php?id=<?=$id_album?>'">Sari peste și finalizează</button>
                    </div>
                </form>
            </div>
            <?php } } ?>
        </div>
    </div>
	</body>
    <?=template_footer()?>
</html>
