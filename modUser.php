<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;
use Laminas\Ldap\Attribute;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if($_POST['uid'] && $_POST['unorg'] && $_POST['atribut'] && $_POST['nou_contingut']){
        $uid = $_POST['uid'];
        $unorg = $_POST['unorg'];
        $atribut = $_POST['atribut'];
        $nou_contingut = $_POST['nou_contingut'];
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
        
        $dn = 'uid=' . $uid . ',ou=' . $unorg . ',dc=fjeclot,dc=net';
        $entrada = $ldap->getEntry($dn);
        if ($entrada) {
            Attribute::setAttribute($entrada, $atribut, $nou_contingut);
            try {
                $ldap->update($dn, $entrada);
                echo "<b>Atribut modificat</b><br>";
            } catch (Exception $e) {
                echo "<b>Error al modificar l'usuari: " . $e->getMessage() . "</b><br>";
            }
        } else {
            echo "<b>Aquesta entrada no existeix</b><br><br>";
        }
    }
}
?>
<html>
	<head>
		<title>
			Modificar Usuari
		</title>
	</head>
	<body>
		<form action="http://zend-patulo.fjeclot.net/projecte/modUser.php" method="POST">
            <label for="uid">UID:</label>
            <input type="text" name="uid" id="uid" required><br>
            <label for="unorg">Unidad Organizativa:</label>
            <input type="text" name="unorg" id="unorg" required><br>
            <label>Atributo a modificar:</label><br>
            <input type="radio" id="uidNumber" name="atribut" value="uidNumber" required>
            <label for="uidNumber">uidNumber</label><br>
            <input type="radio" id="gidNumber" name="atribut" value="gidNumber">
            <label for="gidNumber">gidNumber</label><br>
            <input type="radio" id="directorio" name="atribut" value="homeDirectory">
            <label for="directorio">Directorio personal</label><br>
            <input type="radio" id="shell" name="atribut" value="loginShell">
            <label for="shell">Shell</label><br>
            <input type="radio" id="cn" name="atribut" value="cn">
            <label for="cn">cn</label><br>
            <input type="radio" id="sn" name="atribut" value="sn">
            <label for="sn">sn</label><br>
            <input type="radio" id="givenName" name="atribut" value="givenName">
            <label for="givenName">givenName</label><br>
            <input type="radio" id="postalAddress" name="atribut" value="postalAddress">
            <label for="postalAddress">PostalAddress</label><br>
            <input type="radio" id="mobile" name="atribut" value="mobile">
            <label for="mobile">mobile</label><br>
            <input type="radio" id="telephoneNumber" name="atribut" value="telephoneNumber">
            <label for="telephoneNumber">telephoneNumber</label><br>
            <input type="radio" id="title" name="atribut" value="title">
            <label for="title">title</label><br>
            <input type="radio" id="description" name="atribut" value="description">
            <label for="description">description</label><br>
            <label for="nou_contingut">Nuevo valor:</label>
            <input type="text" name="nou_contingut" id="nou_contingut" required>
            <input type="submit" value="Modificar Usuario">
        </form>
        <a href="http://zend-patulo.fjeclot.net/projecte/menu.php">Torna a la pàgina inicial</a>
	</body>
</html>