<?php
require_once "../concerte/Rezervare.php";

$id_user=$_GET['id'];
$id_rezervare=$_GET['rezervare'];

$rezervare = new Rezervare();
$detalii_rezervare = $rezervare->getBookedTicketPDF($id_rezervare);

?>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css_personal/bilet_pdf.css">
    
</head>

<body>

    <div id="shopping-cart" class="container">
 	<div class="row">
		<div class="col-lg-7 poster">
			<img src="<?php echo $detalii_rezervare['poster']; ?>">
		</div>

		<div class="col-lg-5 date">
            <br>
            <h4><strong>CONCERT <?php echo strtoupper($detalii_rezervare['nume_concert']); ?></strong></h4>
            <h5><?php echo $detalii_rezervare['stadion'] .", ". $detalii_rezervare['oras']; ?></h5>
            <p><?php echo date('d.m.Y', strtotime($detalii_rezervare['data'])) .", ora ". date('H:i', strtotime ($detalii_rezervare['ora'])); ?></p>

            <p id="date-pers">COD REZERVARE <?php echo "#". $id_rezervare;?></p>
            <ul>               
                <li><strong>
                <?php 
                if($detalii_rezervare['cod_num']>0)
                {
                    echo strtoupper($detalii_rezervare['zona'])." " . $detalii_rezervare['cod_num'] . ", SECȚIUNEA " . $detalii_rezervare['cod_num'].$detalii_rezervare['cod_alfa']; 
                }
                else
                {
                    echo strtoupper($detalii_rezervare['zona']) . ", ZONA " . $detalii_rezervare['orientare']; 
                }?>
                </strong></li>

                <li><strong>LOC <?php echo $detalii_rezervare['loc'];?></strong></li>
            </ul>
            <br>
            <p>PREȚ BILET <br> <strong><?php echo $detalii_rezervare['pret'];?> LEI</strong></p>
		</div>
    </div>

    <div class="logo-navbar" href="">
        <a href="#"><img src="../layout/logo.png">Mikrokosmos</a>
    </div>
</body>