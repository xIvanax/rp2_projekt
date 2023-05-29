<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';
require_once __DIR__ . '/hotel.class.php';

class HotelService
{
	function addeditroom_service($id, $tip, $cijena){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'DELETE FROM projekt_sobe WHERE id_sobe=:id' );
			$st->execute(array( 'id' => $id ));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		try
		{
			$db = DB::getConnection();
			$st2 = $db->prepare( 'INSERT INTO projekt_sobe(id_sobe, id_hotela, tip, cijena) VALUES ' .
				'(:id_sobe, :id_hotela, :tip, :cijena)' );
			$st2->execute(array( 'id_sobe' => $id,
													 'id_hotela' => $_SESSION["id_hotela"],
												 	 'tip' => $tip,
												 	 'cijena' => $cijena));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function removeroom_service($id){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'DELETE FROM projekt_sobe WHERE id_sobe=:id' );
			$st->execute(array( 'id' => $id ));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function getHotelIdFromUsername($username)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_hotela FROM projekt_users WHERE username=:username' );
			$st->execute(array( 'username' => $username ));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return $row["id_hotela"];
	}

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
	//za dodjelu novog id-a
	function getHighestRoomId(){
		$db = DB::getConnection();
		$st = $db->prepare( 'SELECT id_sobe FROM projekt_sobe');
		$st->execute();

		$i = 1;
		$arr = array();
		while($row = $st->fetch()){
			$arr[] = $row['id_sobe'];
		}
		while(1)
		{
			if(!in_array($i, $arr))
			{
				return $i;
			}
			$i += 1;
		}
		return $i;
	}

	function getRoomsFromIdHotela($id_hotela)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_sobe, tip, cijena FROM projekt_sobe WHERE id_hotela=:id_hotela');
			$st->execute(array( 'id_hotela' => $id_hotela ));
		}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		$sobe_list = array();
		while($row = $st->fetch()){
			$soba=array($row["id_sobe"], $row["tip"], $row["cijena"]);
			$sobe_list[] = $soba;
		}
		return $sobe_list;
	}

	function insertUnregisteredUser($email, $password, $registration_sequence, $username, $id_hotela)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO projekt_users(email, has_registered, id_usera,
				 				password_hash, registration_sequence, username, datum_dolaska, datum_odlaska, id_hotela) VALUES ' .
				                '(:email, 0, :id_usera, :password_hash, :registration_sequence, :username, NULL, NULL, :id_hotela)' );
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
				                 'username'  => $username,
											   'id_hotela' => $id_hotela) );
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
//prikazuje sve hotele koji su dostupni u aplikaciji
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

			$arr[] = array(new Hotel( $row['grad'], $row['id_hotela'], $row['ime'], $row['udaljenost_od_centra'] ), round($rating, 2));
		}

		return $arr;
	}
