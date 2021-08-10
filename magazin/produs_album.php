<?php
require_once "../layout/Layout.php";
require_once "Magazin.php";
require_once "CosCumparaturi.php";
session_start();

$id_produs=$_GET['id'];
$album = new Magazin();

$product_details = $album->getAlbumById($id_produs);
$product_images = $album->getAlbumPhotos($id_produs);
$product_versions = $album->getAlbumVersions($id_produs);
?>
<?=head_rel($product_details['0']['denumire'].' - Mikrokosmos')?>
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
					<div class="col-3 flex-column imagine-secundara">
						<?php 
						foreach($product_images as $imagine)
						{
							if(!empty($imagine))
							{
						?>
						<!-- clasa img-sec nu are un stil anume, e doar utilizata in js pentru a modifica opacitatea dupa hover -->
						<img src="<?php echo $imagine;?>" class="img-fluid img-sec" onmouseover="selectImagine(this)">
						<?php }} ?>
					</div>
					
					<!-- IMAGININE PRINCIPALA -->
					<div class="col-9 imagine-principala">
						<img id="mainImg" src="<?php echo $product_images['coperta'] ?>">
					</div>
				</div>

				<!-- INFORMATII + PLASARE COMANDA -->
				<?php
					foreach ($product_details as $key => $value) 
					{
				?>
				<div class="col-lg-6 detalii-form">
					<form method="post" action="cos-client.php?action=add-album&id=<?php echo $product_details[$key]["id"]; ?>">	
						<div>
							<a href="../prezentare/discografie-album.php?id=<?=$product_details[$key]["id_alb"]?>"><h2><strong><?php echo $product_details[$key]["denumire"]; ?></strong></h2></a>
							<div class="detalii-album">
								<ul>
									<span><?php echo "album " . $product_details[$key]['limba'];?></span>
									<li><?php echo $product_details[$key]['an_aparitie']; ?></li>
									<li><?php echo $product_details[$key]['nr_cantece'] . " cântece"; ?></li>
									<li><?php echo $product_details[$key]['durata'] . " minute"; ?></li>
								</ul>
							</div>
						</div>

						<?php if(! empty($product_versions)) { ?>
						<div>
							<h5 id="versiuni-titlu"><strong> Versiuni </strong></h5>
							<div class="versiuni-album">
								<?php	
									foreach ($product_versions as $keyVer => $value)
									{
								?>
									<input type="radio" name="versiune" value="<?php echo $product_versions[$keyVer]['id_ver']; ?>" 
									id="<?php echo $product_versions[$keyVer]['versiune']; ?>" checked> 
									<label for="<?php echo $product_versions[$keyVer]['versiune']; ?>"><?php echo $product_versions[$keyVer]['versiune']; ?></label>
									<?php
									}
									?>
									
							</div>
						</div>
						<!-- versiune NULL daca albumul nu are mai multe versiuni -->
						<?php } 
							else { echo "<input type='radio' name='versiune' value='' id='null_ver' style='display: none;' checked>";} 
						?> 
						
						<h3><?php echo $product_details[$key]["pret"] . " lei"; ?></h3>
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
		}}
		?>

</body>
<?=template_footer()?>
</html>