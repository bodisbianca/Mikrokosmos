<?php
require_once "ConcerteAdmin.php";
require_once "../concerte/Stadion.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin-autentificare/autentificare-admin.php');
	exit;
}
?>

<?=head_rel('Structură stadion - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/bilete_concerte.css">
    <link rel="stylesheet" href="../css_personal/harta_noua.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>

<?php 
$id_stadion = $_GET['id'];
$actiuniAdmin = new ConcerteAdmin();
$stadion_detalii = $actiuniAdmin->getStadiumById($id_stadion);

if (! empty($_GET["action"])) 
{
	switch ($_GET["action"]) 
	{
		case "update":
            $actiuniAdmin->updateStadiumDetails($id_stadion, $_POST['denumire'], $_POST['oras']);
            header("Location:stadion-actualizare.php?update=succes&id=".$id_stadion);
        break;
    }
}

?>    
<body>

<div class="container">
    <div class="row">
    <div class="new-stadium">
        <div class="detalii-form form-stadion" id="formular-bilete">
            <form action="stadion-actualizare.php?action=update&id=<?=$stadion_detalii['id_stadion']?>" method="post" class="form-horizontal">
                <h3><strong> ACTUALIZARE DETALII STADION </strong></h3>
                <h4>Stadion - <?=$stadion_detalii['denumire']?></h4><br>
                <?php 
                    if(isset($_GET["update"]))
                    {  
                        if($_GET["update"]=="succes")
                            {echo "<div class='alert alert-success' role='alert'>Actualizare efectuată cu succes.</div>";} 
                    }
                ?>
                <div class="form-group">
                    <label class="control-label col-sm-2 form-icons" for="denumire">Stadion</label>
                    <span class="col-sm-2"><input type="text" name="denumire" id="denumire" value="<?=$stadion_detalii['denumire']?>" required></span>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 form-icons" for="oras">Localitate</label>
                    <span class="col-sm-2"><input type="text" name="oras" id="oras" value="<?=$stadion_detalii['oras']?>" required></span>
                </div>
                <input class="buton" type="submit" value="Actualizare">
            </form>
        </div>
    </div>
</div>

</body>
<?=template_footer()?>
</html>
