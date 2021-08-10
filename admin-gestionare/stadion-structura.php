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
$stadionNou = new ConcerteAdmin();

if (! empty($_GET["action"])) 
{
	switch ($_GET["action"]) 
	{
		case "harta-noua":
            $stadionNou->addNewStadium($_POST['denumire'], $_POST['oras']);
            $id_stadion = $stadionNou->getLastInsertedStadiumId();
            $denumire = $_POST['denumire'];
            $oras = $_POST['oras'];
        break;

        case "actualizare-harta":
            $id_stadion = $_GET['id'];
            $detalii_stadion = $stadionNou->getStadiumById($id_stadion);
            $denumire = $detalii_stadion['denumire'];
            $oras = $detalii_stadion['oras'];
        break;

        case "selectare_sectiune":
			if (! empty($_POST["sectiune"])) 
			{	
                $id_stadion = $_GET['id'];	
                $detalii_stadion = $stadionNou->getStadiumById($id_stadion);
                $denumire = $detalii_stadion['denumire'];
                $oras = $detalii_stadion['oras'];
                
                $detalii_sectiune = explode("_", $_POST["sectiune"]);
                $zona = $detalii_sectiune[0];
                $orientare = $detalii_sectiune[1];
                $cod_num = $detalii_sectiune[2];
            }
		break;

        case "adaugare_sectiune":
            $id_stadion = $_GET['id'];
            $detalii_stadion = $stadionNou->getStadiumById($id_stadion);
            $denumire = $detalii_stadion['denumire'];
            $oras = $detalii_stadion['oras'];
            
            $succes = $stadionNou->insertNewStadiumSection($id_stadion, $_POST['zona'],$_POST['cod_alfa'],$_POST['cod_num'],$_POST['orientare'],$_POST['randuri'],$_POST['coloane'],$_POST['locuri']);
        break;
    }
}

?>    

