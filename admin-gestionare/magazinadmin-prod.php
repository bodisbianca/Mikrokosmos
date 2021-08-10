<?php
require_once "MagazinAdmin.php";
require_once "../magazin/Magazin.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}

$produs = new Magazin();


$adminProduse = new MagazinAdmin();
$category_array = $adminProduse->getProductCategories();

if(isset($_GET['id']))
{
    $id_produs = $_GET['id'];
    $product_details = $produs->getProductById($id_produs);
    $product_images = $produs->getProductPhotos($id_produs);
    $admin_images = $adminProduse->getProductPhotos($id_produs);
}


if(!empty($_GET['action']))
{
    switch($_GET['action'])
    {
        case "produs_nou":
            $prod_precedent = $adminProduse->getLastInsertedProductId();
            $denumire = $_POST['denumire'];
            $poza = $_POST['poza'];
            $categorie_prod = $_POST['categorie'];
            $pret = $_POST['pret'];
            $cantitate = $_POST['cantitate'];
            $descriere = $_POST['descriere'];
            $adminProduse->addNewProduct($denumire, $poza, $categorie_prod, $pret, $cantitate, $descriere);

            $id_produs = $adminProduse->getLastInsertedProductId();
            if($prod_precedent != $id_produs)
                {header('Location: magazinadmin-prod.php?action=adaugare-succes&id='.$id_produs);}
            else
                {header('Location: magazinadmin-prod.php?action=adaugare-err');}
        break;

        case "actualizare":
            $denumire = $_POST['denumire'];
            $poza = $_POST['poza'];
            $categorie_prod = $_POST['categorie'];
            $pret = $_POST['pret'];
            $cantitate = $_POST['cantitate'];
            $descriere = $_POST['descriere'];
            
            $adminProduse->updateProdus($id_produs, $denumire, $poza, $categorie_prod, $pret, $cantitate, $descriere);

            header('Location: magazinadmin-prod.php?action=actualizare-succes&id='.$id_produs);
        break;

        case "introducere-img":
            if(!empty($_POST['poza1']) && $_POST['poza1'] != '../media/')
                $adminProduse->insertNewPhoto($id_produs, $_POST['poza1']);
            if(!empty($_POST['poza2']) && $_POST['poza2'] != '../media/')
                $adminProduse->insertNewPhoto($id_produs, $_POST['poza2']);
            if(!empty($_POST['poza3']) && $_POST['poza3'] != '../media/')
                $adminProduse->insertNewPhoto($id_produs, $_POST['poza3']);

            header('Location: magazinadmin-prod.php?action=extra-img&id='.$id_produs);
        break;

        case "actualizare-img":
            foreach($admin_images AS $img_initiala)
            {
                $id_img_initiala = $img_initiala['id'];
                $img_noua = $_POST[$id_img_initiala];

                if($img_noua != $img_initiala['poza'])
                    $adminProduse->updatePhoto($id_img_initiala, $id_produs, $img_noua);
            }
            header('Location: magazinadmin-prod.php?action=extra-img&id='.$id_produs);
        break;
    }
}
?>

