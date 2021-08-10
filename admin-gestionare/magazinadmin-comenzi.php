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
$stari_array = $actiuniAdmin->getOrderStates();

if(!empty($_GET['categ']))
{
    $comenzi_general = $comenzi->getOrdersByState($_GET['categ']);
}
else 
{$comenzi_general = $comenzi->getAllOrders();}



if (! empty($_GET["action"])) 
{
	 switch ($_GET["action"]) 
	 {
		case "eliminare":
			$actiuniAdmin->deleteOrder($_GET['id']);
			header("Location: magazinadmin-comenzi.php");
		break;
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
		<div class="container comenzi">
			<div class="header-profil header-update">
				<img src="../layout/logo-admin.png"> 
				<h2> COMENZI CLIENȚI</h2>
			</div>
			<div id="container_categ_mag">
				<div class="categorii_magazin">
					<ul>
						<li><a href="magazinadmin-comenzi.php">TOATE</a></li>
						<?php 
						if(!empty($stari_array))
						{
							foreach($stari_array AS $key => $stare)
							{
						?>
							<li id=""><a href="magazinadmin-comenzi.php?categ=<?php echo($stare ['stare']); ?>"><?php echo strtoupper(str_replace("ă", "e", $stare['stare'])); ?></a></li>
						<?php 
							}
						}
						?>
					</ul>
				</div>
			</div>
			<input type="button" value="Înapoi la meniul principal" onclick="location.href='magazinadmin-index.php'" class="buton-back">
			<div class="listaadmin-comenzi">	 
				 <?php
					if(!empty($comenzi_general))
					{
				 ?>
				 <table class="table">
					<thead class="thead-dark">
					  <tr>
						<th>ID comandă</th>
						<th>Data plasării</th>
						<th>Număr produse</th>						
						<th>Preț total</th>
						<th>Stare comandă</th>
						<th></th>
						<th></th>
					  </tr>
					</thead>
					<tbody>
						<?php
						foreach($comenzi_general as $comanda)
							{
						?>
						<tr>
							<td><a href=magazinadmin-comanda.php?id=<?php echo $comanda['id_comanda']; ?>><?php echo	"#".$comanda["id_comanda"]; ?></a></td>	
							<td><?php echo	date('d.m.Y H:i', strtotime ($comanda["data_comanda"])); ?></td>
							<td><?php echo	$comanda["nr_produse"]; ?></td>
							<td><?php echo	$comanda["suma_plata"]; ?></td>
							<td><?php echo	$comanda["stare"]; ?></td>
							<td><a href=magazinadmin-comanda.php?id=<?php echo $comanda['id_comanda']; ?>>Detalii</a></td>
							<td><a href=magazinadmin-comenzi.php?action=eliminare&id=<?php echo $comanda['id_comanda']; ?>>Eliminare</a></td>
						</tr>
						<?php }?>
					</tbody>							
				 </table>
				 <?php } 
				 else {
					echo "<div class='no-orders'><h2>Momentan nu au fost înregistrate comenzi.</h2>
						</div>";
			 	}?>
			</div>
			
		</div>
	</body>
	<?=template_footer()?>
</html>
