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

if(isset($_GET['id']))
{
    $id_video = $_GET['id'];
    $videoclip = $infoAdmin->getVideoById($id_video);
}



if(isset($_GET['action']))
{
    switch($_GET['action'])
    {
        case "video-nou":
            $infoAdmin->addNewVideo($_POST['titlu'], $_POST['data'], $_POST['link'], $_POST['categorie']);
        break;

        case "update":
            $infoAdmin->updateVideo($id_video,$_POST['titlu'], $_POST['data'], $_POST['link'], $_POST['categorie']);
            header("Location: videoclipuriadmin-nou.php?id=$id_video&update=succes");
    }
}
?>

<?=head_rel('Videoclip - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
    <link rel="stylesheet" href="../css_personal/profil.css">
    
    <link rel="stylesheet" href="../css_personal/magazin_admin.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>


<br>
	<body>
    <div class="container">
        <?php if (!isset($_GET['id'])) { ?> <!-- VIDEOCLIP NOU -->
        <div class="new">
            <div class="header-profil header-update">
                <img src="../layout/logo-admin.png"> 
                <h4><strong> VIDEOCLIP NOU </strong></h4>  
                <p>Obs: Introduceti link de tip <strong>embed</strong> pentru videoclipurile din sursa <strong>YouTube. </strong></p>      
                <?php 
                    if(isset($_GET["action"]))
                    {  
                        if($_GET["action"]=="video-nou")
                        { 
                            echo "<div class='alert alert-success' role='alert'>Videoclip adăugat cu succes!</div>";
                        }
                    }
                    ?>
            </div>
            <div class="formular-concert video-nou">
                <form action="videoclipuriadmin-nou.php?action=video-nou" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-5 form-icons" for="titlu">Titlu videoclip</label>
                        <span class="col-sm-6"><input type="text" name="titlu" id="titlu" required></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5 form-icons" for="data">Data postării</label>
                        <span class="col-sm-6"><input type="date" name="data" id="data" required></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5 form-icons" for="link">Link YouTube</label>
                        <span class="col-sm-6"><input type="url" name="link" id="link" required></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5 form-icons" for="categorie">Categorie</label>
                        <span class="col-sm-6">
                            <select class="form-control" id="categorie" name="categorie">
                            <?php
                                foreach($video_subcategory AS $categorie)
                                {
                                    echo "<option value=".$categorie ['categorie'].">".$categorie ['categorie']. "</option>";
                                }
                            ?>
                            </select>
                        </span>
                    </div>
                    <div class="buton-update">
                        <input class="buton" type="submit" value="Finalizare">
                    </div> 
                </form>
            </div>
        </div>
        <?php } 
        else { ?>

        <div class="new"> <!-- ACTUALIZARE -->
            <div class="header-profil header-update">
                <img src="../layout/logo-admin.png"> 
                <h4><strong> ACTUALIZARE VIDEOCLIP </strong></h4>  
                <p>Obs: Introduceti link de tip <strong>embed</strong> pentru videoclipurile din sursa <strong>YouTube. </strong></p>      
                <?php 
                    if(isset($_GET["update"]))
                    {  
                        if($_GET["update"]=="succes")
                        { 
                            echo "<div class='alert alert-success' role='alert'>Videoclip actualizat cu succes!</div>";
                        }
                    }
                    ?>
            </div>
            <div class="formular-concert video-nou">   
                <form action="videoclipuriadmin-nou.php?action=update&id=<?=$id_video?>" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-5 form-icons" for="titlu">Titlu videoclip</label>
                        <span class="col-sm-6"><input type="text" name="titlu" id="titlu" value='<?=$videoclip['titlu']?>' required></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5 form-icons" for="data">Data postării</label>
                        <span class="col-sm-6"><input type="date" name="data" id="data" value="<?=$videoclip['data']?>" required></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5 form-icons" for="link">Link YouTube</label>
                        <span class="col-sm-6"><input type="url" name="link" id="link" value="<?=$videoclip['link']?>" required></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5 form-icons" for="categorie">Categorie</label>
                        <span class="col-sm-6">
                            <select class="form-control" id="categorie" name="categorie">
                            <?php
                                foreach($video_subcategory AS $categorie)
                                {
                                    if($categorie['categorie'] == $videoclip['categorie'])
                                        echo "<option value=".$categorie ['categorie']." selected='selected'>".$categorie ['categorie']. "</option>";
                                    else 
                                        echo "<option value=".$categorie ['categorie'].">".$categorie ['categorie']. "</option>";
                                }
                            ?>
                            </select>
                        </span>
                    </div>
                    <div class="buton-update">
                        <input class="buton" type="submit" value="Actualizare">
                    </div> 
                </form>
            </div>
        </div>

        <?php } ?>
	</body>
    <?=template_footer()?>
</html>
