<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recogiendo los datos del formulario
    $uid = $_POST['uid'];
    $unorg = $_POST['unorg'];
    $num_id = $_POST['num_id'];
    $grup = $_POST['grup'];
    $dir_pers = $_POST['dir_pers'];
    $sh = $_POST['sh'];
    $cn = $_POST['cn'];
    $sn = $_POST['sn'];
    $nom = $_POST['nom'];
    $mobil = $_POST['mobil'];
    $adressa = $_POST['adressa'];
    $telefon = $_POST['telefon'];
    $titol = $_POST['titol'];
    $descripcio = $_POST['descripcio'];
    $objcl = array('inetOrgPerson', 'organizationalPerson', 'person', 'posixAccount', 'shadowAccount', 'top');
    
    // Configuración y conexión LDAP
    $domini = 'dc=fjeclot,dc=net';
    $opcions = [
        'host' => 'zend-patulo.fjeclot.net',
        'username' => "cn=admin,$domini",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];
    $ldap = new Ldap($opcions);
    $ldap->bind();
    
    // Creando la nueva entrada
    $nova_entrada = [];
    Attribute::setAttribute($nova_entrada, 'objectClass', $objcl);
    Attribute::setAttribute($nova_entrada, 'uid', $uid);
    Attribute::setAttribute($nova_entrada, 'uidNumber', $num_id);
    Attribute::setAttribute($nova_entrada, 'gidNumber', $grup);
    Attribute::setAttribute($nova_entrada, 'homeDirectory', $dir_pers);
    Attribute::setAttribute($nova_entrada, 'loginShell', $sh);
    Attribute::setAttribute($nova_entrada, 'cn', $cn);
    Attribute::setAttribute($nova_entrada, 'sn', $sn);
    Attribute::setAttribute($nova_entrada, 'givenName', $nom);
    Attribute::setAttribute($nova_entrada, 'mobile', $mobil);
    Attribute::setAttribute($nova_entrada, 'postalAddress', $adressa);
    Attribute::setAttribute($nova_entrada, 'telephoneNumber', $telefon);
    Attribute::setAttribute($nova_entrada, 'title', $titol);
    Attribute::setAttribute($nova_entrada, 'description', $descripcio);
    
    $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';
    
    if ($ldap->add($dn, $nova_entrada)) {
        $_SESSION['message'] = "Usuari creat";
    } else {
        $_SESSION['message'] = "Error al crear el usuario";
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<html>
	<head>
		<title>
			Crear Usuaris LDAP
		</title>
	</head>
	<body>
		<form action="http://zend-patulo.fjeclot.net/projecte/addUser.php" method="POST">
			 <label for="uid">UID:</label>
             <input type="text" name="uid" id="uid" required>
             <label for="unorg">Unitat organitzativa:</label>
             <input type="text" name="unorg" id="unorg" required>
             <label for="num_id">ID:</label>
             <input type="number" name="num_id" id="num_id" required>
             <label for="grup">Grup:</label>
             <input type="number" name="grup" id="grup" required>
             <label for="dir_pers">Directori Personal:</label>
             <input type="text" name="dir_pers" id="dir_pers" required>
             <label for="sh">Shell:</label>
             <input type="text" name="sh" id="sh" required>
             <label for="cn">Nom Complet (CN):</label>
             <input type="text" name="cn" id="cn" required>
             <label for="sn">Cognom (SN):</label>
             <input type="text" name="sn" id="sn" required>
             <label for="nom">Nom (Given Name):</label>
             <input type="text" name="nom" id="nom" required>
             <label for="mobil">Mobil:</label>
             <input type="text" name="mobil" id="mobil" required>
             <label for="adressa">Direccio Postal:</label>
			 <input type="text" name="adressa" id="adressa" required>
			 <label for="telefon">Telefon:</label>
             <input type="text" name="telefon" id="telefon" required>
             <label for="titol">Titol:</label>
             <input type="text" name="titol" id="titol" required>
             <label for="descripcio">Descripción:</label>
             <input type="text" name="descripcio" id="descripcio" required>
             
             <input type="submit" value="Crear Usuari">
		</form>
	</body>
</html>