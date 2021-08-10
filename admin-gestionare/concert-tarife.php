<?php
require_once "../layout/Layout.php";
require_once "../concerte/Stadion.php";
require_once "../concerte/Concerte.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}
?>

<?=head_rel('Tarife concert')?>
    <link rel="stylesheet" href="../css_personal/harta.css">
    <link rel="stylesheet" href="../css_personal/bilete_concerte.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>

<?php 
    $id_concert = $_GET['id'];
    $concert = new Concerte();
    $detalii_concert = $concert -> getConcertDetails($id_concert);

    $id_stadion = $detalii_concert['id_stadion'];
    $layoutStadion = new Stadion();
    $sectiuniN = $layoutStadion -> getAreaSections('N',$id_stadion);
    $sectiuniNV = $layoutStadion -> getAreaSections('NV',$id_stadion); 
    $sectiuniS = $layoutStadion -> getAreaSections('S',$id_stadion);
    $sectiuniSE = $layoutStadion -> getAreaSections('SE',$id_stadion);
    $sectiuniV = $layoutStadion -> getAreaSections('V',$id_stadion);
    $sectiuniE = $layoutStadion -> getAreaSections('E',$id_stadion);
    $sectiuniCentru = $layoutStadion -> getAreaSections('C',$id_stadion);

