<?php 
require_once "../layout/Layout.php";
require_once "Magazin.php";
require_once "CosCumparaturi.php";
session_start();

$products = new Magazin();
$category_array = $products->getAllCategories();
?>


<?=head_rel('Produse noi - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/magazin.css">
</head>

<?=template_meniuri()?>

    <div id="container_categ_mag">
        <div class="categorii_magazin">
          <ul>
            <li id=""><a href="magazin_index.php">PRODUSE NOI</a></li>
            <?php 
            if(!empty($category_array))
            {
                foreach($category_array AS $key => $categorie)
                {
                    if($categorie ['categorie']=="ALBUME")
                    {
                    ?>
                    <li id=""><a href="magazin_albume.php"><?php echo ($categorie ['categorie']); ?></a></li>
                <?php }
                    else 
                    { 
                    ?>
                    <li id=""><a href="magazin_produse.php?categ=<?php echo($categorie ['categorie']); ?>"><?php echo$categorie ['categorie']; ?></a></li>
                <?php }
                }
            }
            ?>
          </ul>
        </div>
    </div>
    
    <?php
    foreach ($category_array as $categorie)
    {?>
    <div class="container categorie-prod-home">
        <?php
            $newest_products = $products->getNewestProducts($categorie['categorie']);
            if(!empty($newest_products))
            {
        ?>
        <div class="row">
            <div class="head-prod-home col-md-3">
                <?php if($categorie['categorie']=='ALBUME') {?>
                <h3><a href="magazin_albume.php"><?php echo strtoupper($categorie['categorie']);?></a></h3>
                <?php } else { ?>
                <h3><a href="magazin_produse.php?categ=<?php echo $categorie['categorie'];?>"><?php echo $categorie['categorie'];?></a></h3>
                <?php } ?>
            </div>
            <?php 
                foreach($newest_products as $produs)
                {
            ?>
            <div class="listing col-md-3">
                <form method="post" action="cos-client.php?action=add&id=<?php echo $produs["id"]; ?>">
                    <img src="<?php echo $produs["poza"]; ?>">
                    <div>
                        <?php if($categorie['categorie']=='ALBUME') {?>
                        <a href="produs_album.php?id=<?php echo $produs['id'] ?>"><strong><?php echo $produs["denumire"]; ?></strong></a>
                        <?php } else { ?>
                        <a href="produs_detalii.php?id=<?php echo $produs['id'] ?>"><strong><?php echo $produs["denumire"]; ?></strong></a>
                        <?php } ?>
                        <p class="product-price"><?php echo $produs["pret"]; ?> lei</p>
                    </div>
                    <div>
                        <?php if($categorie['categorie']=='ALBUME') {?>
                        <button type="button" class="buton" onclick="location.href='produs_album.php?id=<?php echo $produs['id']?>'">Detalii</button>
                        <?php } else { ?>
                        <input type="number" name="cantitate" value="1" size="2" class="input-listing"/>
                        <input type="submit" value="Adaugă în coș" class="buton"/>
                        <?php } ?>
                    </div>
                </form>
            </div>
            <?php }?>
        </div>
        <?php }?>
    </div>
    <?php } ?>
    </body>
    <?=template_footer()?>
</html>