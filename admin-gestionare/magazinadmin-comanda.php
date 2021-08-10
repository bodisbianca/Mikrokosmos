<?php
require_once "../magazin/Comanda.php";
require_once "../layout/Layout.php";
require_once "MagazinAdmin.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}

$comenzi = new Comanda();
$actiuniAdmin = new MagazinAdmin();

$comanda_detalii = NULL;
$comanda_adresa = NULL; 
$stari_comanda = array('Înregistrată', 'Expediată', 'Finalizată', 'Anulată');


if (! empty($_GET["id"])) 
{
	$id_comanda = $_GET['id'];
	$comanda_detalii = $comenzi->getUserOrderDetails($id_comanda);
	$comanda_adresa = $comenzi->getUserOrdersAddress($id_comanda);
	$comanda_user = $comenzi->getOrderUser($id_comanda);
}

if(!empty($_GET['action']))
{
	if($_GET['action']=='stare')
	{
		$actiuniAdmin->updateOrder($id_comanda, $_POST['stare']);
		header("Location: magazinadmin-comanda.php?update=succes&id=".$id_comanda);
	}
	if($_GET['action']=='eliminare-prod')
	{
		$id_prod = $_GET['id_prod'];
		$pret_cantitate_vechi = $actiuniAdmin->getOrderProductPriceQuantity($id_comanda, $id_prod); //pretul si cantitatea produsului de sters
		$item_total = $comanda_user['suma_plata'] - $pret_cantitate_vechi['cantitate']*$pret_cantitate_vechi['pret']; //pret total nou al comenzii
		
		$actiuniAdmin->deleteOrderProduct($id_comanda, $id_prod);
		$actiuniAdmin->updateOrderValue($id_comanda, $item_total);
		header("Location: magazinadmin-comanda.php?update=succes&id=".$id_comanda);
	}
}
?>

<?=head_rel('Comenzi - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
	<link rel="stylesheet" href="../css_personal/profil.css">
    
	<link rel="stylesheet" href="../css_personal/formular_admin.css">
	<link rel="stylesheet" href="../css_personal/magazin_admin.css">
<?=template_meniuriADMIN()?>


	<body>
		<br>
		<div class="container">
			<div class="header-profil header-update">
				<img src="../layout/logo-admin.png"> 
				<h2> COMANDA #<?php echo	$_GET['id'] ; ?> </h2>
			</div>
			<?php 
                    if(isset($_GET["update"]))
                    {  
                        if($_GET["update"]=="succes")
                            {echo "<div class='alert alert-success' role='alert'>Actualizare efectuată cu succes.</div>";} 
                    }
                ?>
			<input type="button" value="Înapoi la comenzi" onclick="location.href='magazinadmin-comenzi.php'" class="buton-back">
			
			<?php 
				if(!empty($comanda_detalii))
				{
			?>
			<div class="comanda-detalii">
				<div class="row">
					<div class="col-lg-8 detalii-produse">
						<div class="produs-nou stare-comanda">
							<form action="magazinadmin-comanda.php?action=stare&id=<?=$id_comanda?>" method="post">
								<div class="form-group">
									<label class="control-label col-md-6 form-icons" for="stare">Stare comandă</label>
									<span class="col-md-6">
										<select class="form-control" id="stare" name="stare">
											<?php foreach($stari_comanda AS $stare)
											{
												if($comanda_user['stare'] == $stare)
													echo "<option value='" .$stare."' selected='selected'>". $stare . "</option>";
												else
													echo "<option value='" .$stare."'>". $stare . "</option>";
											} ?>
										</select>
									</span>
									<input type="submit" value="Actualizare" class="buton buton-update">
								</div>
							</form>	
                        </div>		
									
						 
						<table class="table"> <!-- LISTA PRODUSE -->
							<thead class="thead-dark">
							<tr>
								<th colspan="2">Produs</th>
								<th>Cantitate</th>
								<th>Preț</th>
								<th></th>						
							</tr>
							</thead>
							<tbody>
								<?php 
								$item_total=0;
								foreach ($comanda_detalii as $produs) 
								{ 
									$item_total += ($produs["pret"] * $produs["cantitate"]);
								?>
							
								<tr>
								<?php if($produs['categorie']=='albume'){ ?> <!-- PENTRU ALBUME -->
									<td class="img">
										<a href="../magazin/produs_album.php?id=<?=$produs['id_prod']?>">
											<img src="<?=$produs['poza']?>" width="50" height="50"alt="<?=$produs['denumire']?>">
										</a>
									</td>
									<td>
										<a href="../magazin/produs_album.php?id=<?=$produs['id_prod']?>">
											<strong><?php echo $produs["denumire"]; ?></strong>
										</a>
										<p> <?php echo $produs['versiune'];?> </p>
									</td>
									<?php } else { ?> <!-- PENTRU RESTUL PRODUSELOR -->
										<td class="img">
										<a href="../magazin/produs_detalii.php?id=<?=$produs['id_prod']?>">
											<img src="<?=$produs['poza']?>" width="50" height="50"alt="<?=$produs['denumire']?>">
										</a>
									</td>
									<td>
										<a href="../magazin/produs_detalii.php?id=<?=$produs['id_prod']?>">
											<strong><?php echo $produs["denumire"]; ?></strong>
										</a>
									</td>
									<?php } ?>									
									<td><?php echo $produs["cantitate"]; ?></td>
									<td><?php echo $produs["pret"]. " lei"; ?></td>
									<td><a href="magazinadmin-comanda.php?action=eliminare-prod&id_prod=<?=$produs['id_prod']?>&id=<?=$id_comanda?>"><i class="far fa-times-circle"></i></a></td>
								</tr>
								<?php }?>
								<tr>
									<td></td><td></td>
									<td><strong> TOTAL </strong></td>
									<td><?=$item_total?> lei</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-lg-4 adresa">										
						<h5><strong>DETALII LIVRARE</strong></h5> 
						<br>
						<table class="table">
							<tbody>
								<tr><td><strong><?php echo strtoupper($comanda_user['nume']) . " " . strtoupper($comanda_user['prenume']);?></strong></td></tr>
								<tr>
									<td><?php echo "jud. " . $comanda_adresa['judet'] . ", loc. ". $comanda_adresa['localitate']; ?></td>
								</tr>
								<tr>
									<td><?php echo  $comanda_adresa['strada'] ." nr ". $comanda_adresa['numar'];?>
									<?php
										if(!empty($comanda_adresa['apartament']))
											echo ", apt " .$comanda_adresa['apartament']; 
									?>
									</td>
								</tr>
								<tr>
									<td><?php echo $comanda_adresa['cod_postal']; ?></td>
								</tr>
							</tobdy>
						</table>	
					</div>
				</div>
			</div>
			<?php }?>	
		</div>
	</body>
	<?=template_footer()?>
</html>