<?=head_rel('Actualizare produs - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/produs.css">
    <link rel="stylesheet" href="../css_personal/magazin.css">
    <link rel="stylesheet" href="../css_personal/profil.css"> 
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
    <link rel="stylesheet" href="../css_personal/magazin_admin.css">
   
<?=template_meniuriADMIN()?>


<br>
	<body>    
    <!-- ACTUALIZARE PRODUS -->
    <?php if(isset($_GET['id'])) { ?>
    <div class="header-sectiune header-update">
        <img src="../layout/logo-admin.png"> 
        <h2><strong> ACTUALIZARE PRODUS </strong></h2>
    </div>
    <?php 
        if(isset($_GET["action"]))
        {  
            if($_GET["action"]=="actualizare-succes")
                {echo "<div class='alert alert-success' role='alert'>Actualizare efectuată cu succes.</div>";} 
            if($_GET["action"]=="adaugare-succes")
                {echo "<div class='alert alert-success' role='alert'>Produsul a fost adăugat cu succes.</div>";}
            if($_GET["action"]=="adaugare-err")
                {echo "<div class='alert alert-danger' role='alert'>Produsul nu a putut fi inserat.</div>";} 
        }
    ?>
    <button type="button" class="buton buton-back" onclick="location.href='magazinadmin-produse.php'">Înapoi la catalog</button>
    <div class="detalii">
        <div class="container">
            <div class="row">
				<div class="col-lg-6 imagini">
                    <h4><strong><?=$product_details['denumire']?></strong></h4>
					<!-- IMAGINI MICI DE PE MARGINE -->
					<div class="col-3 flex-column imagine-secundara">
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
                
                <?php if(isset($_GET['action'])==1 && $_GET['action']=='extra-img') { ?>

                <div class="col-lg-6 detalii-form produs-nou"> <!-- IMAGINI SUPLIMENTARE -->                						
                    <div class="form-row">
                        <div class="col-lg-6 imagini-noi"> <!-- IMAGINI NOI -->
                            <form method="post" action="magazinadmin-prod.php?action=introducere-img&id=<?=$id_produs?>">
                                <div>
                                    <h4><strong> Imagini noi </strong></h4>
                                    <input type="submit" class="buton buton-new" value="Adăugare">
                                </div><br>
                                <div class="form-group">
                                    <span class="col-sm-6"><input type="text" name="poza1" value="../media/" required></span>
                                </div>
                                <div class="form-group">
                                    <span class="col-sm-6"><input type="text" name="poza2" value="../media/"></span>
                                </div>
                                <div class="form-group">
                                    <span class="col-sm-6"><input type="text" name="poza3" value="../media/"></span>
                                </div>
                            </form>
                        </div>
                        <?php if(!empty($admin_images)) { ?>
                        <div class="col-lg-6 imagini-noi"> <!-- IMAGINI EXISTENTE -->
                            <form method="post" action="magazinadmin-prod.php?action=actualizare-img&id=<?=$id_produs?>">
                                <div>
                                    <h4><strong> Imagini existente </strong></h4>
                                    <input type="submit" class="buton buton-update" value="Actualizare">
                                </div><br>
                                <?php foreach($admin_images as $imagine) { ?>
                                <div class="form-group">
                                    <span class="col-sm-6">
                                        <input type="text" name="<?=$imagine['id']?>" value="<?=$imagine['poza']?>" required>
                                    </span>
                                </div>
                                <?php } ?>
                            </form>
                        </div>
                        <?php } ?>
                    </div>
                    <br>
                    <div class="butoane-modif">
                        <button type="button" class="buton buton-delete" onclick="location.href='magazinadmin-prod.php?id=<?=$id_produs?>'">Înapoi la detalii</button>
                    </div>
                </div>
                
                <?php } else { ?>

                <div class="col-lg-6 detalii-form produs-nou"> <!-- ACTUALIZARE DETALII PRODUS -->                   					
					<form method="post" action="magazinadmin-prod.php?action=actualizare&id=<?=$id_produs?>">	
                        <div class="form-row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-4 form-icons" for="denumire">Denumire</label>
                                    <span class="col-sm-6"><input type="text" name="denumire" id="denumire" value="<?=$product_details['denumire']?>" required></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col form-icons" for="poza">Imagine principală</label>
                                    <span class="col-sm-6"><input type="text" name="poza" id="poza" value="<?=$product_details['poza']?>" required></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4 form-icons" for="categorie">Categorie</label>
                                    <span class="col-sm-6">
                                        <select class="form-control select" id="categorie" name="categorie">
                                        <?php
                                            foreach($category_array AS $categorie)
                                            {
                                                if($product_details['categorie']==$categorie['categorie'])
                                                    echo "<option selected='selected' value=".$categorie ['categorie'].">".$categorie ['categorie']. "</option>";
                                                else
                                                    echo "<option value=".$categorie ['categorie'].">".$categorie ['categorie']. "</option>";
                                            }
                                        ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-4 form-icons" for="pret">Preț</label>
                                    <span class="col-sm-6"><input type="number" step=".01" name="pret" id="pret" value="<?=$product_details['pret']?>" required></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4 form-icons" for="cantitate">Cantitate</label>
                                    <span class="col-sm-6"><input type="number" name="cantitate" id="cantitate" value="<?=$product_details['cantitate']?>"></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4 form-icons" for="descriere">Descriere</label>
                                    <textarea class="col-sm-6form-control" name="descriere" id="descriere" rows="2"><?=$product_details['descriere']?></textarea>
                                </div>
                            </div>
                        </div>
					
                        <div class="butoane-modif">
                            <input type="submit" class="buton buton-update" value="Actualizare">
                            <button type="button" class="buton buton-new" onclick="location.href='magazinadmin-prod.php?action=extra-img&id=<?=$id_produs?>'">Adăugare imagini</button>
                        </div>
                    </form>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php }?>                

    <!-- PRODUS NOU -->
    <?php if(!isset($_GET['id'])) { ?>
    <div class="container">
        <div class="new">
            <div class="header-profil header-update">
                <img src="../layout/logo-admin.png"> 
                <h4><strong> PRODUS NOU </strong></h4>       
            </div>
            <div class="formular-concert produs-nou">
                <form action="magazinadmin-prod.php?action=produs_nou" method="post" class="form-horizontal">
                    <div class="form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-5 form-icons" for="denumire">Denumire produs</label>
                                <span class="col-sm-6"><input type="text" name="denumire" id="denumire" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5 form-icons" for="poza">Imagine</label>
                                <span class="col-sm-6"><input type="text" name="poza" id="poza" value="../media/" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5 form-icons" for="categorie">Categorie</label>
                                <span class="col-sm-6">
                                    <select class="form-control" id="categorie" name="categorie">
                                    <?php
                                        foreach($category_array AS $categorie)
                                        {
                                            echo "<option value=".$categorie ['categorie'].">".$categorie ['categorie']. "</option>";
                                        }
                                    ?>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="pret">Preț</label>
                                <span class="col-sm-6"><input type="number" step=".01" name="pret" id="pret" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="cantitate">Cantitate</label>
                                <span class="col-sm-6"><input type="number" name="cantitate" id="cantitate" required></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 form-icons" for="descriere">Descriere</label>
                                <textarea class="col-sm-6form-control" name="descriere" id="descriere" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="buton-update">
                        <input class="buton" type="submit" value="Finalizare">
                    </div> 
                </form>
            </div>
        </div>
    </div>
    <?php } ?>
	</body>
    <?=template_footer()?>
</html>
