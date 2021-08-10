<?php 
require_once "../layout/Layout.php";
require_once "Magazin.php";
require_once "CosCumparaturi.php";
session_start();

$products = new Magazin();
$category_array = $products->getAllCategories();
if(!empty($_GET['categ']))
{
    $product_array = $products->getProductsByCategory($_GET['categ']);
    $categorie = ucfirst($_GET['categ']);
}
?>


<?=head_rel($categorie .' - Mikrokosmos')?>
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

    <div class="container">
        <div class="row">
            <?php
            if (! empty($product_array)) 
            {
                foreach ($product_array as $key => $value) 
                {
            ?>
		    <div class="listing col-md-6 col-lg-4">
                <form method="post" action="cos-client.php?action=add&id=<?php echo $product_array[$key]["id"]; ?>">
                    <img src="<?php echo $product_array[$key]["poza"];?>">
                    <div>
                        <a href="produs_detalii.php?id=<?php echo $product_array[$key]['id'] ?>"><strong><?php echo $product_array[$key]["denumire"]; ?></strong></a>
                    </div>
                    <div class="product-price"><?php echo $product_array[$key]["pret"]; ?> lei</div>
                    <div>
                        <input type="number" name="cantitate" value="1" size="2" class="input-listing"/>
                        <input type="submit" value="Adaugă în coș" class="buton" class="input-listing" />
					</div>	
                </form>
		    </div>
            <?php
			}
		 }
		 ?>
        </div>
	</div>
    </body>
    <?=template_footer()?>
</html>