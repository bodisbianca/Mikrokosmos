<?php 
require_once "../layout/Layout.php";
require_once "Prezentare.php";
session_start();

$info = new Prezentare();
$video_subcategory = $info->getAllVideoCategories();

if (! empty($_GET["categ"])) 
{
    $video_array = $info->getVideosByCategory($_GET['categ']);
}
else{
    $video_array = $info->getVideosByCategory('index');
}
?>


<?=head_rel('Videoclipuri - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/magazin.css">
    <link rel="stylesheet" href="../css_personal/prezentare.css">
</head>

<?=template_meniuri()?>

    <div class="titlu">
        <h3><strong>VIDEOCLIPURI</strong></h3>
        <p>
            Faceți cunoștință cu formația sud coreeană BTS!
        </p>
    </div>


    <div id="container_categ_mag">
        <div class="categorii_magazin">
          <ul>
            <li id=""><a href="videoclipuri.php">PAGINA PRINCIPALA</a></li>
            <?php 
            if(!empty($video_subcategory))
            {
                foreach($video_subcategory AS $key => $categorie)
                {?>
                    <li id=""><a href="videoclipuri.php?categ=<?=$categorie['categorie'];?>"><?php echo strtoupper($categorie ['categorie']); ?></a></li>
                <?php 
                }
            }
            ?>
          </ul>
        </div>
    </div>

    <div class="container videoclipuri">    
        <?php
        if (! empty($video_array)) 
        { 
            foreach ($video_array as $key => $video) 
            {
        ?>
        <div class="row">
            <div class="col-lg-8 video">
                <div class="embed-responsive embed-responsive-16by9 videoclip">
                    <iframe class="embed-responsive-item" src="<?php echo $video['link'] ?>" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-4 detalii-video">
                <div>
                    <h4><strong><?php echo $video['titlu']?></strong></h4>
                    <p><?php echo date('d.m.Y', strtotime ($video['data']));?></p>
                </div>
            </div>
        </div>
        <?php } }?>
    </div>

    </body>
    <?=template_footer()?>
</html>