<div class="container">
    <div class="row">
        <?php 
        if(!empty($id_stadion))
        {
        ?>
        <div class="col-lg-6 stadion"> <!-- CONFIGURARE LAYOUT -->
            <form method="post" action="stadion-structura.php?action=selectare_sectiune&id=<?=$id_stadion?>">
                <div class="sectiuneVIP"> 
                    <input onclick="javascript: submit()" type="radio" name="sectiune" value="etaj-VIP_N_0" id="etajVIP_N_0"><label for="etajVIP_N_0">VIP NORD</label>
                </div>
                
                <div class="zonaNord">
                    <div class="sectiune2PeluzaColt">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="peluza_NV_2" id="peluza_NV_2"><label for="peluza_NV_2">PELUZA N-V, ETAJ 2</label>
                    </div>
                    <div class="sectiune2Tribuna">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="tribuna_N_2" id="tribuna_N_2"><label for="tribuna_N_2">TRIBUNA NORD, ETAJ 2</label>
                    </div>
                </div>
                <div class="zonaNord">
                    <div class="sectiune1PeluzaColt">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="peluza_NV_1" id="peluza_NV_1"><label for="peluza_NV_1">PELUZA N-V, ETAJ 1</label>
                    </div>
                    <div class="sectiune1Tribuna">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="tribuna_N_1" id="tribuna_N_1"><label for="tribuna_N_1">TRIBUNA NORD, ETAJ 1</label>
                    </div>
                </div>

                <div class="peluza-gazon">
                    <div class="sectiune2Peluza">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="peluza_V_2" id="peluza_V_2"><label for="peluza_V_2">PELUZA VEST, ETAJ 2</label>
                    </div>
                    <div class="sectiune1Peluza">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="peluza_V_1" id="peluza_V_1"><label for="peluza_V_1">PE. VEST, ETAJ 1</label>
                    </div>

                    <div class="gazon">
                        <div>
                            <input onclick="javascript: submit()" type="radio" name="sectiune" value="gazon_C_-1" id="gazon_C_-1"><label for="gazon_C_-1">GAZON</label>
                        </div>
                        <div class="gazon-vip">
                            <input onclick="javascript: submit()" type="radio" name="sectiune" value="gazon-VIP_C_-2" id="gazonVIP_C_-2"><label for="gazonVIP_C_-2">GAZON VIP</label>
                        </div>

                        <div class="scena"></div>
                    </div>
                    
                    
                    <div class="sectiune1Peluza">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="peluza_E_1" id="peluza_E_1"><label for="peluza_E_1">PE. EST, ETAJ 1</label>
                    </div>
                    <div class="sectiune2Peluza">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="peluza_E_2" id="peluza_E_2"><label for="peluza_E_2">PELUZA EST, ETAJ 2</label>
                    </div>
                </div>

                <div class="zonaSud">
                    <div class="sectiune1Tribuna">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="tribuna_S_1" id="tribuna_S_1"><label for="tribuna_S_1">TRIBUNA SUD, ETAJ 1</label>
                    </div>
                    <div class="sectiune1PeluzaColt">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="peluza_SE_1" id="peluza_SE_1"><label for="peluza_SE_1">PELUZA S-E, ETAJ 1</label>
                    </div>
                </div>
                <div class="zonaSud">
                    <div class="sectiune2Tribuna">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="tribuna_S_2" id="tribuna_S_2"><label for="tribuna_S_2">TRIBUNA SUD, ETAJ 2</label>
                    </div>
                    <div class="sectiune2PeluzaColt">
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="peluza_SE_2" id="peluza_SE_2"><label for="peluza_SE_2">PELUZA S-E, ETAJ 2</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-6 detalii-form formular-sectiune" id="formular-bilete">
            <form action="stadion-structura.php?action=adaugare_sectiune&id=<?=$id_stadion?>" method="post" class="form ">
                
                <div class="detalii-zona">
                    <h4><strong>STADION NOU </strong></h4>
                    <h5><?=strtoupper($denumire)?></h5>
                    <p><?=$oras?></p>
                    <button type="button" class="buton buton-new" onclick="location.href='stadion-config.php?id=<?=$id_stadion?>'">Vizualizare stadion</button>
                </div>

                <h5> Introducere sectiune noua</h5>
                <br>
                <?php 
                if($_GET["action"]=="adaugare_sectiune")
                    { if ($succes == 0) 
                        {echo "<div class='alert alert-danger' role='alert'>Completati randurile si coloanele SAU numarul de locuri.</div>";} 
                    elseif  ($succes == -1) 
                        {echo "<div class='alert alert-danger' role='alert'>Randurile si coloanele trebuie sa fie ambele 0 sau valori nenule.</div>";}
                    else
                        {echo "<div class='alert alert-success' role='alert'>Sectiune actualizata cu succes.</div>";} 
                    }
                ?>
            
                <!-- DACA A FOST SELECTATA O ZONA, CONFIGUREAZA SECTIUNEA -->
                <?php if (! empty($_POST["sectiune"])) { ?>
                <div class="form-inline info-sectiune">
                    <div class="form-group">
                        <label class="control-label   form-icons" for="zona">Zona</label>
                        <span class=" "><input type="text" name="zona" id="zona" value=<?=$zona?> readonly></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label form-icons" for="cod_num">Etaj</label>
                        <span class=""><input type="number" name="cod_num" id="cod_num" value=<?=$cod_num?> readonly></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label form-icons" for="orientare">Orientare</label>
                        <span class=""><input type="text" name="orientare" id="orientare" value=<?=$orientare?> readonly></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-4 form-icons" for="cod_alfa">Cod</label>
                            <span class="col-sm-2"><input type="text" maxlength="4" placeholder="A, A1, B etc." name="cod_alfa" id="cod_alfa" required></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4 form-icons" for="locuri">Locuri</label>
                            <span class="col-sm-2"><input type="text" name="locuri" id="locuri"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-4 form-icons" for="randuri">Randuri</label>
                            <span class="col-sm-2"><input type="number" name="randuri" id="randuri" value = "0" required></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4 form-icons" for="coloane">Coloane</label>
                            <span class="col-sm-2"><input type="number" name="coloane" id="coloane" value = "0" required></span>
                        </div>
                    </div>
                </div>
                <input class="buton" type="submit" value="Adăugare secțiune">
                <?php } ?>

            </form>
        </div>
    </div>
        <?php } 
        else { ?> <!-- FORMULAR PRINCIPAL PENTRU NUME SI LOCATIE STADION-->
    <div class="new-stadium">
        <div class="detalii-form form-stadion" id="formular-bilete">
            <form action="stadion-structura.php?action=harta-noua" method="post" class="form-horizontal">
                <h3><strong> STADION NOU </strong></h3>
                <p> Introduceți denumirea și locația stadionului. </p>
                <div class="form-group">
                    <label class="control-label col-sm-2 form-icons" for="denumire">Stadion</label>
                    <span class="col-sm-2"><input type="text" name="denumire" id="denumire" required></span>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 form-icons" for="oras">Localitate</label>
                    <span class="col-sm-2"><input type="text" name="oras" id="oras" required></span>
                </div>
                <input class="buton" type="submit" value="Următorul pas">
            </form>
        </div>
        <?php } ?>
    </div>
</div>

</body>
<?=template_footer()?>
</html>
