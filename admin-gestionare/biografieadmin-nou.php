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

if(isset($_GET['id']))
{
    $id_subcapitol = $_GET['id'];
    $subcapitol = $infoAdmin->getSubChapterById($id_subcapitol);
}



if(isset($_GET['action']))
{
    switch($_GET['action'])
    {
        case "subcapitol-nou":
            if(!empty($_POST['informatii']))
                $infoAdmin->addNewSubchapter($_POST['subtitlu'], $_POST['imagine'], $_POST['informatii']);
            else 
                header("Location: biografieadmin-nou.php?action=noinfo");
        break;

        case "update":
            $infoAdmin->updateSubchapter($id_subcapitol,$_POST['subtitlu'], $_POST['imagine'], $_POST['informatii']);
            header("Location: biografieadmin-nou.php?id=$id_subcapitol&update=succes");
    }
}
?>

<?=head_rel('Subcapitol biografie - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
    <link rel="stylesheet" href="../css_personal/profil.css">
    
    <link rel="stylesheet" href="../css_personal/magazin_admin.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>


<br>
	<body>
    <div class="container">
        <?php if (!isset($_GET['id'])) { ?> <!-- SUBCAPITOL NOU -->
        <div class="new">
            <div class="header-profil header-update">
                <img src="../layout/logo-admin.png"> 
                <h4><strong> SUBCAPITOL NOU </strong></h4>  
                <p>Obs: Marcați <strong>finalul unui paragraf</strong> cu <strong>\n</strong> pentru structurarea mai bună a textului la afișare. </strong></p>      
                <?php 
                    if(isset($_GET["action"]))
                    {  
                        if($_GET["action"] == "subcapitol-nou")
                           {echo "<div class='alert alert-success' role='alert'>Subcapitol adăugat cu succes!</div>";}
                        if($_GET["action"] == "noinfo")
                            {echo "<div class='alert alert-danger' role='alert'>Introduceți informații aferente subcapitolului!</div>";}
                    }
                    ?>
            </div>
            <div class="formular-concert subcapitol-nou">
                <form action="biografieadmin-nou.php?action=subcapitol-nou" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-4 form-icons" for="subtitlu">Titlu subcapitol</label>
                        <span class="col-sm-7"><input type="text" name="subtitlu" id="subtitlu" required></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 form-icons" for="imagine">Imagine</label>
                        <span class="col-sm-7"><input type="text" name="imagine" id="imagine"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 form-icons" for="informatii" id="lbl_info">Informații</label>
                        <textarea class="col-sm-7 form-control" name="informatii" id="informatii" rows="5"></textarea>
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
                <h4><strong>ACTUALIZARE SUBCAPITOL </strong></h4>  
                <p>Obs: Marcați <strong>finalul unui paragraf</strong> cu <strong>\n</strong> pentru structurarea mai bună a textului la afișare. </strong></p>      
                <?php 
                    if(isset($_GET["update"]))
                    {  
                        if($_GET["update"]=="succes")
                        { 
                            echo "<div class='alert alert-success' role='alert'>Subcapitol adăugat cu succes!</div>";
                        }
                    }
                    ?>
            </div>
            <div class="formular-concert subcapitol-nou">
                <form action="biografieadmin-nou.php?action=update&id=<?=$id_subcapitol?>" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-4 form-icons" for="subtitlu">Titlu subcapitol</label>
                        <span class="col-sm-7"><input type="text" name="subtitlu" id="subtitlu" value="<?=$subcapitol['subtitlu']?>" required></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 form-icons" for="imagine">Imagine</label>
                        <span class="col-sm-7"><input type="text" name="imagine" id="imagine" value="<?=$subcapitol['imagine']?>"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 form-icons" for="informatii" id="lbl_info">Informații</label>
                        <textarea class="col-sm-7 form-control" name="informatii" id="informatii" rows="5"><?=$subcapitol['informatii']?></textarea>
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
