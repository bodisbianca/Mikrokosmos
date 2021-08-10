<?php
require_once "UserInfo.php";
require_once "../magazin/Comanda.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['loggedin'])) 
{
	header('Location: autentificare.php');
	exit;
}


$id_user=$_SESSION['id'];
$comandaUser = new Comanda();
$detaliiUser = new UserInfo();

$comenzi_general = $comandaUser->getUserOrders($id_user);
$comanda_detalii = NULL;
$comanda_adresa = NULL; 

if (! empty($_GET["action"])) 
{
	 switch ($_GET["action"]) 
	 {
		case "detalii":
			$comanda_detalii = $comandaUser->getUserOrderDetails($_GET['id']);
			$comanda_adresa = $comandaUser->getUserOrdersAddress($_GET['id']);
		break;
	 }
}
?>

<?=head_rel('Comenzile mele - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
	<link rel="stylesheet" href="../css_personal/profil.css">
<?=template_meniuri()?>


	<body>
		<br>
		<div class="container comenzi">
			<h2> COMENZILE MELE </h2>
			<div class="logo">
				<img src="../layout/logo.png"> 
			</div>
			<input type="button" value="Înapoi la meniul principal" onclick="location.href='index-utilizator.php'" class="buton-back">
			<?php 
				if(!empty($comanda_detalii))
				{
			?>
			<div class="comanda-detalii">
				<div class="row">
					<div class="col-lg-8 detalii-produse">
						<h4> COMANDA #<?php echo	$_GET['id'] ; ?> </h4>
						<table class="table">
							<thead>
							<tr>
								<th colspan="2">Produs</th>
								<th>Cantitate</th>
								<th>Preț</th>						
							</tr>
							</thead>
							<tbody>
								<?php 
								foreach ($comanda_detalii as $produs) 
								{ ?>
							
								<tr>
								<?php if($produs['categorie']=='ALBUME'){ ?> <!-- PENTRU ALBUME -->
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
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>

					<div class="col-lg-4 adresa">
						<h4>ADRESĂ LIVRARE</h4> 
						<br>
						<table class="table">
							<tbody>
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
			 
			<div class="lista-comenzi">	 
				 <?php
					if(!empty($comenzi_general))
					{
				 ?>
				 <table class="table">
					<thead>
					  <tr>
						<th>ID comandă</th>
						<th>Data plasării</th>
						<th>Număr produse</th>						
						<th>Preț total</th>
						<th>Stare comandă</th>
						<th></th>
					  </tr>
					</thead>
					<tbody>
						<?php
						foreach($comenzi_general as $comanda)
							{
						?>
						<tr>
							<td><a href=comenzi-produse.php?action=detalii&id=<?php echo $comanda['id_comanda']; ?>><?php echo	"#".$comanda["id_comanda"]; ?></a></td>	
							<td><?php echo	date('d.m.Y H:i', strtotime ($comanda["data_comanda"])); ?></td>
							<td><?php echo	$comanda["nr_produse"]; ?></td>
							<td><?php echo	$comanda["suma_plata"]; ?></td>
							<td><?php echo	$comanda["stare"]; ?></td>
							<td><a href=comenzi-produse.php?action=detalii&id=<?php echo $comanda['id_comanda']; ?>>Detalii</a></td>
						</tr>
						<?php }?>
					</tbody>							
				 </table>
				 <?php } 
				 else {
					echo "<div class='no-tickets'><h2>Momentan nu aveți comenzi plasate.</h2>
						<a href='../magazin/magazin_index.php'><i class='fas fa-store'></i></i> Vizualizează produsele</a><br>
						</div>";
			 	}?>
			</div>
			
		</div>
	</body>
	<?=template_footer()?>
</html>
