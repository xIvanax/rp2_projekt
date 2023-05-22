<?php

// Manualno inicijaliziramo bazu ako veÄ‡ nije.
require_once 'db.class.php';

$db = DB::getConnection();

// Priprema passworda korinsika
try
{
	$st1 = $db->prepare( 'SELECT id_usera, password_hash FROM projekt_useri' );
	$st1->execute();
}
catch( PDOException $e ) { exit( "PDO error [update projekt_users]: " . $e->getMessage() ); }
	$users = $st1->fetch();
try
	{

		$pass = password_hash( $row, PASSWORD_DEFAULT );
		//$st = $db->prepare( 'UPDATE projekt_users SET password_hash = $pass);

	}
	catch( PDOException $e ) { exit( "PDO error [update projekt_users]: " . $e->getMessage() ); }
echo "Ubacio u tablicu projekt_users.<br />";
?>
