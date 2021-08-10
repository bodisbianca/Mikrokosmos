<?php
require_once "../layout/Layout.php";
require_once "Stadion.php";
require_once "Concerte.php";
session_start();
?>

<?=head_rel('Rezervare bilete - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/magazin.css">
    <link rel="stylesheet" href="../css_personal/produs.css">
    <link rel="stylesheet" href="../css_personal/harta.css">
    <link rel="stylesheet" href="../css_personal/bilete_concerte.css">
<?=template_meniuri()?>

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
                $id_sectiune = $_POST['sectiune'];
                $sectiuneSelectata = $layoutStadion->getSectionDetails($id_sectiune, $id_concert);
                $locuri_rezervate = $layoutStadion->checkUnavailableSeats($id_sectiune, $id_concert);
                if(!empty($locuri_rezervate))
                {$nr_locuri_rezervate = sizeof($locuri_rezervate);}
                else
                {$nr_locuri_rezervate=0;}
            }
		break;
     }
}
?>    
    <div class="container rezervari-bilete">
        <div class="row">
            <div class="col-lg-6 stadion">
                <form method="post" action="bilete-concert.php?id=<?php echo $id_concert; ?>&action=selectare_sectiune">
                    <div class="sectiuneVIP"> 
                        <?php
                        if (!empty($sectiuniN))
                        {
                            foreach ($sectiuniN as $key => $value) 
                            {
                                if($sectiuniN[$key]['cod_num']==0)
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
                                if($sectiuniNV[$key]['cod_num']==2)
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
                            }}}
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
                                if($sectiuniNV[$key]['cod_num']==1)
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
                            }}}
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
                            }}}
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
                            }}}
                            ?>
                        </div>

                        <?php 
                        if (!empty($sectiuniCentru))
                        {?>
                        <div class="gazon">
                            <?php
                            foreach ($sectiuniCentru as $key => $value) 
                            {
                                if($sectiuniCentru[$key]['cod_num']==-1)
                                {
                            ?>
                            <div>
                                <input onclick="javascript: submit()" type="radio" name="sectiune" value="<?php echo $sectiuniCentru[$key]['id_sectiune'];?>" id="<?php echo $sectiuniCentru[$key]['id_sectiune'];?>"><label for="<?php echo $sectiuniCentru[$key]['id_sectiune'];?>"><?php echo $sectiuniCentru[$key]['cod_alfa'];?></label>
                            </div>
                            <?php }
                                if($sectiuniCentru[$key]['cod_num']==-2)
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
                            }}}
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
                            }}} 
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
                            }}}
                            ?>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-6 detalii-form" id="formular-bilete">
                <div>  
                    <h2><strong><?php echo "Concert - " . $detalii_concert['nume_concert'];?></strong></h2>
                    <div class="detalii-zona detalii-concert">
                        <ul>
                            <span><?php echo $detalii_concert['stadion'];?></span>
                            <li><?php echo date('d.m.Y', strtotime ($detalii_concert['data']));?></li>
                            <li><?php echo "ora " . date('H:i', strtotime ($detalii_concert['ora']));?></li>
                            <li><?php echo $detalii_concert['durata'] . " minute";?></li>
                        </ul>
                        <?php if (empty($sectiuneSelectata)) {?>
                        <img src="<?php echo $detalii_concert['poster'];?>">
                        <?php } ?>
					</div>

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
                                <li>DISPONIBILITATE: <strong><?php echo $sectiuneSelectata['locuri'] - $nr_locuri_rezervate ."/".$sectiuneSelectata['locuri']; ?> </strong></li>
                            </ul> 
                        <?php 
                            }
                            else
                            {
                        ?>    
                             <ul>
                                <span><strong><?php echo strtoupper($sectiuneSelectata['zona']);?></span>
                                <li>ZONA <?php echo $sectiuneSelectata['orientare']; ?></strong></li>
                                <li>DISPONIBILITATE: <strong><?php echo $sectiuneSelectata['locuri'] - $nr_locuri_rezervate ."/".$sectiuneSelectata['locuri']; ?> </strong></li>
                            </ul>
                        <?php }?>
                            <p>  </p>
                            <h4><?php echo $sectiuneSelectata['pret']. " lei/bilet"; ?></h4>
                        <?php
                        }
                        else 
                        {
                            echo "Selectati o sectiune a stadionului de pe harta.";
                        }
                        ?>
					</div>

                   <?php 
                        if(!empty($sectiuneSelectata))
                        {?>
                    <form method="post" action="cos-bilete.php?action=add&concert=<?php echo $id_concert;?>&sectiune=<?php echo $id_sectiune;?>">
                        <?php 
                        if(!empty($sectiuneSelectata['randuri']) && !empty($sectiuneSelectata['coloane'])) //daca are randuri si coloane, afiseaza harta locurilor
                        {?>
                        
                        <div class="desfasurareSectiune">
                            <?php 
                            for($row=$sectiuneSelectata['randuri']; $row>=1; $row--)
                            {
                                for($col=1; $col<=$sectiuneSelectata['coloane']; $col++)
                                {
                                    $numarBilet = $row . "-" . $col;
                                    if(!empty($locuri_rezervate) && in_array($numarBilet, $locuri_rezervate)==TRUE) //daca locul e rezervat, disable input
                                    {
                                        if($sectiuneSelectata['cod_num']<=0) //daca sectiunea e etaj vip, locurile au alta dimensiune
                                        {
                                        ?>
                                        <input disabled type="checkbox" name="bookedseat" id="<?php echo $numarBilet; ?>"><label class="zona-vip rezervat" for="<?php echo $numarBilet; ?>"></label>
                                        <?php }
                                        else
                                        {?>
                                        <input disabled type="checkbox" name="bookedseat" id="<?php echo $numarBilet; ?>"><label class="rezervat" for="<?php echo $numarBilet; ?>"></label>
                                        <?php
                                        }
                                    }
                                    else 
                                    {
                                        if($sectiuneSelectata['cod_num']<=0) //daca sectiunea e etaj vip, locurile au alta dimensiune si culoare
                                        {?>
                                            <input type="checkbox" name="seat[]" value="<?php echo $numarBilet; ?>" id="<?php echo $numarBilet; ?>"><label class="zona-vip" for="<?php echo $numarBilet; ?>"></label>
                                        <?php }
                                        else
                                        {?>
                                            <input type="checkbox" name="seat[]" value="<?php echo $numarBilet; ?>" id="<?php echo $numarBilet; ?>"><label for="<?php echo $numarBilet; ?>"></label>
                                        <?php }
                                    }
                                } echo "<br>";
                            }?>
                        </div>
                        <input type="button" class="buton" id="clear-seats" onclick="clearSeats()" value="Resetare locuri alese">
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
                        <?php }
                        
                        if($sectiuneSelectata['locuri'] - $nr_locuri_rezervate!=0)
                        {?>
                        <input type="submit" value="Adaugă în coș" id="place-order" class="buton" class="input-listing" />  
                    <?php }}?>
                    </form>                    
                </div>
            </div>
        </div>
    </div> 
   
</body>

<?=template_footer()?>
</html>