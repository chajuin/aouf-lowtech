<?php
require_once 'head.php';
require_once 'header.php';

if (($_SESSION['user_category']!='admin')&&($_SESSION['user_category']!='benevole')) {
    die("permission denied");
}

$user_id = $_SESSION['user_id'];

?>
<div class="container bg-blanc noir full-size">
    <h2>Liste de mes offres</h2>
    <?php
        $pdo = new PDO('mysql:host='.SERVEUR.';dbname='.BASE,NOM,PASSE);
        $req = "SELECT * FROM offers WHERE user_id = $user_id";
        $statement = $pdo->query($req);

        while ($data = $statement->fetch()) {

            $offer_id = $data['id'];
            $titre = $data['title'];
            $description = $data['description'];
            $arrondissement = $data['arrondissement'];
            $status = $data['status'];
            $status_text = "";
            if ($status == 'disabled') $status_text = "(désactivée)";
            
            echo "Offre $offer_id $status_text : $titre - desc: $description - arr: $arrondissement : <a href='/offer/edit/$offer_id'>Éditer cette offre</a><br>";

        }


    ?>
</div>
<?php
require_once 'footer.php';
