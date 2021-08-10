<?php
require_once "MagazinAdmin.php";
require_once "../layout/Layout.php";
session_start();

if (!isset($_SESSION['adminlogged'])) 
{
	header('Location: ../admin/autentificare-admin.php');
	exit;
}

$produse = new MagazinAdmin();
$lista_produse = $produse->getAllProducts();
$category_array = $produse->getProductCategories();

if(!empty($_GET['categ']))
{
    $lista_produse = $produse->getProductsByCategory($_GET['categ']);
    $categorie = ucfirst($_GET['categ']);
}

if(isset($_GET['action']))
{
    switch($_GET['action'])
    {
        case "eliminare":
            $produse->deleteProduct($_GET['id']);
            header('Location: magazinadmin-produse.php');
        break;
    }
}
?>

<?=head_rel('Catalog produse - Mikrokosmos')?>
    <link rel="stylesheet" href="../css_personal/profil.css">
    <link rel="stylesheet" href="../css_personal/magazin.css">
    <link rel="stylesheet" href="../css_personal/formular_admin.css">
    <link rel="stylesheet" href="../css_personal/magazin_admin.css">
<?=template_meniuriADMIN()?>


<br>
	<body>
    <div class="header-profil header-update">
        <img src="../layout/logo-admin.png"> 
        <h2> CATALOG PRODUSE </h2>
    </div>
    <div id="container_categ_mag">
        <div class="categorii_magazin">
        <ul>
            <li><a href="magazin_produse.php">TOATE</a></li>
            <?php 
            if(!empty($category_array))
            {
                foreach($category_array AS $key => $categorie)
                {
            ?>
                <li id=""><a href="magazinadmin-produse.php?categ=<?php echo($categorie ['categorie']); ?>"><?php echo ($categorie ['categorie']); ?></a></li>
            <?php 
                }
            }
            ?>
          </ul>
        </div>
    </div>
        
    <button type="button" class="buton buton-new" onclick="location.href='magazinadmin-prod.php'">Produs nou</button>
    <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th colspan="2">PRODUS</th>
                    <th>CATEGORIE</th>
                    <th>DESCRIERE</th>
                    <th>PREȚ</th>
                    <th>ACTUALIZARE</th>
                    <th>ELIMINARE</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach($lista_produse AS $produs) 
                {
            ?>
                <tr>
                    <td class="img">
						<img src="<?=$produs['poza']?>" width="50" height="50"alt="<?=$produs['denumire']?>">
					</td>
                    <td><?=$produs['denumire']?></td>
                    <td><?=$produs['categorie']?></td>
                    <td><?=$produs['descriere']?></td>
                    <td><?=$produs['pret']?></td>
                    <td><a href="magazinadmin-prod.php?id=<?=$produs['id']?>">Actualizare</a></td>
                    <td><a href="magazinadmin-produse.php?id=<?=$produs['id']?>&action=eliminare">Eliminare</a></td>
                </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
	</body>
    <?=template_footer()?>
</html>
