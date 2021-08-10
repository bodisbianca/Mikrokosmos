<?php
require_once "../layout/Layout.php";
require_once "Rezervare.php";
require_once "../magazin/Comanda.php";
session_start();

if (!isset($_SESSION['loggedin'])) 
{
	header('Location: ../utilizator/autentificare.php');
	exit;
}


$id_user=$_SESSION['id'];
$ticketCart = new Rezervare();
if (! empty($_GET["action"])) 
{
	 switch ($_GET["action"]) 
	 {
		 case "add":
			 if (! empty($_POST["seat"])) 
			 {
				$ticket_array = $_POST["seat"];
				foreach ($ticket_array as $seat)
				{
					$ticketCart->addTicketToCart($_GET['concert'], $_GET['sectiune'], $seat, $id_user);
				}		
			}
		break;
		
		case "remove":
			$ticketCart->deleteCartTicket($_GET["id"]);
		break;
		
		case "empty":
			$ticketCart->emptyCart($id_user);
		break;
		
		case "trimitere":
		{
			$ticketRezervare = $ticketCart->getTicketOrder($id_user);
			if (! empty($ticketRezervare)) 
			{
				foreach ($ticketRezervare as $tkt)
				{
					$ticketCart->bookTickets($id_user, $tkt['id_concert'], $tkt['id_sectiune'], $tkt['loc']);
				}
			}
		}
		break;
		
	}
}
?>

<?=head_rel('Cos bilete - Mikrokosmos')?>
<link rel="stylesheet" href="../css_personal/cos.css">
<?=template_meniuri()?>


<body>
<br>
	<?php
		$selectedTickets = $ticketCart->getUserCartTicket($id_user);
		if (! empty($selectedTickets)) 
		{
			$item_total = 0;
	?>
 	<div class="container">
		<div class="bilete">
			<div class="titlu-cos">
				<h3><strong><i class="fas fa-ticket-alt"></i> BILETE SELECTATE </strong></h3>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th colspan="2">Concert</th>
						<th>Zona</th>
						<th>Loc</th>
						<th>Preț</th>				
						<th colspan="2">Modificare</th>		
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($selectedTickets as $ticket)
						{
							$item_total += $ticket["pret"];
					?>
					<tr>
						<td class="img">
							<a href="bilete-concert.php?id=<?=$ticket['id_concert']?>">
								<img src="<?=$ticket['poster']?>" width="70" height="50"alt="<?=$ticket['nume_concert']?>">
							</a>
						</td>
						<td>
							<a href="bilete-concert.php?id=<?=$ticket['id_concert']?>" id="denumire-concert">
								<?php echo $ticket["nume_concert"]; ?>
							</a>
							<p> <?php echo $ticket['stadion'] . " - " . $ticket['oras'];?> </p>
						</td>
						<td>
							<?php 
							if($ticket['cod_num']>0)
							{
								echo $ticket["zona"] . " " .$ticket['cod_num'] . "</br> sectiunea " . $ticket['cod_num'].$ticket['cod_alfa']; 
							}
							else 
							{
								echo $ticket["zona"]. "</br> zona " . $ticket['orientare'];
							}
							?>
						</td>
						<td><?php echo $ticket["loc"]; ?></td>
						<td><?php echo $ticket["pret"]; ?></td>
						<td>
							<a href="cos-bilete.php?action=remove&id=<?php echo $ticket["id_cos"]; ?>">
								<i class="far fa-times-circle"></i> Elimina
							</a>
						</td>
					</tr>
					<?php } ?>
					<tr id="bilete-sumar">
						<td colspan="2"><strong> PLATA LA CASERIA STADIONULUI </strong> </td>
						<td></td>
						<td><strong>TOTAL</strong></td>
						<td><strong><?=$item_total?> lei</strong></td>
						<td><a id="btnEmpty" href="cos-bilete.php?action=empty">Golire cos </a></td>
					</tr>
			</tbody>
			</table>
		</div>
		<input type="button" value="Înapoi la concerte" onclick="location.href='lista-concerte.php'" class="buton-back">
		<input type="button" value="Finalizare comanda" onclick="location.href='cos-bilete.php?action=trimitere'" class="buton"/>
	</div>
	
	
	<?php } 
	elseif(isset($_GET['action']) && $_GET['action']=='trimitere') 
	{
	?>
	 <div class="container">
		<div class="empty-cart ticket-cart">
			<img src="../layout/logo.png">
			<h2>COȘ DE BILETE</h2>	
			<h4>Rezervare înregistrată.</h4><br>
			<div class="buttons">
				<button type="button" class="buton" onclick="location.href='../utilizator/rezervari-bilete.php'">Biletele mele</button>
				<button type="button" class="buton" onclick="location.href='../concerte/lista-concerte.php'"> Concerte</button> 
			<div>
		</div>
	</div>
	<?php } else { ?>
		<div class="container">
        	<div class="empty-cart ticket-cart">
				<img src="../layout/logo.png">
				<h2>COȘ DE BILETE</h2>	
				<h4>Momentan nu ați selectat nici un bilet de concert.</h4><br>
				<div class="buttons">
					<button type="button" class="buton" onclick="location.href='../utilizator/rezervari-bilete.php'">Biletele mele</button>
					<button type="button" class="buton" onclick="location.href='../concerte/lista-concerte.php'"> Concerte</button> 
				<div>
			</div>
		</div>
	<?php } ?>
	
</body>
<?=template_footer()?>
</html>