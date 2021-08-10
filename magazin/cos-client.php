<?php
require_once "../layout/Layout.php";
require_once "CosCumparaturi.php";
require_once "Comanda.php";
session_start();

if (!isset($_SESSION['loggedin'])) 
{
	header('Location: ../utilizator/autentificare.php');
	exit;
}


$id_user=$_SESSION['id'];
$shoppingCart = new CosCumparaturi();
if (! empty($_GET["action"])) 
{
	 switch ($_GET["action"]) 
	 {
		 case "add":
			 if (! empty($_POST["cantitate"])) 
			 {
				$productResult = $shoppingCart->getProductById($_GET["id"]);
				$cartResult = $shoppingCart->getCartItemByProduct($productResult[0]["id"], $id_user);

				if (! empty($cartResult)) 
				{
					 $newQuantity = $cartResult[0]["cantitate"] + $_POST["cantitate"];
					 $shoppingCart->updateCartQuantity($newQuantity, $cartResult[0]["id_cos"]);
				} 
				else 
				{
					$shoppingCart->addToCart($productResult[0]["id"], $_POST["cantitate"], $id_user);					
				}
			}
		break;

		case "add-album":
			if (! empty($_POST["cantitate"])) 
			{
			   $productResult = $shoppingCart->getProductById($_GET["id"]);
			   $cartResult = $shoppingCart->getCartItemByProduct($productResult[0]["id"], $id_user); /*verifica daca albumul e deja in cart*/

			   if (! empty($cartResult)) /*daca e in cart, verifica daca e aceeasi versiune */
			   {
				   $cosActualizat = 0;
				   foreach ($cartResult as $albumCos)
				   { 
					   if ($albumCos['id_ver'] == $_POST['versiune']) /* daca e aceeasi versiune, update cantitate */
						{
							$newQuantity = $albumCos["cantitate"] + $_POST["cantitate"];
							$shoppingCart->updateCartQuantity($newQuantity, $albumCos["id_cos"]);
							$cosActualizat = 1;	
						}
				   }

				   if($cosActualizat == 0) /* daca nu e aceeasi versiune, adauga albumul in cart */
				   {
					if($_POST['versiune'])
						{ $shoppingCart->addAlbumToCart($productResult[0]["id"], $_POST['versiune'], $_POST["cantitate"], $id_user);}
					else
				 		{ $shoppingCart->addToCart($productResult[0]["id"], $_POST["cantitate"], $id_user);}
				   }

			   } 
			   else 
			   {
				   if($_POST['versiune'])
				   	{ $shoppingCart->addAlbumToCart($productResult[0]["id"], $_POST['versiune'], $_POST["cantitate"], $id_user);}
				   else
				    { $shoppingCart->addToCart($productResult[0]["id"], $_POST["cantitate"], $id_user);}					
			   }
		   }
	   break;
		
		case "remove":
			$shoppingCart->deleteCartItem($_GET["id"]);
		break;
		
		case "empty":
			$shoppingCart->emptyCart($id_user);
		break;
		
		case "trimitere":
		{
			$comandaUser = new Comanda();
			$itemComanda = $comandaUser->getOrder($id_user);
			if (! empty($itemComanda)) 
			{
				$comandaUser->registerOrderAddress($id_user, $_POST['suma_totala'], $_POST['judet'], $_POST['localitate'], $_POST['strada'], $_POST['numar'], $_POST['apartament'], $_POST['codzip'] );
				foreach ($itemComanda as $item) 
				{		
					$comandaUser->registerOrderProducts($id_user, $item["id_prod"], $item["id_ver"], $item["cantitate"]);
				}
			}
		}
		break;
		
	}
}
?>

<?=head_rel('Coș cumpărături - Mikrokosmos')?>
<link rel="stylesheet" href="../css_personal/cos.css">
<?=template_meniuri()?>


