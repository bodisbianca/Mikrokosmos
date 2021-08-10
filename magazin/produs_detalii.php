<?php
require_once "../layout/Layout.php";
require_once "Magazin.php";
require_once "CosCumparaturi.php";
session_start();

$id_produs=$_GET['id'];
$produs = new Magazin();

$product_details = $produs->getProductById($id_produs);
$product_images = $produs->getProductPhotos($id_produs);

?>
<?=head_rel($product_details['denumire'].' - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/produs.css">
	<link rel="stylesheet" href="../css_personal/magazin.css">
</head>
<?=template_meniuri()?>
	
	<?php		 
	if (! empty($product_details)) 
	{
	?>
	<div class="detalii">
		<div class="container">
			<div class="row">				
				<div class="col-lg-6 imagini">
					<!-- IMAGINI MICI DE PE MARGINE -->
					<div class="col-3 flex-row imagine-secundara">
						<img src="<?php echo $product_details['poza'];?>" class="img-fluid img-sec" onmouseover="selectImagine(this)">
						<?php 
						if(!empty($product_images))
						{
						foreach($product_images as $imagine)
						{
						?>
						<!-- clasa img-sec nu are un stil anume, e doar utilizata in js pentru a modifica opacitatea dupa hover -->
						<img src="<?php echo $imagine;?>" class="img-fluid img-sec" onmouseover="selectImagine(this)">
						<?php }} ?>
					</div>
					
					<!-- IMAGININE PRINCIPALA -->
					<div class="col-9 imagine-principala">
						<img id="mainImg" src="<?php echo $product_details['poza']; ?>">
					</div>
				</div>

				<!-- INFORMATII + PLASARE COMANDA -->
				<div class="col-lg-6 detalii-form">
					<form method="post" action="cos-client.php?action=add&id=<?php echo $product_details["id"]; ?>">	
						<div>
							<h2><strong><?php echo $product_details["denumire"]; ?></strong></h2>
							<div class="detalii-album">
								<p><?php echo $product_details["descriere"]; ?></p>
							</div>
						</div>
						
						<h3><?php echo $product_details["pret"] . " lei"; ?></h3>
						<div>
							<input type="number" name="cantitate" value="1" size="2" class="input-listing"/>
							<input type="submit" value="Adaugă în coș" class="buton" class="input-listing" />
						</div>					
					</form>
					<br>
					<a href="magazin_index.php">Înapoi la magazin</a>
				</div>
			</div>
		</div>
	</div>
		<?php
		}
		?>

</body>
<?=template_footer()?>
</html>