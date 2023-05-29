<?php

class HotelsController extends BaseController
{
  public function index()
  {
    $this->registry->template->msg = '';
    $this->registry->template->show('login_index');
  }

  public function removeroom()
  {
    $qs = new HotelService();
    $popis_soba = $qs->getRoomsFromIdHotela($_SESSION["id_hotela"]);
    foreach ($popis_soba as $soba) {
      if(isset($_POST[$soba[0]])){
        $qs->removeroom_service($soba[0]);
        break;
      }
    }
    $this->premiumindex();
  }


  public function premiumindex()
  {
    $qs = new HotelService();
    $this->registry->template->sobe_list = $qs->getRoomsFromIdHotela($_SESSION["id_hotela"]);
    $this->registry->template->title = 'Rooms you are offering';
    $this->registry->template->show('premium_hotels_index');
  }

  public function addeditroom(){
    $qs = new HotelService();
    $temp_list = $qs->getRoomsFromIdHotela($_SESSION["id_hotela"]);
    $is = 0;
    foreach ($temp_list as $temp) {
      if ($temp[0] === $_POST["id_sobe"]){
        $is = 1;
        $qs->addeditroom_service($_POST["id_sobe"], $_POST["tip"], $_POST["cijena"]);
        $this->registry->template->sobe_list = $qs->getRoomsFromIdHotela($_SESSION["id_hotela"]);
        $this->registry->template->title = 'Rooms you are offering';
        $this->registry->template->show('premium_hotels_index');
      }
    }
    $this->registry->template->is = $is;
    if($is === 0){
      $max = $qs->getHighestRoomId();
      $max++;
      $this->registry->template->max = $max;
      $qs->addeditroom_service($max, $_POST["tip"], $_POST["cijena"]);
      $this->registry->template->sobe_list = $qs->getRoomsFromIdHotela($_SESSION["id_hotela"]);
      $this->registry->template->title = 'Rooms you are offering';
      $this->registry->template->show('premium_hotels_index');
    }
  }

