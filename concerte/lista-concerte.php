<?php
require_once "../layout/Layout.php";
require_once "Concerte.php";
session_start();
?>

<?=head_rel('Concerte - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/magazin.css">
    <link rel="stylesheet" href="../css_personal/produs.css">
    <link rel="stylesheet" href="../css_personal/bilete_concerte.css">
<?=template_meniuri()?>

<?php
$concerts = new Concerte();
$concerts_array = $concerts -> getAllConcerts();
?>


<div>
    <div class="container lista-concerte">    
        <?php
        if (! empty($concerts_array)) 
        {
            foreach ($concerts_array as $key => $value) 
            {
        ?>
        <div class="row listing-concert">
            <div class="col-sm-4 poster-concert">
                <img src="<?php echo $concerts_array[$key]['poster'];?>">
            </div>
            <div class="col-sm-6">
                <a href='bilete-concert.php?id=<?php echo $concerts_array[$key]['id_concert'] ?>'><h4><strong> Concert <?php echo $concerts_array[$key]['nume_concert']; ?> </strong></h4></a>
                <ul class="info-concert">
                    <li><i class="fas fa-map-marker-alt"></i> <?php echo $concerts_array[$key]['oras']; ?> - <?php echo $concerts_array[$key]['stadion']; ?></li>
                    <li><i class="fas fa-calendar-alt"></i> <?php echo date('d.m.Y', strtotime ($concerts_array[$key]['data']));?></li>
                    <li><i class="fas fa-clock"></i> <?php echo date('H:i', strtotime ($concerts_array[$key]['ora'])) ; ?></li>
                </ul>
            </div>
            <div class="col-sm-2 buton-rezervare">
                <button type="button" class="buton" onclick="location.href='bilete-concert.php?id=<?php echo $concerts_array[$key]['id_concert'] ?>'">Rezervare bilet</button>
            </div>
        </div>
        <?php } }?>
    </div>
</div> 
</body>

<?=template_footer()?>
</html>