<body>
<br>

	<?php
		$cartItem = $shoppingCart->getUserCartItem($id_user);
		if (! empty($cartItem)) 
		{
			$item_total = 0;
	?>
	<div id="shopping-cart" class="container">
		<div class="row">
			<div class="col-lg-8 produse"> <!-- cosul de produse -->
				<div class="titlu-cos">
					<h3><i class="fas fa-shopping-cart"></i><strong> COȘ CUMPĂRĂTURI </strong></h3>
				</div>
				
				<table class="table">
					<thead>
						<tr>
							<th colspan="2">Produs</th>
							<th>Cantitate</th>
							<th>Preț</th>				
							<th colspan="2">Modificare</th>		
						</tr>
					</thead>
					<tbody>
						<?php foreach ($cartItem as $item) 
						{ 
						?>
						<tr>
							<?php if($item['categorie']=='ALBUME'){ ?> <!-- PENTRU ALBUME -->
							<td class="img">
								<a href="produs_album.php?id=<?=$item['id']?>">
									<img src="<?=$item['poza']?>" width="50" height="50"alt="<?=$item['denumire']?>">
								</a>
							</td>
							<td>
								<a href="produs_album.php?id=<?=$item['id']?>">
									<?php echo $item["denumire"]; ?>
								</a>
								<p> <?php echo $item['versiune'];?> </p>
							</td>
							<?php } else { ?> <!-- PENTRU RESTUL PRODUSELOR -->
								<td class="img">
								<a href="produs_detalii.php?id=<?=$item['id']?>">
									<img src="<?=$item['poza']?>" width="50" height="50"alt="<?=$item['denumire']?>">
								</a>
							</td>
							<td>
								<a href="produs_detalii.php?id=<?=$item['id']?>">
									<?php echo $item["denumire"]; ?>
								</a>
							</td>
							<?php } ?>
							
							<td><?php echo $item["cantitate"]; ?></td>
							<td><?php echo $item['cantitate']*$item["pret"] . " lei"; ?></td>
							<td>
								<a href="cos-client.php?action=remove&id=<?php echo $item["id_cos"]; ?>">
									<i class="far fa-times-circle"></i> Elimina
								</a>
							</td>
						</tr>
						<?php
						$item_total += ($item["pret"] * $item["cantitate"]);
						}
						?>
						<tr>
							<td colspan="2"><strong>Metoda de plată: </strong> RAMBURS</td>
							<td><strong>TOTAL</strong></td>
							<td><strong><?=$item_total?> lei</strong></td>
							<td><a id="btnEmpty" href="cos-client.php?action=empty">Golire coș </a></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-lg-4 adresa"> <!-- formular cu adresa -->
				<div class="titlu-cos">
					<h3><i class="fas fa-map-marked-alt"></i><strong> ADRESĂ LIVRARE </strong></h3>
				</div>
				<form method="post" action="cos-client.php?action=trimitere">
					<div class="form-group">
						<label for="judet">Județ</label>
						<input type="text" class="form-control form-control-sm" name="judet" id="judet" required>
					</div>
					<div class="form-group">
						<label for="localitate">Localitate</label>
						<input type="text" class="form-control form-control-sm" name="localitate" id="localitate" required>
					</div>
					<div class="form-group">
						<label for="strada">Strada</label>
						<input type="text" class="form-control form-control-sm" name="strada" id="strada" required>
					</div>
					<div class="form-row">
						<div class="col-sm-4">
							<label for="numar">Număr</label>
							<input type="number" min="0" class="form-control form-control-sm" name="numar" id="numar" required>
						</div>
						<div class="col-sm-4">
							<label for="apartament">Apartament</label>
							<input type="number" min="0" class="form-control form-control-sm" name="apartament" id="apartament" >
						</div>
						<div class="col-sm-4">
							<label for="inputZip">Cod poștal</label>
							<input type="text" class="form-control form-control-sm" name="codzip" maxlength="6" id="inputZip" >
						</div>
					</div>
			</div>
		</div>
			<input type="number" name="suma_totala" value="<?php echo $item_total; ?>" style="display:none;">
			<input type="button" value="Înapoi la magain" onclick="location.href='magazin_index.php'" class="buton-back">
			<input type="submit" value="Finalizare comanda" class="buton"/>
		</form>
  	</div>

	<?php } 
	elseif(isset($_GET['action']) && $_GET['action']=='trimitere') 
	{
	?>
	 <div class="container">
		<div class="empty-cart">
			<img src="../layout/logo.png">
			<h2>COȘ DE CUMPĂRĂTURI</h2>	
			<h4>Comandă înregistrată.</h4><br>
			<div class="buttons">
				<button type="button" class="buton" onclick="location.href='../utilizator/comenzi-produse.php'">Comenzile mele</button>
				<button type="button" class="buton" onclick="location.href='../magazin/magazin-index.php'"> Magazin</button> 
			<div>
		</div>
	</div>
	<?php } else { ?>
		<div class="container">
        	<div class="empty-cart">
				<img src="../layout/logo.png">
				<h2>COȘ DE CUMPĂRĂTURI</h2>	
				<h4>Momentan coșul dumneavoastră este gol.</h4><br>
				<div class="buttons">
					<button type="button" class="buton" onclick="location.href='../utilizator/comenzi-produse.php'">Comenzile mele</button>
					<button type="button" class="buton" onclick="location.href='../magazin/magazin_index.php'"> Magazin</button> 
				<div>
			</div>
		</div>
	<?php } ?>
</body>
<?=template_footer()?>
</html>