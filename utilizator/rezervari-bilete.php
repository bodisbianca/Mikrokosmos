<?php
require_once "UserInfo.php";
require_once "../concerte/Rezervare.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['loggedin'])) 
{
	header('Location: autentificare.php');
	exit;
}


$id_user=$_SESSION['id'];
$rezervariUser = new Rezervare();
$detaliiUser = new UserInfo();

$bilete_rezervate = $rezervariUser->getBookedTickets($id_user);

if (! empty($_GET["action"])) 
{
	 switch ($_GET["action"]) 
	 {
		case "descarcare-pdf":
 
		break;
	 }
}
?>

<?=head_rel('Rezervările mele - Mikrokosmos')?>
	<link rel="stylesheet" href="../css_personal/login_register.css">
	<link rel="stylesheet" href="../css_personal/profil.css">
<?=template_meniuri()?>


	<body>
		<br>
		<div class="container rezervari">	
			<h2> REZERVĂRILE MELE</h2>	
			<div class="logo">
				<img src="../layout/logo.png"> 
			</div>
			<input type="button" value="Înapoi la meniul principal" onclick="location.href='index-utilizator.php'" class="buton-back">	 
			<div class="lista-rezervari">
				 <?php
					if(!empty($bilete_rezervate))
					{
				 ?>
				 <table class="table">
					<thead>
					  <tr>
						<th colspan="2">Concert</th>
						<th>Data rezervarii</th>
						<th>Zona</th>						
						<th>Loc</th>
						<th>Preț</th>
						<th></th>
					  </tr>
					</thead>
					<tbody>
						<?php
						foreach($bilete_rezervate as $bilet)
							{
						?>
						<tr>
							<td>
								<a href="../concerte/bilete-concert.php?id=<?=$bilet['id_concert']?>">
									<img src="../concerte/<?=$bilet['poster']?>" width="70" height="50"alt="<?=$bilet['nume_concert']?>">
								</a>
							</td>
							<td>
								<a href="../concerte/bilete-concert.php?id=<?=$bilet['id_concert']?>" id="denumire-concert"><strong><?php echo "Concert " . $bilet["nume_concert"]; ?></strong></a>
								<p>
									<i class="fas fa-map-marker-alt"></i> <?php echo $bilet['stadion'] . " - " . $bilet['oras'];?> <br>
									<i class="fas fa-calendar-alt"></i> <?php echo date('d.m.Y', strtotime ($bilet["data"]));?>
								</p>
							</td>
							<td><?php echo	date('d.m.Y H:i', strtotime ($bilet["data_rezervare"]));?></td>
							<td><?php 
								if($bilet['cod_num']>0)
									{echo $bilet["zona"] . " " .$bilet['cod_num'] . "</br> sectiunea " . $bilet['cod_num'].$bilet['cod_alfa'];}
								else
									{echo $bilet["zona"]. "</br> zona " . $bilet['orientare'];}
								 
								 ?>
							</td>
							<td><?php echo	$bilet["loc"]; ?></td>
							<td><?php echo	$bilet["pret"]." lei"; ?></td>
							<td><a href="../concerte/bilet.php?id=<?=$id_user;?>&rezervare=<?=$bilet['id_rezervare']?>"><i class='fa fa-ticket' aria-hidden='true'></i> Vizualizare</a></td>
						</tr>
						<?php }?>
					</tbody>							
				 </table>
				 <?php } 
				 else {
						echo "<div class='no-tickets'><h2>Momentan nu aveți bilete de concert rezervate.</h2>
							<a href='../concerte/lista-concerte.php'><i class='fa fa-ticket' aria-hidden='true'></i> Vizualizează concertele disponibile</a><br>
							</div>";
				 }?>
			</div>
			
		</div>
	</body>
	<?=template_footer()?>
</html>
