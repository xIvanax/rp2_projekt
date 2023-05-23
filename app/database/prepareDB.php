<?php

// Manualno inicijaliziramo bazu ako veÄ‡ nije.
require_once 'db.class.php';

$db = DB::getConnection();

// Priprema passworda korinsika
try
{
	$st1 = $db->prepare( 'SELECT id_usera, password_hash FROM projekt_users' );
	$st1->execute();
}
catch( PDOException $e ) { exit( "PDO error [select projekt_users]: " . $e->getMessage() ); }
	while($user = $st1->fetch())
	{
		echo "id=";
		echo $user['id_usera'];
		echo "<br>";
		echo "pass=";
		echo $user['password_hash'];
		$pass = password_hash( $user['password_hash'], PASSWORD_DEFAULT );
		try
		{
			$st2 = $db->prepare("UPDATE projekt_users SET password_hash = '" . $pass . "' WHERE id_usera = '" . $user['id_usera'] . "'");
			$st2->execute();
		}
		catch( PDOException $e ) { exit( "PDO error [update projekt_users]: " . $e->getMessage() ); }
	}
echo "Ubacio u tablicu projekt_users hashirane passworde.<br />";
