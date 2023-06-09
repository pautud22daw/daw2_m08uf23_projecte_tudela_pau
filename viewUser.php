<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

//ini_set('display_errors',0);
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if ($_POST['usr'] && $_POST['ou']){
        $opcions = [
            'host' => 'zend-patulo.fjeclot.net',
            'username' => "cn=admin,dc=fjeclot,dc=net",
            'password' => 'fjeclot',
            'bindRequiresDn' => true,
            'accountDomainName' => 'fjeclot.net',
            'baseDn' => 'dc=fjeclot,dc=net',
        ];
        $ldap = new Ldap($opcions);
        $ldap->bind();
        $entrada='uid='.$_POST['usr'].',ou='.$_POST['ou'].',dc=fjeclot,dc=net';
        $usuari=$ldap->getEntry($entrada);
        echo "<b><u>".$usuari["dn"]."</b></u><br>";
        foreach ($usuari as $atribut => $dada) {
            if ($atribut != "dn") echo $atribut.": ".$dada[0].'<br>';
        }
    }
}
?>
<html>
    <head>
        <title>
        	MOSTRANT DADES D'USUARIS DE LA BASE DE DADES LDAP
        </title>
    </head>
    <body>
        <h2>Formulari de selecció d'usuari</h2>
        <form action="http://zend-patulo.fjeclot.net/projecte/viewUser.php" method="POST">
            Unitat organitzativa: <input type="text" name="ou"><br>
            Usuari: <input type="text" name="usr"><br>
            <input type="submit"/>
            <input type="reset"/>
        </form>
        <a href="http://zend-patulo.fjeclot.net/projecte/menu.php">Torna a la pàgina inicial</a>
    </body>
</html>