//prikazuje hotele u skladu s filterima koje je odabrao korisnik
	function getNarrowedHotels($city, $lowPrice, $upPrice, $distance, $lowRating, $upRating)
	{
		//prvo dohvatim taj grad i odmah filtriram i udaljenost
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( "SELECT id_hotela, ime, udaljenost_od_centra FROM projekt_hoteli WHERE grad = '" . $city . "' AND udaljenost_od_centra < " . (double)$distance);
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		$filteredHotels = array();
		while( $row = $st->fetch() )
		{
			//moram izračunati prosječni rating svakog od tih hotela (bolje imati zasebnu funkciju koja računa prosječni rating)
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

			if($lowRating < $rating && $rating < $upRating)
				$arr[] = array(new Hotel( $city, $row['id_hotela'], $row['ime'], $row['udaljenost_od_centra'] ), round($rating, 2));
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
					break;
				}
			}
		}

		return $filteredHotels;
	}

	function getRoomTypeFromHotelId($id_hotela){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_sobe, tip, cijena FROM projekt_sobe WHERE id_hotela=:id_hotela ORDER BY cijena ');
			$st->execute(array( 'id_hotela' => $id_hotela ));
		}catch(PDOException $e) { exit( 'PDO error ' . $e->getMessage() );}

		$sobe_list=array();
		while($row=$st->fetch()){
			if(sizeof($sobe_list)===0)
				$sobe_list[]=array($row["tip"], $row["cijena"], 1);
			else{
				$provjera=-1;
				$brojac=-1;
				foreach($sobe_list as $soba){
					$brojac++;
					if($row["tip"]===$soba[0]){
						$provjera=$brojac;
					}
				}
				
				if($provjera===-1)
					$sobe_list[]=array($row["tip"], $row["cijena"], 1);
				else{
					$broj=$sobe_list[$provjera][2]+1;
					$sobe_list[$provjera][2]=$broj;
				}
			}
		}
		return $sobe_list;
	}

	//vraca sve komentare na smjestaj za hotel odreden s $id_hotela
	function getReviewsForHotelById($id_hotela){
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT username, komentar, ocjena FROM projekt_ocjene WHERE id_hotela=:id_hotela');
			$st->execute(array( 'id_hotela' => $id_hotela ));
		}catch(PDOException $e) { exit( 'PDO error ' . $e->getMessage() );}

		$arr=array();
		while($row=$st->fetch()){
			$arr[]=array($row['username'], $row['ocjena'], $row['komentar']);
		}
		return $arr;
	}

	//za hotel, odreden s $id_hotela, odreduje koliko ima dostupnih soba svakog tipa periodu izmedu datuma $dolazak i $odlazak
	function getAvailableRooms($id_hotela, $dolazak, $odlazak){
		//dohvacam sve sobe koje su u ponudi hotela
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_sobe, tip, cijena FROM projekt_sobe WHERE id_hotela=:id_hotela ORDER BY cijena ');
			$st->execute(array( 'id_hotela' => $id_hotela ));
		}catch(PDOException $e) { exit( 'PDO error ' . $e->getMessage() );}

		$arr=array();
		//za svaku sobu provjeravam je li slobodna u danom periodu
		while($row=$st->fetch()){
			try{
				$db=DB::getConnection();
				$st1=$db->prepare( 'SELECT id_sobe, datum_oslobodenja, datum_zauzeca FROM projekt_sobe_datumi WHERE id_sobe=:id_sobe');
				$st1->execute([ 'id_sobe' => $row['id_sobe'] ]);
			}catch(PDOException $e) { exit( 'PDO error ' . $e->getMessage() );}

			$provjera=true;
			while($row1=$st1->fetch()){
				if($row1['datum_oslobodenja']>$dolazak || $row1['datum_zauzeca']<$odlazak)
					$provjera=false;
			}

			//ako je polje prazno i soba je slobodna, stavljamo ju u polje
			if(sizeof($arr)===0 && $provjera)
				$arr[]=array($row["tip"], $row["cijena"], 1);
			else if($provjera){
				//provjeravamo nalazi li se u polju vec soba tog tipa
				//ako se nalazi onda samo povecavamo broj dostupnih soba
				//inace ju stavljamo u polje
				$p=-1;
				$brojac=-1;
				foreach($arr as $soba){
					$brojac++;
					if($row["tip"]===$soba[0]){
						$p=$brojac;
					}
				}
					
				if($p===-1)
					$arr[]=array($row["tip"], $row["cijena"], 1);
				else{
					$broj=$arr[$p][2]+1;
					$arr[$p][2]=$broj;
				}
			}
		}

		return $arr;
	}

	//funkcija koja rezervira sobe odredenog tipa
	//$tip - tip sobe
	//$broj - kolicina soba odredenog tipa koje zelimo rezervirati
	//$dolazak, $odlazak - datumi dolaska tj. odlaska
	function reserveRoom($tip, $broj, $dolazak, $odlazak){
		$rezervirane=0;
		//dohvacam sve id-ove soba promatranog tipa
		try{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_sobe FROM projekt_sobe WHERE tip=:tip');
			$st->execute(array( 'tip' => $tip ));
		}catch(PDOException $e) { exit( 'PDO error ' . $e->getMessage() );}

		//za svaku sobu provjeravam je li slobodna u danom periodu
		while($row=$st->fetch()){
			try{
				$db=DB::getConnection();
				$st1=$db->prepare( 'SELECT id_sobe, datum_oslobodenja, datum_zauzeca FROM projekt_sobe_datumi WHERE id_sobe=:id_sobe');
				$st1->execute([ 'id_sobe' => $row['id_sobe'] ]);
			}catch(PDOException $e) { exit( 'PDO error ' . $e->getMessage() );}

			$provjera=true;
			while($row1=$st1->fetch()){
				if($row1['datum_oslobodenja']>$dolazak || $row1['datum_zauzeca']<$odlazak)
					$provjera=false;
			}

			//ako je soba slobodna onda ju rezerviramo za dani period
			if($provjera){
				try{
					$db=DB::getConnection();
					$st1=$db->prepare('INSERT INTO projekt_sobe_datumi (id_sobe, datum_oslobodenja, datum_zauzeca) VALUES (:id_sobe, :datum_oslobodenja, :datum_zauzeca)');
					$st1->execute(array('id_sobe'=>$row['id_sobe'], 'datum_oslobodenja' => $odlazak, 'datum_zauzeca' => $dolazak));
				}catch(PDOException $e) {exit( 'PDO error ' . $e->getMessage() );}
				
				$rezervirane++;
			}

			if($rezervirane===$broj) break;
			
		}

	}
		
}

?>
