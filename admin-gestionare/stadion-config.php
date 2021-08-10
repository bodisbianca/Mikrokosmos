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

<?=head_rel('Hartă stadion - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/harta.css">
    <link rel="stylesheet" href="../css_personal/bilete_concerte.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
<?=template_meniuriADMIN()?>

<?php 
    $id_stadion = $_GET['id'];

    $actiuniAdmin = new ConcerteAdmin();
    $layoutStadion = new Stadion();
    $sectiuniN = $layoutStadion -> getAreaSections('N',$id_stadion);
    $sectiuniNV = $layoutStadion -> getAreaSections('NV',$id_stadion); 
    $sectiuniS = $layoutStadion -> getAreaSections('S',$id_stadion);
    $sectiuniSE = $layoutStadion -> getAreaSections('SE',$id_stadion);
    $sectiuniV = $layoutStadion -> getAreaSections('V',$id_stadion);
    $sectiuniE = $layoutStadion -> getAreaSections('E',$id_stadion);
    $sectiuniCentru = $layoutStadion -> getAreaSections('C',$id_stadion);

    $informatii_stadion = $layoutStadion->getStadiumDetails($id_stadion);

    
if (! empty($_GET["action"])) 
{
	 switch ($_GET["action"]) 
	 {
         
		case "selectare_sectiune":
			if (! empty($_POST["sectiune"])) 
			{					
                $id_sectiune = $_POST['sectiune'];
                $sectiuneSelectata = $layoutStadion->getStadiumSectionById($id_stadion, $id_sectiune);
            }
		break;

        case "actualizare_sectiune":
            $id_sectiune=$_GET['sectiune'];
            $succes = $actiuniAdmin->updateStadiumSection($id_stadion, $id_sectiune, $_POST['zona'],$_POST['cod_alfa'],$_POST['cod_num'],$_POST['orientare'],$_POST['randuri'],$_POST['coloane'],$_POST['locuri']);
        break;

        case "eliminare":
            $id_sectiune=$_GET['sectiune'];
            $actiuniAdmin->deleteStadiumSection($id_stadion, $id_sectiune);
            header('Location: stadion-config.php?id='.$id_stadion);
     }
}
?>    

<div class="container">
    <button type="button" class="buton buton-back" onclick="location.href='stadioane.php'">Înapoi la stadioane</button>
    <div class="row">
        <div class="col-lg-6 stadion"> <!-- HARTA STADIONULUI -->
            <form method="post" action="stadion-config.php?id=<?php echo $id_stadion; ?>&action=selectare_sectiune">
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
                    <h2><strong><?php echo "STADION - " . $informatii_stadion['denumire'];?></strong></h2>
                    <button type="button" class="buton buton-new" onclick="location.href='stadion-structura.php?action=actualizare-harta&id=<?=$id_stadion?>'">Secțiune nouă</button>
                    <br>

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
                        else 
                        { echo "Selectati o sectiune a stadionului de pe harta.";}
                        ?>
					</div>

                     <?php 
                        if(isset($_GET["action"]))
                        {  
                            if($_GET["action"]=="actualizare_sectiune")
                            { if ($succes == 0) 
                                {echo "<div class='alert alert-danger' role='alert'>Completați rândurile și coloanele SAU numărul de locuri.</div>";} 
                            elseif  ($succes == -1) 
                                {echo "<div class='alert alert-danger' role='alert'>Rândurile și coloanele trebuie să fie ambele 0 sau valori nenule.</div>";}
                            else
                                {echo "<div class='alert alert-success' role='alert'>Secțiune actualizată cu succes.</div>";} 
                            }
                        }
                        ?>


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

                    
                    <!-- MODIFICARE SECTIUNE SELECTATA -->
                    <?php if(!empty($sectiuneSelectata)) { ?>
                    <div class="formular-actualizare">
                        <h5><strong> Actualizare secțiune </strong></h5>
                        <br>
                        <form action="stadion-config.php?id=<?php echo $id_stadion;?>&sectiune=<?=$id_sectiune?>&action=actualizare_sectiune" method="post" class="form">
                            <div class="form-inline info-sectiune">
                                <div class="form-group">
                                    <label class="control-label col-sm-5 form-icons" for="zona">Zona</label>
                                    <span class="col-sm-6"><input type="text" name="zona" id="zona" value=<?=$sectiuneSelectata['zona']?> readonly></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5 form-icons" for="cod_num">Etaj</label>
                                    <span class="col-sm-6"><input type="number" name="cod_num" id="cod_num" value=<?=$sectiuneSelectata['cod_num']?> readonly></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5 form-icons" for="orientare">Orientare</label>
                                    <span class="col-sm-6"><input type="text" name="orientare" id="orientare" value=<?=$sectiuneSelectata['orientare']?> readonly></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 form-icons" for="cod_alfa">Cod</label>
                                        <span class="col-sm-2"><input type="text" maxlength="4" placeholder="A, A1, B etc."name="cod_alfa" id="cod_alfa" value=<?=$sectiuneSelectata['cod_alfa']?>></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 form-icons" for="locuri">Locuri</label>
                                        <span class="col-sm-2"><input type="text" name="locuri" id="locuri" value=<?=$sectiuneSelectata['locuri']?>></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 form-icons" for="randuri">Rânduri</label>
                                        <span class="col-sm-2"><input type="number" name="randuri" id="randuri" value=<?=$sectiuneSelectata['randuri']?> required></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 form-icons" for="coloane">Coloane</label>
                                        <span class="col-sm-2"><input type="number" name="coloane" id="coloane" value=<?=$sectiuneSelectata['coloane']?> required></span>
                                    </div>
                                </div>
                            </div>
                            <div id="update-sectiune">
                                <button type="button" class="buton buton-delete" onclick="location.href='stadion-config.php?action=eliminare&id=<?=$id_stadion?>&sectiune=<?=$id_sectiune?>'">Eliminare</button>
                                <input class="buton" type="submit" value="Actualizare">
                            </div>
                        </form>
                    </div> 
                    <?php } ?>
                </div>
        </div>
        
    </div> 
</div>

</body>
<?=template_footer()?>
</html>
