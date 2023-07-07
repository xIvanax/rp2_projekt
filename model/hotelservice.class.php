<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';
require_once __DIR__ . '/hotel.class.php';

class HotelService {
	function addeditroom_service($id, $tip, $cijena) {
		try {
			$db = DB::getConnection();
			$st = $db->prepare( 'DELETE FROM projekt_sobe WHERE id_sobe=:id' );
			$st->execute(array( 'id' => $id ));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		try {
			$db = DB::getConnection();
			$st2 = $db->prepare( 'INSERT INTO projekt_sobe(id_sobe, id_hotela, tip, cijena) VALUES ' .
				'(:id_sobe, :id_hotela, :tip, :cijena)' );
			$st2->execute(array( 'id_sobe' => $id, 'id_hotela' => $_SESSION["id_hotela"],
			'tip' => $tip, 'cijena' => $cijena));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}

	function removeroom_service($id) {
		try {
			$db = DB::getConnection();
			//brisanje sobe iz baze koja sadrzi popis svih soba
			$st = $db->prepare( 'DELETE FROM projekt_sobe WHERE id_sobe=:id' );
			$st->execute(array( 'id' => $id ));
			//brisanje sobe iz baze buducih rezervacija, gdje je rezervirana promatrana soba
			$st = $db->prepare( 'DELETE FROM projekt_sobe_datumi WHERE id_sobe=:id' );
			$st->execute(array( 'id' => $id ));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
	}
	//je li korisnik premium ili obicni na temelju njegovog username-a
	function getHotelIdFromUsername($username) {
		try {
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
	//dohvat id-a i passworda user-a na temelju njegvoog username-a
	function getIdAndPasswordFromUsername($username) {
		try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT email, has_registered, id_usera, password_hash, registration_sequence, 
			username, datum_dolaska, datum_odlaska FROM projekt_users WHERE username=:username' );
			$st->execute(array( 'username' => $username ));
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return $row;
	}
	//za dodjelu novog id-a sobe
	function getHighestRoomId() {
		$db = DB::getConnection();
		$st = $db->prepare( 'SELECT id_sobe FROM projekt_sobe');
		$st->execute();

		$i = 1;
		$arr = array();
		while($row = $st->fetch()) {
			$arr[] = $row['id_sobe'];
		}
		while(1) {
			if(!in_array($i, $arr)) {
				return $i;
			}
			$i++;
		}
		return $i;
	}
	//dohvat soba hotela na temelju id-a hotela
	function getRoomsFromIdHotela($id_hotela) {
		try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_sobe, tip, cijena FROM projekt_sobe WHERE id_hotela=:id_hotela');
			$st->execute(array( 'id_hotela' => $id_hotela ));
		}catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		$sobe_list = array();
		while($row = $st->fetch()) {
			$soba=array($row["id_sobe"], $row["tip"], $row["cijena"]);
			$sobe_list[] = $soba;
		}
		return $sobe_list;
	}
	//ubacivanje neregistriranog korisnika u bazu
	function insertUnregisteredUser($email, $password, $registration_sequence, $username, $id_hotela) {
		try {
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO projekt_users(email, has_registered, id_usera,
				 				password_hash, registration_sequence, username, datum_dolaska, datum_odlaska, id_hotela) VALUES ' .
				                '(:email, 0, :id_usera, :password_hash, :registration_sequence, :username, NULL, NULL, :id_hotela)' );
			$st2 = $db->prepare( 'SELECT id_usera FROM projekt_users' );
			$st2->execute();

			$arr = array();
			while($row = $st2->fetch()) {
				$arr[] = $row['id_usera'];
			}
			$i = 1;
			while(true) {
				if(!in_array($i, $arr))
					break;
				else
					$i++;
			}

			$st->execute(array('email' => $email, 'id_usera' => $i,
				                 'password_hash' => password_hash( $password, PASSWORD_DEFAULT ),
				                 'registration_sequence' => $registration_sequence,
				                 'username'  => $username,
											   'id_hotela' => $id_hotela));
		}
		catch( PDOException $e ) {exit( 'PDO error ' . $e->getMessage()); }
	}
	//dohvat i registracija korisnika u skladu s registracijskim nizom u argumentu
	function register($niz) {
		$db = DB::getConnection();

		try {
			$st = $db->prepare('SELECT * FROM projekt_users WHERE registration_sequence=:registration_sequence');
			$st->execute(array('registration_sequence' => $_GET['niz']));
		}
		catch(PDOException $e) {exit('Greska u bazi: ' . $e->getMessage());}

		$row = $st->fetch();

		if($st->rowCount() !== 1)
			exit('Taj registracijski niz ima ' . $st->rowCount() . 'korisnika, a treba biti tocno 1 takav.');
		else {
			try {
				$st = $db->prepare('UPDATE projekt_users SET has_registered=1 WHERE registration_sequence=:registration_sequence');
				$st->execute(array('registration_sequence' => $_GET['niz']));
			}
			catch(PDOException $e) {exit('Greska u bazi: ' . $e->getMessage());}
		}
	}
//prikazuje sve hotele koji su dostupni u aplikaciji
	function getAvailableHotels() {
		try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT grad, id_hotela, ime, udaljenost_od_centra FROM projekt_hoteli' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() ) {
			//moram izracunati prosjecni rating tog hotela
			try {
				$db = DB::getConnection();
				$st1 = $db->prepare( "SELECT ocjena FROM projekt_ocjene WHERE id_hotela = '" . $row['id_hotela'] . "'");
				$st1->execute();
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
			$ocjene = 0;
			$num = 0;
			$id = $row['id_hotela'];
			while($row1 = $st1->fetch()) {
				$ocjene += $row1['ocjena'];
				$num += 1;
			}
			$rating = $ocjene / $num;
			$popis_soba = $this->getRoomsFromIdHotela($id);
			$cijena = 0;
			if(isset($popis_soba[0])) {
				$cijena = $popis_soba[0][2];
			}
			foreach ($popis_soba as $soba) {
				if ($cijena > $soba[2]){
					$cijena = $soba[2];
				}
			}
			$arr[] = array(new Hotel( $row['grad'], $row['id_hotela'], $row['ime'], $row['udaljenost_od_centra']), round($rating, 2), $cijena);
		}
		return $arr;
	}
	//prikazuje hotele u skladu s filterima koje je odabrao korisnik
	function getNarrowedHotels($city, $lowPrice, $upPrice, $distance, $lowRating, $upRating) {
		//prvo dohvatim taj grad i odmah filtriram i udaljenost
		try {
			$db = DB::getConnection();
			$st = $db->prepare( "SELECT id_hotela, ime, udaljenost_od_centra FROM projekt_hoteli WHERE grad = '" . $city . 
			"' AND udaljenost_od_centra < " . (double)$distance);
			$st->execute();
		}
		catch(PDOException $e) {exit( 'PDO error ' . $e->getMessage() );}

		$arr = array();
		$filteredHotels = array();
		while($row = $st->fetch()) {
			//moram izracunati prosjecni rating svakog od tih hotela (bolje imati zasebnu funkciju koja racuna prosjecni rating)
			try {
				$db = DB::getConnection();
				$st1 = $db->prepare( "SELECT ocjena FROM projekt_ocjene WHERE id_hotela = '" . $row['id_hotela'] . "'");
				$st1->execute();
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
			$ocjene = 0;
			$num = 0;
			while($row1 = $st1->fetch()) {
				$ocjene += $row1['ocjena'];
				$num += 1;
			}
			$rating = $ocjene / $num;

			if($lowRating < $rating && $rating < $upRating)
				$arr[] = array(new Hotel( $city, $row['id_hotela'], $row['ime'], $row['udaljenost_od_centra'] ), round($rating, 2));
		}
		//sad u arr imam niz koji na prvom mjestu ima hotel, a na drugom ocjenu i to filtrirano po gradu, udaljenosti i ratingu
		//preostaje filtrirati po cijenama - moram za svaki hotel provjeriti ima li sobu koja je u navedenom price rangeu
		foreach($arr as $hotelAndRating) {
			try {
				$db = DB::getConnection();
				$st = $db->prepare( "SELECT cijena FROM projekt_sobe WHERE id_hotela LIKE '" . $hotelAndRating[0]->id_hotela . "'");
				$st->execute();
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

			while($row = $st->fetch()) {
				if($row['cijena'] < $upPrice && $row['cijena'] > $lowPrice) {
					$filteredHotels[] = $hotelAndRating;
					break;
				}
			}
		}
		return $filteredHotels;
	}

	function getRoomTypeFromHotelId($id_hotela) {
		try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_sobe, tip, cijena FROM projekt_sobe WHERE id_hotela=:id_hotela ORDER BY cijena ');
			$st->execute(array( 'id_hotela' => $id_hotela ));
		}catch(PDOException $e) {exit( 'PDO error ' . $e->getMessage() );}

		$sobe_list = array();
		while($row = $st->fetch()) {
			if(sizeof($sobe_list) === 0)
				$sobe_list[] = array($row["tip"], $row["cijena"], 1);
			else {
				$provjera = -1;
				$brojac = -1;
				foreach($sobe_list as $soba) {
					$brojac++;
					if($row["tip"] === $soba[0]) {
						$provjera = $brojac;
					}
				}

				if($provjera === -1)
					$sobe_list[] = array($row["tip"], $row["cijena"], 1);
				else {
					$broj = $sobe_list[$provjera][2]+1;
					$sobe_list[$provjera][2] = $broj;
				}
			}
		}
		return $sobe_list;
	}

	//vraca sve komentare na smjestaj za hotel odreden s $id_hotela
	function getReviewsForHotelById($id_hotela) {
		try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT username, komentar, ocjena FROM projekt_ocjene WHERE id_hotela=:id_hotela');
			$st->execute(array( 'id_hotela' => $id_hotela ));
		}catch(PDOException $e) {exit( 'PDO error ' . $e->getMessage() );}

		$arr = array();
		while($row = $st->fetch()){
			$arr[] = array($row['username'], $row['ocjena'], $row['komentar']);
		}
		return $arr;
	}

	//funkcija koja provjerava valjanost unesenih
	//vraća 1 ako su oba izabrana datuma od trenutnog datuma pa nadalje
	function checkDates($dolazak, $odlazak) {
		$now = date("Y-m-d");
		if($dolazak < $now || $odlazak < $now) {
			return -1;
		}else if($odlazak < $dolazak) {
			return 0;
		}else {
			return 1;
		}
	}

	//za hotel, odreden s $id_hotela, odreduje koliko ima dostupnih soba svakog tipa periodu izmedu datuma $dolazak i $odlazak
	function getAvailableRooms($id_hotela, $dolazak, $odlazak) {
		//dohvacam sve sobe koje su u ponudi hotela
		try {
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT id_sobe, tip, cijena FROM projekt_sobe WHERE id_hotela=:id_hotela ORDER BY cijena ');
			$st->execute(array( 'id_hotela' => $id_hotela ));
		}catch(PDOException $e) {exit( 'PDO error ' . $e->getMessage() );}

		$arr = array();
		//za svaku sobu provjeravam je li slobodna u danom periodu
		while($row = $st->fetch()) {
			try {
				$db = DB::getConnection();
				$st1 = $db->prepare( 'SELECT id_sobe, datum_oslobodenja, datum_zauzeca FROM projekt_sobe_datumi WHERE id_sobe=:id_sobe');
				$st1->execute([ 'id_sobe' => $row['id_sobe'] ]);
			}catch(PDOException $e) {exit( 'PDO error ' . $e->getMessage() );}

			$provjera = true;
			while($row1 = $st1->fetch()) {
				if($row1['datum_oslobodenja'] > $dolazak || $row1['datum_zauzeca'] < $odlazak)
					$provjera = false;
			}

			//ako je polje prazno i soba je slobodna, stavljamo ju u polje
			if(sizeof($arr) === 0 && $provjera)
				$arr[] = array($row["tip"], $row["cijena"], 1);
			else if($provjera) {
				//provjeravamo nalazi li se u polju vec soba tog tipa
				//ako se nalazi onda samo povecavamo broj dostupnih soba
				//inace ju stavljamo u polje
				$p = -1;
				$brojac = -1;
				foreach($arr as $soba) {
					$brojac++;
					if($row["tip"] === $soba[0]){
						$p = $brojac;
					}
				}

				if($p === -1)
					$arr[] = array($row["tip"], $row["cijena"], 1);
				else {
					$broj = $arr[$p][2] + 1;
					$arr[$p][2] = $broj;
				}
			}
		}
		return $arr;
	}

	//funkcija koja rezervira sobe odredenog tipa
	//$tip - tip sobe
	//$broj - kolicina soba odredenog tipa koje zelimo rezervirati
	//$dolazak, $odlazak - datumi dolaska tj. odlaska
	function reserveRoom($tip, $broj, $dolazak, $odlazak, $username) {
		$rezervirane = 0;
		//dohvacam sve id-ove soba promatranog tipa
		try {
			$db = DB::getConnection();
			$st = $db->prepare('SELECT id_sobe FROM projekt_sobe WHERE tip=:tip');
			$st->execute(array('tip' => $tip));
		} catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}
		//dohvacam id_osobe s danim usernameom
		try {
			$db = DB::getConnection();
			$st1 = $db->prepare('SELECT id_usera FROM projekt_users WHERE username=:username');
			$st1->execute(array('username' => $username ));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

		$row1 = $st1->fetch();
		$id_osobe = $row1['id_usera'];

		//za svaku sobu provjeravam je li slobodna u danom periodu
		while($row = $st->fetch()) {
			try {
				$db = DB::getConnection();
				$st2 = $db->prepare('SELECT id_sobe, datum_oslobodenja, datum_zauzeca FROM projekt_sobe_datumi WHERE id_sobe=:id_sobe');
				$st2->execute(['id_sobe' => $row['id_sobe']]);
			} catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

			$provjera = true;
			while($row2 = $st2->fetch()) {
				if($row2['datum_oslobodenja'] > $dolazak || $row2['datum_zauzeca'] < $odlazak)
					$provjera = false;
			}
			if($dolazak > $odlazak) {
				$provjera = false;
			}
			$now = date("Y-m-d");
			if($dolazak < $now || $odlazak < $now) {
				$provjera = false;
			}

			//ako je soba slobodna onda ju rezerviramo za dani period
			if($provjera && $rezervirane<$broj) {
				try {
					$db = DB::getConnection();
					$st3 = $db->prepare('INSERT INTO projekt_sobe_datumi (id_sobe, id_osobe, datum_oslobodenja, datum_zauzeca) 
					VALUES (:id_sobe, :id_osobe, :datum_oslobodenja, :datum_zauzeca)');
					$st3->execute(array('id_sobe' => $row['id_sobe'], 'id_osobe' => $id_osobe, 'datum_oslobodenja' => $odlazak, 
					'datum_zauzeca' => $dolazak));
				}catch(PDOException $e) {exit( 'PDO error ' . $e->getMessage());}
				$rezervirane++;
			}
		}
	}

	//funckija koja vraca sve rezervacije koje je korisnik napravio
	function getMyReservations($username) {
		//dohvacam id_osobe s danim usernameom
		try {
			$db = DB::getConnection();
			$st = $db->prepare('SELECT id_usera FROM projekt_users WHERE username=:username');
			$st->execute(array('username' => $username ));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

		$row = $st->fetch();
		$id_osobe = $row['id_usera'];


		//dohvacam sve rezervacije hotelskih soba gdje je korisnik ostavio komentar/ocjenu
		try {
			$db = DB::getConnection();
			$st1 = $db->prepare('SELECT id_hotela, id_ocjene, komentar, ocjena, dolazak, odlazak FROM 
			projekt_ocjene WHERE id_usera=:id_usera ORDER BY odlazak');
			$st1->execute(['id_usera' => $id_osobe]);
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}


		//dohvacene rezervacije pohranjujem u polje $arr
		$arr = array();
		while($row1 = $st1->fetch()) {
			//dohvacam ime hotela
			try {
				$db = DB::getConnection();
				$st2 = $db->prepare('SELECT ime FROM projekt_hoteli WHERE id_hotela=:id_hotela');
				$st2->execute(['id_hotela' => $row1['id_hotela']]);
			}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

			$row2 = $st2->fetch();

			//dohvacamo tip sobe
			try{
				$db = DB::getConnection();
				$st = $db->prepare( 'SELECT tip FROM projekt_sobe WHERE id_sobe=:id_sobe');
				$st->execute(array( 'id_sobe' => $row1['id_sobe'] ));
			}catch(PDOException $e) { exit( 'PDO error ' . $e->getMessage() );}
	
			$row = $st->fetch();
			$tip = $row['tip'];

			//predzadnji element u polju oznacava je li ta rezervacija vec izvrsena, tj je li korisnik boravio u hotelu u navedenom periodu ili nije
			//1 oznacava da je boravio u hotelu, dok 0 oznacava da nije
			$arr[] = array($row1['id_hotela'], $tip, $row1['komentar'], $row1['ocjena'], $row1['dolazak'], $row1['odlazak'], $row2['ime'], 1, $row1['id_ocjene'], $row1['id_sobe']);
		}


		//dohvacanje svih rezervacija koje su jos u tijeku
		try{
			$db=DB::getConnection();
			$st1=$db->prepare( 'SELECT id_sobe, datum_zauzeca, datum_oslobodenja FROM projekt_sobe_datumi WHERE id_osobe=:id_osobe ORDER BY datum_oslobodenja');
			$st1->execute(['id_osobe' => $id_osobe]);
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

		//provjeravam je li neka od rezervacija zavrsena, tj. je li datum odlaska prosao
		while($row1 = $st1->fetch()) {
			//dohvacam id_hotela u kojem se nalazi soba
			try {
				$db = DB::getConnection();
				$st2 = $db->prepare('SELECT id_hotela FROM projekt_sobe WHERE id_sobe=:id_sobe');
				$st2->execute(['id_sobe' => $row1['id_sobe']]);
			}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

			$row2 = $st2->fetch();

			//dohvacam ime hotela
			try {
				$db = DB::getConnection();
				$st3 = $db->prepare( 'SELECT ime FROM projekt_hoteli WHERE id_hotela=:id_hotela');
				$st3->execute(['id_hotela' => $row2['id_hotela']]);
			}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

			$row3 = $st3->fetch();

			//ako je onda promatranu rezervaciju stavljam u tablicu proslih rezervacija
			if($row1['datum_oslobodenja'] < date("Y-m-d")) {
				try {
					$db = DB::getConnection();
					$st2 = $db->prepare('INSERT INTO projekt_rezervacije (id_osobe, id_hotela, dolazak, odlazak) 
					VALUES (:id_osobe, :id_hotela, :dolazak, :odlazak)');
					$st2->execute(array('id_osobe'=>$id_osobe, 'id_hotela'=>$row2['id_hotela'], 
					'dolazak' => $row1['datum_zauzeca'], 'odlazak' => $row1['datum_oslobodenja']));
				}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

				//moram obrisati tu rezervaciju iz tablice projekt_sobe_datumi
				try {
					$db = DB::getConnection();
					$st2 = $db->prepare('DELETE FROM projekt_sobe_datumi 
					WHERE id_osobe=:id_osobe AND id_sobe=:id_sobe AND datum_zauzeca=:datum_zauzeca AND datum_oslobodenja=:datum_oslobodenja');
					$st2->execute(array('id_osobe'=>$id_osobe, 'id_sobe'=>$row1['id_sobe'], 
					'datum_zauzeca' => $row1['datum_zauzeca'], 
					'datum_oslobodenja' => $row1['datum_oslobodenja']));
				}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}


			}else if($row1['datum_zauzeca'] < date("Y-m-d") && $row1['datum_oslobodenja'] > date("Y-m-d")) {
				//korisnik je dosao u hotel te vise ne moze ponistiti rezervaciju pa za zadnji element stavljamo 1
				$arr[] = array($row2['id_hotela'], NULL, NULL, $row1['datum_zauzeca'], $row1['datum_oslobodenja'], $row3['ime'], 1, NULL);
			}else if($row1['datum_zauzeca'] > date("Y-m-d")) {
				//rezervacija je nekada u buducnosti pa ju korisnik moze ponistiti, dakle za zadnji element stavljam 0
				$arr[] = array($row2['id_hotela'], NULL, NULL, $row1['datum_zauzeca'], $row1['datum_oslobodenja'], $row3['ime'], 0, NULL);
			}
		}
		//dohvacam sve rezervacije hotela za koje korisnik nije ostavio komentar/ocjenu
		try {
			$db = DB::getConnection();
			$st1 = $db->prepare('SELECT id_hotela, dolazak, odlazak FROM projekt_rezervacije WHERE id_osobe=:id_osobe ORDER BY odlazak');
			$st1->execute(['id_osobe' => $id_osobe]);
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}
		//pohranjujem dohvacene rezervacije u polje $arr
		while($row1 = $st1->fetch()) {
			//dohvacam ime hotela
			try {
				$db = DB::getConnection();
				$st3 = $db->prepare( 'SELECT ime FROM projekt_hoteli WHERE id_hotela=:id_hotela');
				$st3->execute(['id_hotela' => $row1['id_hotela']]);
			}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

			$row3 = $st3->fetch();

			//dohvacamo tip sobe
			try {
				$db = DB::getConnection();
				$st = $db->prepare( 'SELECT tip FROM projekt_sobe WHERE id_sobe=:id_sobe');
				$st->execute(array( 'id_sobe' => $row1['id_sobe'] ));
			}catch(PDOException $e) { exit( 'PDO error ' . $e->getMessage() );}
	
			$row = $st->fetch();
			$tip = $row['tip'];

			$arr[] = array($row1['id_hotela'], $tip, NULL, NULL, $row1['dolazak'], $row1['odlazak'], $row3['ime'], 1, NULL, $row1['id_sobe']);
		}
		return $arr;
	}

	//funkcija koja brise rezervaciju
	function deleteReservation($id_hotela, $id_usera, $dolazak, $odlazak) {
		//trazim sve sobe koje je promatrani korisnik rezervirao u promatranom razdoblju
		try {
			$db = DB::getConnection();
			$st = $db->prepare('SELECT id_sobe FROM projekt_sobe_datumi WHERE id_osobe=:id_osobe AND datum_zauzeca=:datum_zauzeca 
			AND datum_oslobodenja=:datum_oslobodenja');
			$st->execute(array('id_osobe'=>$id_usera, 'datum_zauzeca'=>$dolazak, 'datum_oslobodenja'=>$odlazak));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

		while($row = $st->fetch()) {
			//za svaku sobu provjeravam u kojem se hotelu nalazi
			try {
				$db = DB::getConnection();
				$st1 = $db->prepare('SELECT id_hotela FROM projekt_sobe WHERE id_sobe=:id_sobe');
				$st1->execute(array('id_sobe'=>$row['id_sobe']));
			}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}


			$row1 = $st1->fetch();
			//ako se soba nalazi u promatranom hotelu onda brisemo rezervaciju
			if($row1['id_hotela'] === $id_hotela) {
				try {
					$db = DB::getConnection();
					$st2 = $db->prepare('DELETE FROM projekt_sobe_datumi WHERE id_osobe=:id_osobe AND id_sobe=:id_sobe 
					AND datum_zauzeca=:datum_zauzeca AND datum_oslobodenja=:datum_oslobodenja');
					$st2->execute(array('id_osobe'=>$id_usera, 'id_sobe'=>$row['id_sobe'], 'datum_zauzeca' => $dolazak, 
					'datum_oslobodenja' => $odlazak));
				}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}
			}
		}
	}
	//funkcija koja vraca id usera danog username-a
	function getIdByUsername($username) {
		try {
			$db = DB::getConnection();
			$st = $db->prepare('SELECT id_usera FROM projekt_users WHERE username=:username');
			$st->execute(array('username'=>$username));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

		$row = $st->fetch();

		if($row === false)
			return NULL;
		else
			return $row['id_usera'];
	}
	//funkcija koja komentar i ocjenu korisnika za hotel
	function addComment($id_hotela, $id_usera, $username, $dolazak, $odlazak, $ocjena, $komentar) {
		//dohvacam najveci id_ocjene koji se nalazi u tablici projekt ocjene
		try {
			$db = DB::getConnection();
			$st = $db->prepare('SELECT id_ocjene FROM projekt_ocjene');
			$st->execute();
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

		$id_ocjene = 1;
		while($row = $st->fetch()) {
			if($row['id_ocjene'] > $id_ocjene)
				$id_ocjene = $row['id_ocjene'];
		}

		$id_ocjene++;

		try {
			$db = DB::getConnection();
			$st2 = $db->prepare('INSERT INTO projekt_ocjene (id_hotela, id_ocjene, id_usera, username, komentar, ocjena, dolazak, odlazak) 
			VALUES (:id_hotela, :id_ocjene, :id_usera, :username, :komentar, :ocjena, :dolazak, :odlazak)');
			$st2->execute(array('id_hotela'=>$id_hotela, 'id_ocjene'=>$id_ocjene, 'id_usera' => $id_usera, 'username' => $username, 
			'komentar' => $komentar, 'ocjena' => $ocjena, 'dolazak' => $dolazak, 'odlazak' => $odlazak));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}
		//jer je korisnik sada komentirao ostanak u hotelu u zadanom periodu, onda brisem tu rezervaciju iz tablice projekt_rezervacije kako korisnik ne bi mogao
		//vise puta komentirati istu rezervaciju
		try {
			$db = DB::getConnection();
			$st = $db->prepare('DELETE FROM projekt_rezervacije WHERE id_osobe=:id_osobe AND id_hotela=:id_hotela AND dolazak=:dolazak 
			AND odlazak=:odlazak');
			$st->execute(array('id_osobe'=>$id_usera, 'id_hotela'=>$id_hotela, 'dolazak' => $dolazak, 'odlazak' => $odlazak));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}
	}

	function getComment($id_ocjene) {
		try {
			$db = DB::getConnection();
			$st = $db->prepare('SELECT * FROM projekt_ocjene WHERE id_ocjene=:id_ocjene');
			$st->execute(array('id_ocjene'=>$id_ocjene));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

		$row = $st->fetch();
		return $row;
	}

	public function getHotelNameById($id_hotela) {
		try {
			$db = DB::getConnection();
			$st = $db->prepare('SELECT ime FROM projekt_hoteli WHERE id_hotela=:id_hotela');
			$st->execute(array( 'id_hotela'=>$id_hotela));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

		$row = $st->fetch();

		if($row === false)
			return NULL;
		else
			return $row['ime'];
	}

	function editComment($id_ocjene, $komentar, $ocjena) {
		//dohvacam sve podatke za dani id_ocjene
		try {
			$db = DB::getConnection();
			$st = $db->prepare('SELECT id_hotela, id_usera, username, komentar, ocjena, dolazak, odlazak FROM projekt_ocjene 
			WHERE id_ocjene=:id_ocjene');
			$st->execute(array('id_ocjene'=>$id_ocjene));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

		$row = $st->fetch();

		//brisem taj komentar iz tablice projekt_ocjene
		try {
			$db = DB::getConnection();
			$st = $db->prepare('DELETE FROM projekt_ocjene WHERE id_ocjene=:id_ocjene');
			$st->execute(array('id_ocjene'=>$id_ocjene));
		}catch(PDOException $e) {exit( 'PDO error ' . $e->getMessage());}

		//dodajem novi komentar
		try {
			$db = DB::getConnection();
			$st1 = $db->prepare('INSERT INTO projekt_ocjene (id_hotela, id_ocjene, id_usera, username, komentar, ocjena, dolazak, odlazak) 
			VALUES (:id_hotela, :id_ocjene, :id_usera, :username, :komentar, :ocjena, :dolazak, :odlazak)');
			$st1->execute(array('id_hotela'=>$row['id_hotela'], 'id_ocjene'=>$id_ocjene, 'id_usera' => $row['id_usera'], 
			'username' => $row['username'], 'komentar' => $komentar, 'ocjena' => $ocjena, 'dolazak' => $row['dolazak'], 
			'odlazak' => $row['odlazak']));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}
	}

	function deleteComment($id_ocjene, $id_osobe) {
		//dohvacam sve podatke za dani id_ocjene
		try {
			$db = DB::getConnection();
			$st = $db->prepare('SELECT id_hotela, id_usera, username, komentar, ocjena, dolazak, odlazak FROM projekt_ocjene 
			WHERE id_ocjene=:id_ocjene');
			$st->execute(array('id_ocjene'=>$id_ocjene));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

		$row = $st->fetch();

		//brisem taj komentar iz tablice projekt_ocjene
		try {
			$db = DB::getConnection();
			$st = $db->prepare('DELETE FROM projekt_ocjene WHERE id_ocjene=:id_ocjene');
			$st->execute(array('id_ocjene'=>$id_ocjene));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage() );}

		//korisnik je i dalje u tom terminu i u tom hotelu imao rezervaciju samo je sada obrisao komentar i ocjenu
		//dakle moramo tu rezervaciju pohraniti u tablicu projekt_rezervacije
		try {
			$db = DB::getConnection();
			$st1 = $db->prepare('INSERT INTO projekt_rezervacije (id_osobe, id_hotela, dolazak, odlazak) 
			VALUES (:id_osobe, :id_hotela, :dolazak, :odlazak)');
			$st1->execute(array('id_osobe'=>$id_osobe, 'id_hotela'=>$row['id_hotela'], 'dolazak' => $row['dolazak'], 
			'odlazak' => $row['odlazak']));
		}catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}
	}

}
?>
