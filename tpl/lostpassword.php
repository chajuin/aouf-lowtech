<?php
require_once 'head.php';
// require_once 'header.php';
$pdo = new PDO('mysql:host='.SERVEUR.';dbname='.BASE,NOM,PASSE);

if (isset($_POST['email'])) {
    // éviter brute force bourrin (TODO: à améliorer)
    sleep(1);
    $email_addr = $_POST['email'];
    // TODO: à sécuriser contre les XSS
    $req = "SELECT status FROM users WHERE email='".$email_addr."' LIMIT 1";
    $statement = $pdo->query($req);
    $data = $statement->fetch();

    $status = $data['status'];
    
    if ($status == 'enabled') {

        // send email for reset password
        $headers_mail = "MIME-Version: 1.0\n";
        $headers_mail .= 'From: '.$conf['mail']['from']."\n";
        $headers_mail .= 'Content-Type: text/plain; charset="utf-8"'."\n";
        $body_mail = "Bonjour,

Vous pouvez changer le mot de passe de votre compte en cliquant sur ce lien :

https://low.aouf.fr/TODO

(valable pendant 24h)

--
L'equipe Aouf
";
    mail($email_addr,'Changement de mot de passe de votre compte Aouf',$body_mail,$headers_mail);
    }
    echo "Si vous avez un compte valide, vous allez recevoir un email pour modifier votre mot de passe&nbsp;!<br>";
}
?>
<body>
    <div class='container no-margin full-size noir'>
        <div class="titre bg-vert noir">
            <h2>Mot de passe oublié</h2>
        </div>
        <center><a class="small-text" href='/'>Retour</a></center>
        <form class='full-size flex center column' method='post'>
            <label for="email">Email <span class="saumon"></span></label>
            <input type='text' name='email'>
                        <button class='bg-vert noir' type="submit" value="Réinitialiser mon mot de passe">Réinitialiser mon mot de passe</button>
        </form>
</div>
<?php 
    require_once 'footer.php';