if (! empty($_GET["action"])) 
{
	 switch ($_GET["action"]) 
	 {
		case "selectare_sectiune":
			if (! empty($_POST["sectiune"])) 
			{					
                $sectiuneSelectata = $layoutStadion->getSectionDetails($_POST['sectiune'], $id_concert);

                //DACA sectiunSelectata e NULL, inseamna ca biletele din sectiunea respectiva NU au pretul setat
                if(empty($sectiuneSelectata))
                {
                    $sectiuneNotPriced = $layoutStadion->getNotPricedSection($_POST['sectiune']);
                }
            }

        case "update_pret":
            if (! empty($_POST["pret_nou"])) 
			{					
                $sectiuneSelectata = $layoutStadion->updateSectionTicketPrice($_GET["id"], $_GET["sectiune"], $_POST["pret_nou"]);
                header('Location: concert-tarife.php?action=actualizare-succes&id='.$id_concert);
            }

        case "set_pret":
            if (! empty($_POST["pret"])) 
            {					
                $sectiuneSelectata = $layoutStadion->setSectionTicketPrice($_GET["id"], $_GET["sectiune"], $_POST["pret"]);
                header('Location: concert-tarife.php?action=tarif-succes&id='.$id_concert);
            }
		break;
     }
}
?>    

    <div class="container">
    <button type="button" class="buton buton-back" onclick="location.href='concerte-lista.php'">Înapoi la concerte</button>
        <div class="row">
            <div class="col-lg-6 stadion">
                <form method="post" action="concert-tarife.php?id=<?=$id_concert?>&action=selectare_sectiune"">
                    <div class="sectiuneVIP"> 
                        <?php
                        if (!empty($sectiuniN))
                        {
                            foreach ($sectiuniN as $key => $value) 
                            {
                                if($sectiuniN[$key]['cod_num']==0) // sectiunea VIP de la ultimul etaj are codul 0
                                {
                        ?>
                        <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniN[$key]['id_sectiune'];?>" id="<?php echo $sectiuniN[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniN[$key]['id_sectiune'];?>"><?php echo $sectiuniN[$key]['cod_alfa'] ;?></label>
                        <?php }}}?>
                    </div>
                    
                    <div class="zonaNord">
                        <div class="sectiune2PeluzaColt">
                            <?php
                            if (!empty($sectiuniNV))
                            {	
                            foreach ($sectiuniNV as $key => $value) 
                            {
                                if($sectiuniNV[$key]['cod_num']==2) // cod_num = 2, adica sectiunea de la etajul 2
                                {
                            ?>
                                <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniNV[$key]['id_sectiune'];?>" id="<?php echo $sectiuniNV[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniNV[$key]['id_sectiune'];?>"><?php echo $sectiuniNV[$key]['cod_num'] . $sectiuniNV[$key]['cod_alfa'] ;?></label>
                            <?php
                            }}}
                            ?>
                        </div>
                        <div class="sectiune2Tribuna">
                            <?php
                            if (!empty($sectiuniN))
                            {
                            foreach ($sectiuniN as $key => $value) 
                            {
                                if($sectiuniN[$key]['cod_num']==2)
                                {
                            ?>
                                <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniN[$key]['id_sectiune'];?>" id="<?php echo $sectiuniN[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniN[$key]['id_sectiune'];?>"><?php echo $sectiuniN[$key]['cod_num'] . $sectiuniN[$key]['cod_alfa'] ;?></label>
                            <?php
                            }} }
                            ?>
                        </div>
                    </div>
                    <div class="zonaNord">
                        <div class="sectiune1PeluzaColt">
                            <?php
                            if (!empty($sectiuniNV))
                            {	
                            foreach ($sectiuniNV as $key => $value) 
                            {
                                if($sectiuniNV[$key]['cod_num']==1) // cod_num=1, adica sectiunea de la etajul 1
                                {
                            ?>
                                <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniNV[$key]['id_sectiune'];?>" id="<?php echo $sectiuniNV[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniNV[$key]['id_sectiune'];?>"><?php echo $sectiuniNV[$key]['cod_num'] . $sectiuniNV[$key]['cod_alfa'] ;?></label>
                            <?php
                            }}}
                            ?>
                        </div>
                        <div class="sectiune1Tribuna">
                            <?php
                            if (!empty($sectiuniN))
                            {
                            foreach ($sectiuniN as $key => $value) 
                            {
                                if($sectiuniN[$key]['cod_num']==1)
                                {
                            ?>
                                <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniN[$key]['id_sectiune'];?>" id="<?php echo $sectiuniN[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniN[$key]['id_sectiune'];?>"><?php echo $sectiuniN[$key]['cod_num'] . $sectiuniN[$key]['cod_alfa'] ;?></label>
                            <?php
                            }} }
                            ?>
                        </div>
                    </div>

                    <div class="peluza-gazon">
                        
                        <div class="sectiune2Peluza">
                            <?php
                            if (!empty($sectiuniV))
                            {	
                            foreach ($sectiuniV as $key => $value) 
                            {
                                if($sectiuniV[$key]['cod_num']==2)
                                {
                            ?>
                            <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniV[$key]['id_sectiune'];?>" id="<?php echo $sectiuniV[$key]['id_sectiune'] ;?>"><label for="<?php echo $sectiuniV[$key]['id_sectiune'];?>"><?php echo $sectiuniV[$key]['cod_num'] . $sectiuniV[$key]['cod_alfa'] ;?></label>
                            <?php
                            }} }
                            ?>
                        </div>

                        <div class="sectiune1Peluza">
                            <?php
                            if (!empty($sectiuniV))
                            {	
                            foreach ($sectiuniV as $key => $value) 
                            {
                                if($sectiuniV[$key]['cod_num']==1)
                                {
                            ?>
                            <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniV[$key]['id_sectiune'];?>" id="<?php echo $sectiuniV[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniV[$key]['id_sectiune'] ;?>"><?php echo $sectiuniV[$key]['cod_num'] . $sectiuniV[$key]['cod_alfa'] ;?></label>
                            <?php
                            }} }
                            ?>
                        </div>

                        <?php 
                        if (!empty($sectiuniCentru))
                        {?>
                        <div class="gazon">
                            <?php
                            foreach ($sectiuniCentru as $key => $value) 
                            {
                                if($sectiuniCentru[$key]['cod_num']==-1) // cod_num == -1, adica partea de gazon simpla
                                {
                            ?>
                            <div>
                                <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniCentru[$key]['id_sectiune'];?>" id="<?php echo $sectiuniCentru[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniCentru[$key]['id_sectiune'];?>"><?php echo $sectiuniCentru[$key]['cod_alfa'];?></label>
                            </div>
                            <?php }
                                if($sectiuniCentru[$key]['cod_num']==-2) // cod_num == -2, adica partea de gazon VIP
                                { ?>
                            <div class="gazon-vip">
                                <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniCentru[$key]['id_sectiune'];?>" id="<?php echo $sectiuniCentru[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniCentru[$key]['id_sectiune'];?>"><?php echo $sectiuniCentru[$key]['cod_alfa'];?></label>
                            </div>
                            <?php }
                            } ?>
                            <div class="scena">
                            </div>
                        </div>
                        <?php }
                        else 
                        {?>
                        <div class="gazon">
                            <div class="gazon-placeholder">GAZON</div>
                            <div class="scena"></div>
                        </div>
                        
                        <?php }?>
                        <div class="sectiune1Peluza">
                            <?php
                            if (!empty($sectiuniE))
                            {	
                            foreach ($sectiuniE as $key => $value) 
                            {
                                if($sectiuniE[$key]['cod_num']==1)
                                {
                            ?>
                            <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniE[$key]['id_sectiune'];?>" id="<?php echo $sectiuniE[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniE[$key]['id_sectiune'];?>"><?php echo $sectiuniE[$key]['cod_num'] . $sectiuniE[$key]['cod_alfa'] ;?></label>
                            <?php
                            }}}
                            ?>
                        </div>

                        <div class="sectiune2Peluza">
                            <?php
                            if (!empty($sectiuniE))
                            {
                            foreach ($sectiuniE as $key => $value) 
                            {
                                if($sectiuniE[$key]['cod_num']==2)
                                {
                            ?>
                            <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniE[$key]['id_sectiune'];?>" id="<?php echo $sectiuniE[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniE[$key]['id_sectiune'];?>"><?php echo $sectiuniE[$key]['cod_num'] . $sectiuniE[$key]['cod_alfa'] ;?></label>
                            <?php
                            }} }
                            ?>
                        </div>
                    </div>

                    <div class="zonaSud">
                        <div class="sectiune1Tribuna">
                            <?php
                            if (!empty($sectiuniS))
                            {	
                            foreach ($sectiuniS as $key => $value) 
                            {
                                if($sectiuniS[$key]['cod_num']==1)
                                {
                            ?>
                                <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniS[$key]['id_sectiune'];?>" id="<?php echo $sectiuniS[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniS[$key]['id_sectiune'];?>"><?php echo $sectiuniS[$key]['cod_num'] . $sectiuniS[$key]['cod_alfa'] ;?></label>
                            <?php
                            }}}
                            ?>
                        </div>
                        <div class="sectiune1PeluzaColt">
                            <?php
                            if (!empty($sectiuniSE))
                            {
                            foreach ($sectiuniSE as $key => $value) 
                            {
                                if($sectiuniSE[$key]['cod_num']==1)
                                {
                            ?>
                                <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniSE[$key]['id_sectiune'];?>" id="<?php echo $sectiuniSE[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniSE[$key]['id_sectiune'];?>"><?php echo $sectiuniSE[$key]['cod_num'] . $sectiuniSE[$key]['cod_alfa'] ;?></label>
                            <?php
                            }} }
                            ?>
                        </div>
                    </div>
                    <div class="zonaSud">
                        <div class="sectiune2Tribuna">
                            <?php
                            if (!empty($sectiuniS))
                            {	
                            foreach ($sectiuniS as $key => $value) 
                            {
                                if($sectiuniS[$key]['cod_num']==2)
                                {
                            ?>
                                <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniS[$key]['id_sectiune'];?>" id="<?php echo $sectiuniS[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniS[$key]['id_sectiune'];?>"><?php echo $sectiuniS[$key]['cod_num'] . $sectiuniS[$key]['cod_alfa'] ;?></label>
                            <?php
                            }}}
                            ?>
                        </div>
                        <div class="sectiune2PeluzaColt">
                            <?php 
                            if (!empty($sectiuniSE))
                            {
                            foreach ($sectiuniSE as $key => $value) 
                            {
                                if($sectiuniSE[$key]['cod_num']==2)
                                {
                            ?>
                                <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniSE[$key]['id_sectiune'];?>" id="<?php echo $sectiuniSE[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniSE[$key]['id_sectiune'];?>"><?php echo $sectiuniSE[$key]['cod_num'] . $sectiuniSE[$key]['cod_alfa'] ;?></label>
                            <?php
                            }} }
                            ?>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-6 detalii-form formular-sectiune" id="formular-bilete">
                <div>  
                    <div class="header-update">
                        <h3><strong> GESTIONAREA TARIFELOR </strong></h3>
                        <?php
                        if(empty($_POST["sectiune"])) 
                            {echo "<p> Selectați secțiunea stadionului pentru care doriți să vizualizați tariful </p>";}
 
                        if(isset($_GET["action"]))
                        {  
                            if($_GET["action"]=="tarif-succes")
                                {echo "<div class='alert alert-success' role='alert'>Tariful biletelor a fost setat cu succes.</div>";} 
                            if($_GET["action"]=="actualizare-succes")
                                {echo "<div class='alert alert-success' role='alert'>Actualizarea a fost efectuată cu succes.</div>";}
                        }
                        ?>
                    </div>
                    

                    <!-- MODIFICARE PRET -->
                    <?php if(!empty($sectiuneSelectata)) { ?>
                    <div class="formular-actualizare">
                        <h4> ACTUALIZARE TARIF </h4>
                        <!-- INFORMATII ZONA -->
                        <div class="detalii-zona">              
                            <?php 
                            if(!empty($sectiuneSelectata))
                            { 
                                if($sectiuneSelectata['cod_num']>0)
                                {
                            ?>                       
                                <ul>
                                    <span><strong><?php echo strtoupper($sectiuneSelectata['zona']) . " " . $sectiuneSelectata['cod_num']; ?></span>
                                    <li>SECȚIUNEA <?php echo $sectiuneSelectata['cod_num'] . $sectiuneSelectata['cod_alfa']; ?></strong></li>
                                </ul> 
                            <?php } else { ?>    
                                <ul>
                                    <span><strong><?php echo strtoupper($sectiuneSelectata['zona']);?></span>
                                    <li>ZONA <?php echo $sectiuneSelectata['orientare']; ?></strong></li>
                                </ul>
                            <?php }
                            }
                            ?>
                        </div>

                        <br>
                        <form action="concert-tarife.php?id=<?=$id_concert?>&sectiune=<?=$sectiuneSelectata['id_sectiune']?>&action=update_pret" method="post" class="form">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-5 form-icons" for="pret_vechi">Pret curent</label>
                                        <span class="col-sm-2"><input type="number" name="pret_vechi" id="pret_vechi" value="<?=$sectiuneSelectata['pret']?>" readonly></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-5 form-icons" for="pret_nou">Pret nou</label>
                                        <span class="col-sm-2"><input type="number" name="pret_nou" id="pret_nou" required></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input class="buton" type="submit" value="Actualizare">
                                </div>
                            </div>
                        </form>
                    </div> 
                    <?php } ?>

                    <!-- DESFASURARE SECTIUNE SELECTATA -->
                    <div>
                        <?php 
                        if(!empty($sectiuneSelectata)) 
                        {
                            if(!empty($sectiuneSelectata['randuri']) && !empty($sectiuneSelectata['coloane'])) //daca are randuri si coloane, afiseaza harta locurilor
                            {?>
                            
                            <div class="desfasurareSectiune">
                                <?php 
                                for($row=$sectiuneSelectata['randuri']; $row>=1; $row--)
                                {
                                    for($col=1; $col<=$sectiuneSelectata['coloane']; $col++)
                                    {
                                        $numarBilet = $row . "-" . $col;
                                        if($sectiuneSelectata['cod_num']<=0) //daca sectiunea e etaj vip, locurile au alta dimensiune si culoare
                                        {?>
                                            <input type="checkbox" name="seat[]" value="<?php echo $numarBilet; ?>" id="<?php echo $numarBilet; ?>"><label class="zona-vip" for="<?php echo $numarBilet; ?>"></label>
                                        <?php }
                                        else
                                        {?>
                                            <input type="checkbox" name="seat[]" value="<?php echo $numarBilet; ?>" id="<?php echo $numarBilet; ?>"><label for="<?php echo $numarBilet; ?>"></label>
                                        <?php }
                                    }
                                    echo "<br>";
                                }
                                ?>
                            </div>
                            <?php
                            }
                            else
                            {
                                $numarBilet = rand(1,$sectiuneSelectata['locuri']);
                                if(!empty($locuri_rezervate))
                                {
                                    while(in_array($numarBilet, $locuri_rezervate)==TRUE)
                                    {
                                        $numarBilet = mt_rand(1,$sectiuneSelectata['locuri']); 
                                    }
                                }
                                $numarBilet = $sectiuneSelectata['cod_alfa'] . "-" . $numarBilet;
                            ?>
                            <input type="text" name="seat[]" value="<?php echo $numarBilet; ?>" id="<?php echo $numarBilet; ?>" style="display:none;"readonly>
                            <p id="observatie"> Notă: Biletele din aceasta sectiune se genereaza aleator. </p>  
                            <?php } ?>
                        <?php } ?>  
                    </div>

                    
                    

                    <!-- DACA PRETUL NU E SETAT-->
                    <?php 
                    if(!empty($sectiuneNotPriced))
                    { ?>
                    <div class="formular-actualizare">
                        <h4> SETARE TARIF </h4>
                        <!-- INFORMATII ZONA -->
                        <div class="detalii-zona">              
                            <?php 
                            if(!empty($sectiuneNotPriced))
                            { 
                                if($sectiuneNotPriced['cod_num']>0)
                                {
                            ?>                       
                                <ul>
                                    <span><strong><?php echo strtoupper($sectiuneNotPriced['zona']) . " " . $sectiuneNotPriced['cod_num']; ?></span>
                                    <li>SECȚIUNEA <?php echo $sectiuneNotPriced['cod_num'] . $sectiuneNotPriced['cod_alfa']; ?></strong></li>
                                </ul> 
                            <?php } else { ?>    
                                <ul>
                                    <span><strong><?php echo strtoupper($sectiuneNotPriced['zona']);?></span>
                                    <li>ZONA <?php echo $sectiuneNotPriced['orientare']; ?></strong></li>
                                </ul>
                            <?php }
                            }
                            ?>
                        </div>
                        <br>                        
                        <form method="post" action="concert-tarife.php?id=<?=$id_concert?>&sectiune=<?=$sectiuneNotPriced['id_sectiune']?>&action=set_pret">                         
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-5 form-icons" for="pret">Pret bilete</label>
                                        <span class="col-sm-2"><input type="number" name="pret" id="pret" required></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input class="buton" type="submit" value="Setare pret">
                                </div>
                        </form>
                    </div> 
                    <?php
                    }
                    ?>
                </div>
        </div>
        </div>
    </div> 
</body>
<?=template_footer()?>
</html>