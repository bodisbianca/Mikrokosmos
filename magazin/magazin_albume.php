<?php 
require_once "../layout/Layout.php";
require_once "Magazin.php";
require_once "CosCumparaturi.php";
session_start();

$products = new Magazin();
$product_array = $products->getAllAlbums();
$category_array = $products->getAllCategories();
?>


<?=head_rel('Albume - Mikrokosmos')?>
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
                    if($categorie ['categorie']=="albume")
                    {?>
                    <li id=""><a href="magazin_albume.php"><?php echo $categorie ['categorie']; ?></a></li>
                <?php }
                    else 
                    {?>
                    <li id=""><a href="magazin_produse.php?categ=<?php echo($categorie ['categorie']); ?>"><?php echo $categorie ['categorie']; ?></li>
                <?php }
                }
            }
            ?>
          </ul>
        </div>

        <div class="subcategorii_magazin" id="meniuSubBar">
            <ul>
                <li><a href="magazin_albume">Toate</a></li>
                <?php
                $subcategories = new Layout();
                $subcategory_array = $subcategories->getMenuSubcategories();

                if (! empty($subcategory_array)) 
                {
                    foreach ($subcategory_array as $key => $value) 
                    {
                ?>
                <li>
                    <a href="magazin_subcategorie.php?subcateg=<?php echo $subcategory_array[$key]['tip_album']; ?>"><?php echo 'Album ' . $subcategory_array[$key]['tip_album'];?></a>
                </li>
                <?php } ?>
            </ul>
            <?php } ?>
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
                <img src="<?php echo $product_array[$key]["poza"];?>">
                <div>
                    <a href="produs_album.php?id=<?php echo $product_array[$key]['id'] ?>"><strong><?php echo $product_array[$key]["denumire"]; ?></strong></a>
                </div>
                <div class="product-price"><?php echo $product_array[$key]["pret"]; ?> lei</div>
                <button type="button" class="buton" onclick="location.href='produs_album.php?id=<?php echo $product_array[$key]['id'] ?>'">Detalii</button>
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