<?php 
require_once "../db/DBController.php";

class Layout extends DBController 
{
    /* denumirea subcategoriilor de albume */
    function getMenuSubcategories()
    {
		$query = "SELECT DISTINCT tip_album FROM prod_albume";
		
		$meniuSubcateg=$this->getDBResult($query);
		return $meniuSubcateg;
    }

}

/* relatii cu alte fisiere */
function head_rel($title){
    echo <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>$title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  

    <link rel="shortcut icon" href="../layout/logo.png"/>

    
    <!-- FONT-URI -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- JAVASCRIPT PERSONAL -->
    <script type="text/javascript" src="../layout/javascript.js"></script>

    <!-- ALTE SURSE JAVASCRIPT/JQUERY -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- CSS PERSONAL -->
    <link rel="stylesheet" href="../css_personal/layout.css">       
    <link rel="stylesheet" href="../css_personal/navigation.css">
    <link rel="stylesheet" href="../css_personal/logo_icons.css">
EOT;
}

/* bara orizontala de meniu + meniu vertical UTILIZATORI */
function template_meniuri(){
    echo <<<EOT
    <body>
    <header class="sticky-top">

        <!-- BUTON - MENIU VERTICAL-->
        <div class="meniu-icon" onclick="openNav()">
            <svg width="35px" height="35px" viewBox="0 0 16 16" class="bi bi-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
        </div>

        <!-- CONTENT MENIU VERTICAL -->
        <div id="meniu-vert" class="meniu-vertical">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">
              <svg width="40px" height="40px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
              </svg>
            </a>
            <div class="meniu-content">
                <h4>CATEGORII</h4>
                <div class="separator-meniu-first">
                    <a href="">Arhivă BTS</a>
                    <div class="meniu-inner">
                        <ul>
                            <a href="../prezentare/biografie.php"><li>Biografie</li></a>
                            <a href="../prezentare/discografie.php"><li>Discografie</li></a>
                            <a href="../prezentare/videoclipuri.php"><li>Videoclipuri</li></a>   
                        </ul>
                    </div>
                 </div>

                <div class="separator-meniu">
                    <a href="../concerte/lista-concerte.php">Concerte</a>
                </div>

                <div class="separator-meniu">
                    <a href="../magazin/magazin_index.php">Magazin</a>
                    <div class="meniu-inner">
                        <ul>
                            <a href="../magazin/magazin_albume.php"><li>Albume</li></a>
                            <a href="../magazin/magazin_produse.php?categ=DVD.php"><li>DVD</li></a>
                            <a href="../magazin/magazin_produse.php?categ=merchandise.php"><li>Merchandise</li></a>
                            <a href="../magazin/magazin_produse.php?categ=BT21.php"><li>BT21</li></a>
                            <a href="../magazin/magazin_produse.php?categ=carti.php"><li>Cărți</li></a>
                        </ul>
                    </div>
                </div>
          </div>
        </div>

        <!-- LOGO -->
        <div class="logo-navbar" href="">
            <a href="../index.html"><img src="../layout/logo.png">Mikrokosmos</a>
        </div>

        <!-- LISTA CATEGORII -->
        <div class="nav-links">
            <nav>
                <ul>
                    <li><a href="../prezentare/biografie.php">BTS</a></li>
                    <li><a href="../prezentare/discografie.php">DISCOGRAFIE</a></li>
                    <li><a href="../prezentare/videoclipuri.php">VIDEOCLIPURI</a></li>
                    <li><a href="../concerte/lista-concerte.php">CONCERTE</a></li>
                    <li><a href="../magazin/magazin_index.php">MAGAZIN</a></li>
                </ul>
            </nav>
        </div>


        <!-- PROFIL SI COS DE CUMPARATURI -->
        <div class="profile_cart">
            <div class="dropdown show">
                <a href="" role="button" id="meniuProfil" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="meniuProfil">
EOT;                
                if (!isset($_SESSION['loggedin']))
                { echo '<a class="dropdown-item" href="../utilizator/autentificare.php">Autentificare</a>'; }
                else
                { echo '
                    <a class="dropdown-item" href="../utilizator/index-utilizator.php">Profil</a>
                    <a class="dropdown-item" href="../utilizator/logout.php">Deconectare</a>';
                }
    echo <<<EOT
                </div>
            </div>
            
            <div>
                <a href="../magazin/cos-client.php">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </div>

            <div>
                <a href="../concerte/cos-bilete.php">
                    <i class="fa fa-ticket" aria-hidden="true"></i>
                </a>
            </div>
        </div>
	</header>
EOT;
}

/* MENIURI ADMINISTRATORI */
function template_meniuriADMIN(){
    echo <<<EOT
    <head>
        <link rel="shortcut icon" href="../layout/logo-admin.png"/>
    </head>
    <body>
    <header class="sticky-top">
        <!-- LOGO -->
        <div class="logo-navbar" href="">
            <a href="../admin/index-admin.php"><img src="../layout/logo-admin.png">ADMINISTRARE</a>
        </div>

        <!-- LISTA CATEGORII -->
        <div class="nav-links">
            <nav>
                <ul>
                    <li><a href="../admin-gestionare/biografieadmin.php">BTS</a></li>
                    <li><a href="../admin-gestionare/discografieadmin-index.php">ALBUME</a></li>
                    <li><a href="../admin-gestionare/videoclipuriadmin.php">VIDEOCLIPURI</a></li>
                    <li><a href="../admin-gestionare/concerte-index.php">CONCERTE/STADIOANE</a></li>
                    <li><a href="../admin-gestionare/magazinadmin-index.php">PRODUSE/COMENZI</a></li>
                </ul>
            </nav>
        </div>


        <!-- PROFIL ADMIN -->
        <div class="profile_cart">
            <div class="dropdown show">
                <a href="" role="button" id="meniuProfil" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-cog"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="meniuProfil">
EOT;                
                if (!isset($_SESSION['adminlogged']))
                { echo '<a class="dropdown-item" href="../admin/autentificare-admin.php">Autentificare</a>'; }
                else
                { echo '
                    <a class="dropdown-item" href="../admin/index-admin.php">Acasă</a>
                    <a class="dropdown-item" href="../admin/logout.php">Deconectare</a>';
                }
    echo <<<EOT
                </div>
            </div>
        </div>
	</header>
EOT;
}

function template_footer(){
    $an_curent = date("Y");
    echo <<<EOT
    <footer class="page-footer font-small text-center">
        <div class="text-center p-3">
          © $an_curent Bodiș Bianca-Ana-Maria, <i>Mikrokosmos</i> - magazin online și website de prezentare al formației BTS
        </div>
    </footer>
EOT;
}