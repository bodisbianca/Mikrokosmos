<?php 
require_once "../layout/Layout.php";
require_once "Prezentare.php";
session_start();

$info = new Prezentare();
$date_biografice = $info->getBiography();

?>


<?=head_rel('BTS - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/prezentare-album.css">
    <link rel="stylesheet" href="../css_personal/prezentare-biografie.css">
</head>

<?=template_meniuri()?>

<div class="prezentare">
    <div class="container">    
        <?php
            if (! empty($date_biografice)) 
            { 
                foreach ($date_biografice as $key => $subcapitol) 
                {
            ?>
        <div class="row album">  
            <div class="col-lg-5 imagine-biografie">
                <div class="">
                    <img src="<?=$subcapitol['imagine']?>">
                </div>
            </div>

            <div class="col-lg-7 informatii-biografie">
                <div class="titlu-subcapitol">
                    <h4><strong><?=strtoupper($subcapitol['subtitlu']);?></strong></h4>
                </div>
                <div>
                    <?php 
                    $paragrafe_informatii = explode('\n', $subcapitol['informatii']);
                    foreach($paragrafe_informatii AS $paragraf)
                    {
                        echo "<p>".$paragraf."</p>";
                    }
                    ?>
                </div>
            </div>
        </div> 
        <?php }} ?>   
    </div>
</div>
</body>
<?=template_footer()?>
</html>