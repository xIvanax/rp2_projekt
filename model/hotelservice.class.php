<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';
require_once __DIR__ . '/hotel.class.php';

class HotelService
{
	function getIdAndPasswordFromUsername($username)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT email, has_registered, id_usera, password_hash, registration_sequence, username, datum_dolaska, datum_odlaska FROM projekt_useri WHERE username=:username' );
			$st->execute(array( 'username' => $username ));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return $row;
	}

	function insertUnregisteredUser($email, $password, $registration_sequence, $username)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO projekt_useri(email, has_registered, id_usera, password_hash, registration_sequence, username, datum_dolaska, datum_odlaska) VALUES ' .
				                '(:email, 0, :id_usera, :password_hash, :registration_sequence, :username, NULL, NULL)' );
			$st2 = $db->prepare( 'SELECT id_usera FROM projekt_useri' );
			$st2->execute();
			//konstruiram novi id_usera
			$arr = array();
			while( $row = $st2->fetch() )
			{
				$arr[] = $row['id_usera'];
			}
			$i = 1;
			while(true)
			{
				if(!in_array($i, $arr))
					break;
				else
					$i++;
			}

			$st->execute( array( 'email' => $email, 'id_usera' => $i,
				                 'password_hash' => password_hash( $password, PASSWORD_DEFAULT ),
				                 'registration_sequence' => $registration_sequence,
				                 'username'  => $username ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function getAvailableHotels()
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT grad, id_usera_hotela, ime, udaljenost_od_centra FROM dz2_hoteli' );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = new Hotel( $row['grad'], $row['id_usera_hotela'], $row['ime'], $row['udaljenost_od_centra'] );
		}

		return $arr;
	}

?>
