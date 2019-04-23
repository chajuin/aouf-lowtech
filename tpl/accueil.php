<?php
require_once 'head.php';
require_once 'header.php';
?>
        <?php
        if ($_SESSION['user_category']=='admin') {
            ?>
            <div class="container bg-saumon full-size">

            <h2>Admin</h2>
            <section class="tableau-de-bord flex center wrap">
                <a class="flex center" href='/admin/register'><div>Créer un accès</div></a>
                <a class="flex center" href='/admin/moderation'><div>Modération accès Délogé</div></a>
            </section>
            
            <?php
        }
        
        if (($_SESSION['user_category']=='admin')||($_SESSION['user_category']=='deloge')) {
            ?>
            <div class="container bg-saumon full-size">
            
            <h2 class="blanc">Consulter les offres</h2>
            <section class="tableau-de-bord flex center wrap">
                <a class="flex center column" href='/offer/list/restauration'>
                    <img class="icone" src="./images/restauration.png" alt="">
                </a>
                <a class="flex center" href='/offer/list/blanchisserie'>
                    <img class="icone" src="./images/blanchisserie.png" alt="">
                </a>
                <a class="flex center" href='/offer/list/mobilite'>
                    <img class="icone" src="./images/mobilite.png" alt="">
                </a>
                <a class="flex center" href='/offer/list/loisir'>
                    <img class="icone" src="./images/loisir.png" alt="">
                </a>
                <a class="flex center" href='/offer/list/don'>
                    <img class="icone" src="./images/dons.png" alt="">
                </a>
                <a class="flex center" href='/offer/list/autre'>
                    <img class="icone" src="./images/autre.png" alt="">
                </a>
            </section>
            
            <?php
        }
        
        if (($_SESSION['user_category']=='admin')||($_SESSION['user_category']=='benevole')) {
            ?>
            <div class="container bg-vert full-size">

            <h2 class="blanc">Déposer une offre</h2>
            <section class="tableau-de-bord flex center wrap">
                <a class="flex center" href='/offer/new/restauration'>
                    <img class="icone" src="./images/restauration.png" alt="">
                </a>
                <a class="flex center" href='/offer/new/blanchisserie'>
                    <img class="icone" src="./images/blanchisserie.png" alt="">
                </a>
                <a class="flex center" href='/offer/new/mobilite'>
                    <img class="icone" src="./images/mobilite.png" alt="">
                </a>
                <a class="flex center" href='/offer/new/loisir'>
                    <img class="icone" src="./images/loisir.png" alt="">
                </a>
                <a class="flex center" href='/offer/new/don'>
                    <img class="icone" src="./images/dons.png" alt="">
                </a>
                <a class="flex center" href='/offer/new/autre'>
                    <img class="icone" src="./images/autre.png" alt="">
                </a>
            </section>
            
            <br>
        <?php } ?>
</div>
<?php require_once 'footer.php'; ?>