  public function loginResults()
  {
    $qs = new HotelService();

    if( !isset( $_POST['username'] ) || !isset( $_POST['password'] ) )
  	{
      $this->registry->template->msg = 'You have to put in your username and password.';

      $this->registry->template->show('login_index');
  	}
    else if( !preg_match( '/^[a-zA-Z]{1,50}$/', $_POST['username'] ) )
  	{
      $this->registry->template->msg = 'The length of your username must be between 1 and 50 characters.';

      $this->registry->template->show('login_index');
  	}
    else if(isset($_POST['registerButton']))//provjeravam jesu li ispunjeni uvjeti za registraciju
    {
      if(!isset($_POST["email"]))
      {
        $this->registry->template->msg = 'You have to put in your email in order to register.';

        $this->registry->template->show('login_index');
      }
      else
      {
        $user = $qs->getIdAndPasswordFromUsername($_POST["username"]);
        $username = $_POST["username"];
        if($user !== null)
        {
          $this->registry->template->msg = 'A user with that username already exists.';

          $this->registry->template->show('login_index');
        }
        else
        {
          if(!filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL))
          {
            $this->registry->template->msg = 'Incorrect email formatting.';

            $this->registry->template->show('login_index');
          }
          else
          {//sad je sve u redu pa  saljem mail user-u
            $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pieces = [];
            $length = rand(1, 20);
            $max = mb_strlen($stringSpace, '8bit') - 1;
            for ($i = 0; $i < $length; ++ $i)
                $pieces[] = $stringSpace[random_int(0, $max)];
            $randomString = implode('', $pieces);

            $qs->insertUnregisteredUser($_POST['email'], $_POST['password'], $randomString, $_POST['username'], $_POST["id_hotela"]);

            $to       = $_POST['email'];
        		$subject  = 'Registration mail for IDC Booking';
        		$message  = "To finish your registration process click on the following link: ";
        		$message .= 'http://' . $_SERVER['SERVER_NAME'] . __SITE_URL . '/index.php?rt=hotels/register&niz=' . $randomString . "\n";
        		$headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
        		            'Reply-To: rp2@studenti.math.hr' . "\r\n" .
        		            'X-Mailer: PHP/' . phpversion();

        		$isOK = mail($to, $subject, $message, $headers);

        		if( !$isOK )
        			exit( 'Gre ka: ne mogu poslati mail. (Pokrenite na rp2 serveru.)' );

            $this->registry->template->show('login_thanks');
          }
        }
      }
    } else if( isset( $_POST["username"] ) && isset($_POST['loginButton']))//provjeravam jesu li ispunjeni uvjeti za login
		{
			$username = $_POST["username"];
      $user = $qs->getIdAndPasswordFromUsername($username);

      if($user === null)//slucaj ako ne valja ili nije unesen username
      {
        $this->registry->template->msg = 'There is no user with that username. Have you registered yet?';

        $this->registry->template->show('login_index');
      }
      else//slucaj ako korisnik jos nije zavrsio registraciju
      {
        $hash = $user['password_hash'];
        if($user['has_registered'] !== "1")
        {
          $this->registry->template->msg = 'You are not registered yet. Check your email!';

          $this->registry->template->show('login_index');
        }
        else if(password_verify($_POST['password'], $hash))
        {
          $_SESSION[ 'username' ] = $username;
          $_SESSION[ 'id' ] = $user['id_usera'];
          $_SESSION["id_hotela"] = $_POST["id_hotela"];

          $this->registry->template->title = 'Available Hotels';
          $this->registry->template->username = $_SESSION['username'];
          $this->registry->template->id_hotela = $_SESSION['id_hotela'];

          $qs2 = new HotelService();
      		$this->registry->template->hotelList = $qs2->getAvailableHotels();
          if($_POST["id_hotela"] === "-1"){
      		  $this->registry->template->show('hotels_index');
          }
          else if ($qs->getHotelIdFromUsername($_POST["username"]) == $_POST["id_hotela"]){//upute za glupog kikija tu gledaj inace
            $this->registry->template->sobe_list = $qs->getRoomsFromIdHotela($_SESSION["id_hotela"]);
            $this->registry->template->title = 'Rooms you are offering';
            $this->registry->template->show('premium_hotels_index');
          }
        }
        else
        {
          $this->registry->template->msg = 'Incorrect username or password - try again.';

          $this->registry->template->show('login_index');
        }
      }
		}
		else
		{
      $this->registry->template->title = 'Incorrect password or username!';
			header( 'Location: ' . __SITE_URL . '/index.php?rt=hotels/login' );
			exit;
		}
  }

  public function register()
	{
    $qs = new HotelService();

		if(!isset($_GET['niz']) || !preg_match('/^[a-zA-Z0-9]{1,20}$/', $_GET['niz'])){
      if(!isset($_GET['niz']))
        exit("ne vidim niz");
      else
        exit('Ne to ne valja s nizom.');
    }

    $qs->register($_GET['niz']);

    $this->registry->template->show('login_registrationcomplete');
	}

	public function availableHotels(){
		$qs = new HotelService();

		$this->registry->template->title = 'Available hotels';

		$this->registry->template->hotelList = $qs->getAvailableHotels();

    $this->registry->template->show('hotels_index');
  }

  public function narrowedSearch()//prikazuje pocetnu stranicu s opcijama za su avanje izbora hotela
  {
    $qs = new HotelService();

    $this->registry->template->title = 'Search for hotels with your preferences';
    $this->registry->template->username = $_SESSION['username'];

    $this->registry->template->hotelList = $qs->getAvailableHotels();

		$this->registry->template->show('hotels_index');
  }

  public function narrowedSearchResults()//prikazuje su eni izbor hotela
  {
    $qs = new HotelService();

		if(empty($_POST['city']))
		{
			header('Location: index.php?rt=hotels/narrowedSearch');
			exit();
		}
    $city = $_POST['city']; //po defaultu je odabran Zagreb
    //sve ostale opcije su inicijalno postavljene na min/max vrijednosti
    echo "city = ";
    echo $city;
    echo "<br>";
    $lowPrice;
    if(strlen($_POST['lowPrice']) === 0)
      $lowPrice = 0;
    else
      $lowPrice = $_POST['lowPrice'];
    echo "lowprice = ";
    echo $lowPrice;
    echo "<br>";
    $upPrice;
    if(strlen($_POST['upPrice']) === 0)
      $upPrice = PHP_INT_MAX;
    else
      $upPrice = $_POST['upPrice'];
      echo "upprice = ";
      echo $upPrice;
      echo "<br>";
    $distance;
    if(strlen($_POST['distance']) === 0)
      $distance = PHP_FLOAT_MAX;
    else{
      $distance = (double)$_POST['distance'];
    }
    echo "distance = ";
    echo $distance;
    echo "<br>";
    $lowRating;
    if(strlen($_POST['lowRating']) === 0)
      $lowRating = 0;
    else
      $lowRating = $_POST['lowRating'];
      echo "lowrating = ";
      echo $lowRating;
      echo "<br>";
    $lowRating;
    if(strlen($_POST['upRating']) === 0)
      $upRating = 10;
    else
      $upRating = $_POST['upRating'];
      echo "uprating = ";
      echo $upRating;
      echo "<br>";
    $this->registry->template->title = 'A list of hotels with the selected preferences';
    $this->registry->template->username = $_SESSION['username'];
    $this->registry->template->hotelList = $qs->getNarrowedHotels($city, $lowPrice, $upPrice, $distance, $lowRating, $upRating);

		$this->registry->template->show('hotels_narrowed');
  }

  //prikazuje sve slobodne sobe za hotel zadanog id-a
  public function getAvailability(){ //prikazuje koje vrste soba su u ponudi hotela
    $hs=new HotelService();
    $this->registry->template->title='Available rooms';
    $this->registry->template->roomsList=$hs->getRoomTypeFromHotelId($_POST['button']);
    $_SESSION['hotelId']=$_POST['button'];
    $this->registry->template->hotelId=$_POST['button'];
    $this->registry->template->reviewList=$hs->getReviewsForHotelById($_POST['button']);
    $this->registry->template->show('hotels_availability');
  }

  public function availableRooms(){ //koliko je soba svake vrste dostupno u promatranom periodu
    $hs=new HotelService();
    $this->registry->template->title='Available rooms';

    $_SESSION['dolazak']=$_POST['date_yr'].'-'.$_POST['date_mo'] . '-'. $_POST['date_dy'];
    $_SESSION['odlazak']=$_POST['date_yr_end'].'-'.$_POST['date_mo_end'] . '-'. $_POST['date_dy_end'];
    $this->registry->template->roomsList=$hs->getAvailableRooms($_SESSION['hotelId'], $_SESSION['dolazak'],$_SESSION['odlazak']);
    $this->registry->template->reviewList=$hs->getReviewsForHotelById($_SESSION['hotelId']);
    $this->registry->template->show('hotels_availability');

  }

  public function bookRoom(){ //rezervacija soba
    $hs=new HotelService();
    $this->registry->template->title='Book rooms';

    //za svaki tip soba rezerviramo odgovarajuci broj soba
    $rooms=$hs->getAvailableRooms($_SESSION['hotelId'], $_SESSION['dolazak'],$_SESSION['odlazak']);
    foreach($rooms as $room){
      $popis=explode(' ', $room[0]);
      $name=implode('_',$popis);
      $hs->reserveRoom($room[0], $_POST[$name], $_SESSION['dolazak'], $_SESSION['odlazak'], $_SESSION['username']);
    }
    $this->registry->template->show('successfulRegistration');
  }

  public function userReservations(){ //prikazuju se rezervacije korisnika, i one prosle (s komentarima i one bez njih) te buduce 
    $hs=new HotelService();
    $this->registry->template->title='Reservations';
    $this->registry->template->commentsList=$hs->getMyReservations($_SESSION['username']);
    $this->registry->template->show('userReservations');
  }

  public function deleteReservation(){ //brise neku buducu rezervaciju
    $hs=new HotelService();
    $this->registry->template->title='Reservations';

    $id_usera=$hs->getIdByUsername($_SESSION['username']);
    $popis=explode('|', $_POST['deleteReservation']);
    $hs->deleteReservation($popis[0], $id_usera, $popis[1], $popis[2]);
    
    $this->registry->template->commentsList=$hs->getMyReservations($_SESSION['username']);
    $this->registry->template->show('userReservations');
  }

  public function addCommentAndRating(){ //vodi na stranicu gdje korisnik moze ostaviti komentar i ocjenu
    $this->registry->template->title='Add comment and rating';
    $this->registry->template->msg='';
    $popis=explode('|', $_POST['enterComment']);
    $this->registry->template->idHotela=$popis[0];
    $this->registry->template->imeHotela=$popis[1];
    $this->registry->template->dolazak=$popis[2];
    $this->registry->template->odlazak=$popis[3];

    $this->registry->template->show('rateAndComment');
  }

  public function addCommentAndRatingResult(){ //nakon sto korisnik unese komentar i ocjenu
    $hs=new HotelService();

    $popis=explode('|', $_POST['share']);
      $this->registry->template->imeHotela=$popis[0];
      $this->registry->template->idHotela=$popis[1];
      $this->registry->template->dolazak=$popis[2];
      $this->registry->template->odlazak=$popis[3];
  
      $id_usera=$hs->getIdByUsername($_SESSION['username']);

    if($_POST['rating']==="" || $_POST['comment']===""){ //moraju biti uneseni i ocjena i komentar
      $this->registry->template->title='Add comment and rating';
      $this->registry->template->msg = 'Please enter both rating and comment.';
      $this->registry->template->show('rateAndComment');
    }else{
      $hs->addComment($popis[1], $id_usera, $_SESSION['username'], $popis[2], $popis[3], $_POST['rating'], $_POST['comment']);

      $this->registry->template->title='Reservations';
      $this->registry->template->commentsList=$hs->getMyReservations($_SESSION['username']);
      $this->registry->template->show('userReservations');
    }

  }

  public function editCommentAndRating(){ //vodi na stranicu gdje korisnik moze urediti komentar i ocjenu
    $hs=new HotelService();
    $this->registry->template->title='Edit comment and rating';

    $ocjena=$hs->getComment($_POST['editComment']);
    $imeHotela=$hs->getHotelNameById($ocjena['id_hotela']);
    $this->registry->template->ocjena=$ocjena['ocjena'];
    $this->registry->template->komentar=$ocjena['komentar'];
    $this->registry->template->idHotela=$ocjena['id_hotela'];
    $this->registry->template->imeHotela=$imeHotela;
    $this->registry->template->dolazak=$ocjena['dolazak'];
    $this->registry->template->odlazak=$ocjena['odlazak'];
    $this->registry->template->idOcjene=$ocjena['id_ocjene'];

    $this->registry->template->show('editComment');
  }

  public function editCommentAndRatingResults(){ //vodi na stranicu gdje korisnik moze urediti komentar i ocjenu
    $hs=new HotelService();
    $this->registry->template->title='Edit comment and rating';

    if($_POST['rating']==="" || $_POST['comment']===""){ //moraju biti uneseni i ocjena i komentar
      $this->registry->template->msg = 'Please enter both rating and comment.';
      $this->registry->template->show('editComment');
    }else{
      $hs->editComment($_POST['share'], $_POST['comment'], $_POST['rating']);
      $this->registry->template->title='Reservations';
      $this->registry->template->commentsList=$hs->getMyReservations($_SESSION['username']);
      $this->registry->template->show('userReservations');
    }

  }

  public function deleteComment(){ //vodi na stranicu gdje korisnik moze urediti komentar i ocjenu
    $hs=new HotelService();
    $this->registry->template->title='Reservations';

    $id_usera=$hs->getIdByUsername($_SESSION['username']);
    $hs->deleteComment($_POST['deleteComment'], $id_usera);
    
    $this->registry->template->commentsList=$hs->getMyReservations($_SESSION['username']);
    $this->registry->template->show('userReservations');

  }

}
?>
