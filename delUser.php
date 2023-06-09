<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['uid'] && $_POST['unorg']){
        $uid = $_POST['uid'];
        $unorg = $_POST['unorg'];
        
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
        
        // Eliminando la entrada
        $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';
        try {
            $ldap->delete($dn);
            echo "<b>Entrada esborrada</b><br>";
        } catch (Exception $e) {
            echo "<b>Aquesta entrada no existeix</b><br>";
        }
    }
}
?>
<html>
	<head>
		<title>
			Esborrar Usuari
		</title>
	</head>
	<body>
    	<form action="http://zend-patulo.fjeclot.net/projecte/delUser.php" method="POST">
            <label for="uid">UID:</label>
            <input type="text" name="uid" id="uid" required><br>
            <label for="unorg">Unidad Organizativa:</label>
            <input type="text" name="unorg" id="unorg" required>
            <input type="submit" value="Eliminar Usuario">
        </form>
        <a href="http://zend-patulo.fjeclot.net/projecte/menu.php">Torna a la pàgina inicial</a>
	</body>
</html>
