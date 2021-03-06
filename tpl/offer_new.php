<?php
require_once 'head.php';
require_once 'header.php';

if (($_SESSION['user_category']!='admin')&&($_SESSION['user_category']!='benevole')) {
    die("permission denied");
}

$pdo = new PDO('mysql:host='.SERVEUR.';dbname='.BASE,NOM,PASSE);

$user_id = $_SESSION['user_id'];

if (isset($_POST['title'])) {
    $category = $_POST['category'];
    $title = $_POST['title'];
    $arrondissement = $_POST['arrondissement'];
    $address = $_POST['address'];
    $date_start = $_POST['dateStart'].' '.$_POST['timeStart'];
    $date_end = $_POST['dateEnd'].' '.$_POST['timeEnd'];
    $description = $_POST['description1']."\n".$_POST['description2']."\n".$_POST['description3'];
    $picture = (($_FILES['picture']['tmp_name']) ? file_get_contents($_FILES['picture']['tmp_name']) : 'NULL');

    // insertion de l'offre en base
    $req = "INSERT INTO offers(user_id,category,title,description,status,date_start,date_end,arrondissement,address,picture) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $statement = $pdo->prepare($req);
    $statement->execute([$user_id,$category,$title,$description,'enabled',$date_start,$date_end,$arrondissement,$address,$picture]);

    // on met a jour le lastactivity de l'utilisateur
    $lastactivity = date('Y-m-d H:i:s');
    $req = "UPDATE users set date_lastactivity = $lastactivity WHERE id = $user_id";
    $statement = $pdo->prepare($req);
    $statement->execute();

    // notification par email
    $headers_mail = "MIME-Version: 1.0\n";
    $headers_mail .= 'From: '.$conf['mail']['from']."\n";
    $headers_mail .= 'Content-Type: text/plain; charset="utf-8"'."\n";
    $body_mail = "Bonjour,

Nouvelle offre postée par l'utilisateur $user_id :

$title

$description

--
L'equipe Aouf
";
    mail($conf['mail']['admin'],'[aouf] Nouvelle offre',$body_mail,$headers_mail);

    echo "Offre <strong>$title</strong> postée, merci&nbsp;!<br>";
}

$uri = $_SERVER['REQUEST_URI'];
$placeholdertitre = "Ce que je propose en 1 ligne…";
$description = "Décrivez ce que vous proposez";
$placeholder1 = "Je propose…";
$placeholder2 = "";
$placeholder3 = "";
if (preg_match('#^/offer/new/restauration#', $uri)) {
    $category = 'restauration';
    $placeholdertitre = "Couscous végétarien, mercredi midi, pour 6 personnes";
    $description = "Détails sur l'offre de restauration";
    $placeholder1 = "Je propose un repas complet pour 3 personnes…";
    $placeholder2 = "Le repas peut être consommé sur place ou à emporter…";
    $placeholder3 = "Le repas est de type sans porc / végétarien / végétalien / hallal / casher / sans gluten…";
} elseif (preg_match('#^/offer/new/blanchisserie#', $uri)) {
    $category = 'blanchisserie';
    $description = "Décrivez ce que vous proposez (lessive fournie ?
séchage sur place ? etc.)
";
} elseif (preg_match('#^/offer/new/mobilite#', $uri)) {
    $category = 'mobilite';
    $description = "Décrivez ce que vous proposez (temps disponible ?
place dans votre véhicule ? etc.)
";
} elseif (preg_match('#^/offer/new/loisir#', $uri)) {
    $category = 'loisir';
    $description = "Décrivez ce que vous proposez (activité ? pour qui ?
où ? nombre de places ? etc.)
";
} elseif (preg_match('#^/offer/new/don#', $uri)) {
    $category = 'don';
    $description = "Décrivez ce que vous donnez (taille ? poids ?
où le récupérez ? etc.)
";
} 
?>
<div class="container bg-blanc noir full-size">
    <div class="content">

        <h2>Je propose une offre de <?php echo $category; ?></h2>
            <form class="full-size flex center column" method='post' enctype='multipart/form-data'>
            <label for="title">Titre <span class="saumon">*</span></label>
            <input type='text' name='title' placeholder='<?php echo $placeholdertitre; ?>'>
            <label for="">Arrondissement (Marseille)<span class="saumon">*</span></label>
            <select name='arrondissement'>
                <option value='0' selected='selected' disabled='disabled'>Je choisis l'arrondissement où se trouve mon offre</option>
                <option value='1'>Marseille 1er</option>
                <option value='2'>Marseille 2eme</option>
                <option value='3'>Marseille 3eme</option>
                <option value='4'>Marseille 4eme</option>
                <option value='5'>Marseille 5eme</option>
                <option value='6'>Marseille 6eme</option>
                <option value='7'>Marseille 7eme</option>
                <option value='8'>Marseille 8eme</option>
                <option value='9'>Marseille 9eme</option>
                <option value='10'>Marseille 10eme</option>
                <option value='11'>Marseille 11eme</option>
                <option value='12'>Marseille 12eme</option>
                <option value='13'>Marseille 13eme</option>
                <option value='14'>Marseille 14eme</option>
                <option value='15'>Marseille 15eme</option>
                <option value='16'>Marseille 16eme</option>
            </select>
            <label for="address">Adresse (facultatif)</label>
            <input type='text' name='address' placeholder="Je donne l'adresse où se trouve mon offre">
            <!--<label for="allDay">Toute la journée <input type="checkbox" name="allDay" value="yes"></label>-->
            <section class="flex column center">
                <span>Début de l'offre <span class="saumon">*</span></span>
                    <section class="flex">
                        <section class="flex column center"><label for="dateStart">Jour</label><input type='date' name="dateStart" value="<?php echo date('Y-m-d'); ?>"></section>
                        <section class="flex column center"><label for="timeStart">Heure</label><input type='time' name="timeStart" value="<?php echo date('H:i'); ?>"></section>
                    </section>
            </section>
            <section class="flex column center">
                <span>Fin de l'offre <span class="saumon">*</span></span>
                    <section class="flex">
                        <section class="flex column center"><label for="dateEnd">Jour</label><input type='date' name="dateEnd" value="<?php echo date('Y-m-d', time() + 7200); ?>"></section>
                        <section class="flex column center"><label for="timeEnd">Heure</label><input type='time' name="timeEnd" value="<?php echo date('H:i', time() + 7200); ?>"></section>
                    </section>
            </section>
            <p><?php echo $description ?> <span class="saumon">*</span></p>
            <textarea name='description1' placeholder="<?php echo $placeholder1; ?>"></textarea>
            <textarea name='description2' placeholder="<?php echo $placeholder2; ?>"></textarea>
            <textarea name='description3' placeholder="<?php echo $placeholder3; ?>"></textarea>
            <label for="">Photo illustrant l'offre</label><input type='file' name='picture'>
            <input type='hidden' name='category' value='<?php echo $category; ?>'>
            <button class='bg-vert noir' type="submit" name="button" value"Publier">Publier</button>
            </form>

    </div>
</div>
<?php
require_once 'footer.php';
