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
			$st = $db->prepare( 'SELECT email, has_registered, id_usera, password_hash, registration_sequence, username, datum_dolaska, datum_odlaska FROM projekt_users WHERE username=:username' );
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
			$st = $db->prepare( 'INSERT INTO projekt_users(email, has_registered, id_usera, password_hash, registration_sequence, username, datum_dolaska, datum_odlaska) VALUES ' .
				                '(:email, 0, :id_usera, :password_hash, :registration_sequence, :username, NULL, NULL)' );
			$st2 = $db->prepare( 'SELECT id_usera FROM projekt_users' );
			$st2->execute();

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

	function register($niz)
	{
		$db = DB::getConnection();

		try
		{
			$st = $db->prepare('SELECT * FROM projekt_users WHERE registration_sequence=:registration_sequence');
			$st->execute(array('registration_sequence' => $_GET['niz']));
		}
		catch(PDOException $e) { exit('Greška u bazi: ' . $e->getMessage()); }

		$row = $st->fetch();

		if($st->rowCount() !== 1)
			exit('Taj registracijski niz ima ' . $st->rowCount() . 'korisnika, a treba biti točno 1 takav.');
		else
		{
			try
			{
				$st = $db->prepare('UPDATE projekt_users SET has_registered=1 WHERE registration_sequence=:registration_sequence');
				$st->execute(array('registration_sequence' => $_GET['niz']));
			}
			catch(PDOException $e) { exit('Greška u bazi: ' . $e->getMessage()); }
		}
	}

	function getAvailableHotels()
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT grad, id_hotela, ime, udaljenost_od_centra FROM projekt_hoteli' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			//moram izračunati prosječni rating tog hotela
		/*	echo "sad trazim prosjecnu ocjenu za hotel ";
			echo $row['ime'];
			echo "<br>";
			echo "id = ";
			echo $row['id_hotela'];
			echo "<br>";*/
			try
			{
				$db = DB::getConnection();
				$st1 = $db->prepare( "SELECT ocjena FROM projekt_ocjene WHERE id_hotela = '" . $row['id_hotela'] . "'");
				$st1->execute();
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
			$ocjene = 0;
			$num = 0;
			while($row1 = $st1->fetch())
			{
				$ocjene += $row1['ocjena'];
				$num += 1;
			}
			/*echo "num = ";
			echo $num;
			echo "<br>";
			echo "ocjene = ";
			echo $ocjene;
			echo "<br>";*/
			$rating = $ocjene / $num;

			$arr[] = array(new Hotel( $row['grad'], $row['id_hotela'], $row['ime'], $row['udaljenost_od_centra'] ), round($rating, 2));
		}

		return $arr;
	}

	function getNarrowedHotels($city, $lowPrice, $upPrice, $distance, $lowRating, $upRating)
	{
		//prvo dohvatim taj grad i odmah filtriram i udaljenost
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( "SELECT id_hotela, ime, udaljenost_od_centra FROM projekt_hoteli WHERE grad LIKE '" . $grad . "' AND udaljenost_od_centra BETWEEN 0 AND " . $distance);
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		$filteredHotels = array();
		while( $row = $st->fetch() )
		{
			//moram izračunati prosječni rating svakog od tih hotela
			try
			{
				$db = DB::getConnection();
				$st1 = $db->prepare( "SELECT ocjena FROM projekt_ocjene WHERE id_hotela = '" . $row['id_hotela'] . "'");
				$st1->execute();
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
			$ocjene = 0;
			$num = 0;
			while($row1 = $st1->fetch())
			{
				$ocjene += $row1['ocjena'];
				$num += 1;
			}
			$rating = $ocjene / $num;
			if($lowRating < $rating && $rating > $upRating)
				$arr[] = array(new Hotel( $row['grad'], $row['id_hotela'], $row['ime'], $row['udaljenost_od_centra'] ), round($rating, 2));
		}
		//sad u arr imam niz koji na prvom mjestu ima hotel, a na drugom ocjenu i to filtrirano po gradu, udaljenosti i ratingu
		//preostaje filtrirati po cijenama - moram za svaki hotel provjeriti ima li sobu koja je u navedenom price rangeu
		foreach($arr as $hotelAndRating)
		{
			try
			{
				$db = DB::getConnection();
				$st = $db->prepare( "SELECT cijena FROM projekt_sobe WHERE id_hotela LIKE '" . $hotelAndRating[0]->id_hotela . "'");
				$st->execute();
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

			while($row = $st->fetch())
			{
				if($row['cijena'] < $upPrice && $row['cijena'] > $lowPrice)
				{
					$filteredHotels[] = $hotelAndRating;
				}
			}
		}
		return $filteredHotels;
	}
}
?>
