<?php
require_once "ConcerteAdmin.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}



$concerte = new ConcerteAdmin();
$lista_stadionane = $concerte->getAllStadiums();

if(isset($_GET['id']))
{
    $id_concert = $_GET['id'];
    $detalii_concert = $concerte->getConcertDetails($id_concert);
    $locuri_rezervate = $concerte->getConcertBookedTickets ($id_concert);
    $locuri_totale = $concerte->getConcertSeatsNumber($id_concert);

}


if(!empty($_GET['action']))
{
    switch($_GET['action'])
    {
        case "concert_nou":
            $id_stadion = $_POST['stadion'];
            $nume_concert = $_POST['nume_concert'];
            $poster = $_POST['poster'];
            $data = $_POST['data'];
            $ora = $_POST['ora'];
            $durata = $_POST['durata'];
            $concerte->insertNewConcert($id_stadion, $nume_concert, $poster, $data, $ora, $durata);

            $id_concert = $concerte->getLastInsertedConcertId();
            header('Location: concert-info.php?action=adaugare-succes&id='.$id_concert);
        break;

        case "actualizare":
            $id_stadion = $_POST['stadion'];
            $nume_concert = $_POST['nume_concert'];
            $poster = $_POST['poster'];
            $data = $_POST['data'];
            $ora = $_POST['ora'];
            $durata = $_POST['durata'];
            
            $concerte->updateConcert($id_concert, $id_stadion, $nume_concert, $poster, $data, $ora, $durata);

            header('Location: concert-info.php?action=actualizare-succes&id='.$id_concert);
        break;
    }
}
?>

<?=head_rel('Informații concert - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/harta.css">
    <link rel="stylesheet" href="../css_personal/bilete_concerte.css">
	<link rel="stylesheet" href="../css_personal/login_register.css">
    <link rel="stylesheet" href="../css_personal/profil.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>


<br>
	<body>
        <div class="container">
            <?php 
                if(isset($_GET["action"]))
                {  
                    if($_GET["action"]=="actualizare-succes")
                        {echo "<div class='alert alert-success' role='alert'>Actualizare efectuată cu succes.</div>";} 
                    if($_GET["action"]=="adaugare-succes")
                        {echo "<div class='alert alert-success' role='alert'>Concertul a fost adăugat cu succes.</div>";}
                }
                ?>
            <div class="row">
                <!-- VIZUALIZARE SI ACTUALIZARE CONCERT -->
                <?php if(isset($id_concert)) { ?>
                <div class="col-lg-6 date-actuale date-concert">
                    <h2><strong> CONCERT - <?=strtoupper($detalii_concert['nume_concert'])?> </strong></h2>
                    <ul>
                        <li><strong>Bilete rezervate </strong><span><?php echo $locuri_rezervate."/".$locuri_totale; ?></span></li>
                        <li><strong>Locatie </strong><span><?=$detalii_concert['stadion']." - ".$detalii_concert['oras']?></span></li>
                        <li><strong>Data</strong><span><?=date('d.m.Y', strtotime ($detalii_concert["data"]))?></span></li>
                        <li><strong>Ora </strong><span><?=date('H:i', strtotime ($detalii_concert["ora"]))?></span></li>
                        <li><strong>Durata</strong><span><?=$detalii_concert["durata"]?></span></li>	
                    </ul>
                    <div class="poster">
                        <img src="<?=$detalii_concert["poster"]?>">
                    </div>
                </div>

                <div class="col-lg-6 formular-concert concert-update">
                    <form action="concert-info.php?action=actualizare&id=<?=$id_concert?>" method="post" class="form-horizontal">
                        <h4><strong> ACTUALIZARE CONCERT </strong></h4>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-4 form-icons" for="nume_concert">Titlu concert</label>
                            <span class="col-sm-6"><input type="text" name="nume_concert" id="nume_concert" value="<?=$detalii_concert['nume_concert']?>" required></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4 form-icons" for="stadion">Stadion</label>
                            <span class="col-sm-6">
                                <select class="form-control" id="stadion" name="stadion">
                                <?php
                                    foreach($lista_stadionane AS $stadion)
                                    {
                                        if($detalii_concert['id_stadion']==$stadion['id_stadion'])
                                            echo "<option value='".$stadion['id_stadion']."' selected='selected'>".$stadion['denumire'] . " - " . $stadion['oras']. "</option>";
                                        else
                                        echo "<option value=".$stadion['id_stadion'].">".$stadion['denumire'] . " - " . $stadion['oras']. "</option>";
                                    }
                                ?>
                                </select>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4 form-icons" for="data">Data</label>
                            <span class="col-sm-6"><input type="date" name="data" id="data" value="<?=$detalii_concert['data']?>" required></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4 form-icons" for="ora">Ora</label>
                            <span class="col-sm-6"><input type="time" name="ora" id="ora" value="<?=$detalii_concert['ora']?>" required></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4 form-icons" for="durata">Durata (minute)</label>
                            <span class="col-sm-6"><input type="number" name="durata" id="durata" value="<?=$detalii_concert['durata']?>" required></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4 form-icons" for="poster">Poster</label>
                            <span class="col-sm-6"><input type="text" name="poster" id="poster" value="<?=$detalii_concert['poster']?>" required></span>
                        </div>
                        <div class="buton-update">
                            <input class="buton" type="submit" value="Actualizare">
                        </div>
                    </form>
                </div>
                <?php } else { ?>
            </div>


            <!-- CONCERT NOU -->
            <div class="new">
                <div class="header-profil header-update">
                    <img src="../layout/logo.png"> 
                    <h4><strong> CONCERT NOU </strong></h4>       
                </div>
                <div class="formular-concert concert-nou">
                    <form action="concert-info.php?action=concert_nou" method="post" class="form-horizontal">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-4 form-icons" for="nume_concert">Titlu concert</label>
                                    <span class="col-sm-6"><input type="text" name="nume_concert" id="nume_concert" required></span>
                                </div>
                               <div class="form-group">
                                    <label class="control-label col-sm-4 form-icons" for="ora">Ora</label>
                                    <span class="col-sm-6"><input type="time" name="ora" id="ora" required></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4 form-icons" for="data">Data</label>
                                    <span class="col-sm-6"><input type="date" name="data" id="data" required></span>
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label class="control-label col-sm-4 form-icons" for="stadion">Stadion</label>
                                    <span class="col-sm-6">
                                        <select class="form-control" id="stadion" name="stadion">
                                        <?php
                                            foreach($lista_stadionane AS $stadion)
                                            {
                                                echo "<option value=".$stadion['id_stadion'].">".$stadion['denumire'] . " - " . $stadion['oras']. "</option>";
                                            }
                                        ?>
                                        </select>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4 form-icons" for="durata">Durata (minute)</label>
                                    <span class="col-sm-6"><input type="number" name="durata" id="durata" required></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4 form-icons" for="poster">Poster</label>
                                    <span class="col-sm-6"><input type="text" name="poster" id="poster" required></span>
                                </div>
                            </div>
                        </div>
                        <div class="buton-update">
                            <input class="buton" type="submit" value="Finalizare">
                        </div>
                    </form>
                </div>
                <?php } ?>
            </div>
        </div>
	</body>
    <?=template_footer()?>
</html>
