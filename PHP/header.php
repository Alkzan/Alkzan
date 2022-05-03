<header>
        <?php if (isset($_SESSION["id"]) == false) : ?>

            <ul>
                <div class="logo">
                <li><a href='Index.php'>E-Commerce.</a></li>
                </div>
                <div class="bout">
                    <form method='post' action='boutique.php?search' target='iiframe'>
                        <li class="searchli"><input type='search' class='search' name='search' placeholder='Rechercher'><i name="search" class="fas fa-search"></i></li>
                    </form>
                </div>
                <div class="actions">
                    <li><a target='iiframe' href='panier.php'><i class="fas fa-shopping-cart"></i></a></li>
                    <li><a  href='#'><i class="fas fa-user"></i></a></li>
                    <div class="actions-submenu_connect">
                        <li><i class="fas fa-user"></i><a  href='connect.php'>Se connecter</a></li>
                        <li><i class="fas fa-user"></i><a  href='inscription.php'>S'inscrire</a></li>
                    </div>
                    <!-- <li><a href='inscription.php'><img src='../images/connexion.png' width='20' /></a></li> -->
                </div>
            </ul>

        <?php else : ?>

            <ul>
                <div class="logo">
                    <li><a href='Index.php'>E-Commerce.</a></li>
                </div>
                <div class="bout">
                    <form method='post' action='boutique.php?search' target='iiframe'>
                        <li class="searchli"><input type='search' class='search' name='search' placeholder='Rechercher'><i name="search" class="fas fa-search"></i></li>
                    </form>
                </div>
                <div class="actions">
                    <li><a target='iiframe' href='panier.php'><i class="fas fa-shopping-cart"></i></a></li>
                    <li><a  href='#'><i class="fas fa-user"></i></a></li>
                    <div class="actions-submenu_connect">
                        <li><i class="fas fa-user"></i><a  href='profil.php'>Mon Profil</a></li>
                        <li><i class="fas fa-user"></i><a  href='logout.php'>Se déconnecter</a></li>
                    </div>
                </div>
            </ul>
        
        <?php endif; ?>
    </header>