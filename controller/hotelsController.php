<?php

class HotelsController extends BaseController
{
  public function index()
  {
    $this->registry->template->msg = '';
    $this->registry->template->show('login_index');
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
    else if(isset($_POST['registerButton'])) //pokušava se registrirati
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
        if($user !== null)//pronašla usera u bazi
        {
          $this->registry->template->msg = 'A user with that username already exists.';

          $this->registry->template->show('login_index');
        }
        else//ako je user null sigurno ga moram registrirat
        {
          if(!filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL))
          {
            $this->registry->template->msg = 'Incorrect email formatting.';

            $this->registry->template->show('login_index');
          }
          else
          {
            //moram generirati registration_sequence
            $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pieces = [];
            $length = rand(1, 20);
            $max = mb_strlen($stringSpace, '8bit') - 1;
            for ($i = 0; $i < $length; ++ $i)
                $pieces[] = $stringSpace[random_int(0, $max)];
            $randomString = implode('', $pieces);

            $qs->insertUnregisteredUser($_POST['email'], $_POST['password'], $randomString, $_POST['username']);
            //sad šaljem mail
            $to       = $_POST['email'];
        		$subject  = 'Registration mail for IDC Booking';
        		$message  = "To finish your registration process click on the following link: ";
        		$message .= 'http://' . $_SERVER['SERVER_NAME'] . __SITE_URL . '/index.php?rt=hotels/register&niz=' . $randomString . "\n";
        		$headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
        		            'Reply-To: rp2@studenti.math.hr' . "\r\n" .
        		            'X-Mailer: PHP/' . phpversion();

        		$isOK = mail($to, $subject, $message, $headers);

        		if( !$isOK )
        			exit( 'Greška: ne mogu poslati mail. (Pokrenite na rp2 serveru.)' );

            $this->registry->template->show('login_thanks');
          }
        }
      }
    }
		else if( isset( $_POST["username"] ) && isset($_POST['loginButton']))
		{
			$username = $_POST["username"];
      $user = $qs->getIdAndPasswordFromUsername($username);

      if($user === null)
      {
        $this->registry->template->msg = 'There is no user with that username. Have you registered yet?';

        $this->registry->template->show('login_index');
      }
      else
      {
        $hash = $user['password_hash'];
        if($user['has_registered'] !== "1")
        {
          $this->registry->template->msg = 'You are not registered yet. Check your email!';

          $this->registry->template->show('login_index');
        }
        else if(password_verify($_POST['password'], $hash))
        {
          // Stavi ga u $_SESSION tako da uvijek prikazujemo njegove podatke
          $_SESSION[ 'username' ] = $username;
          $_SESSION[ 'id' ] = $user['id'];

          $this->registry->template->title = 'Available Hotels';
          $this->registry->template->username = $_SESSION['username'];

          $qs2 = new HotelService();
      		$this->registry->template->hotelList = $qs2->getAvailableHotels();

      		$this->registry->template->show('hotels_index');
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
			// Nema druge opcije -- nešto ne valja. Preusmjeri na login stranicu.
      $this->registry->template->title = 'Incorrect password or username!';
			header( 'Location: ' . __SITE_URL . '/index.php?rt=hotels/login' );
			exit;
		}
  }

  public function register()
	{
    $qs = new HotelService();

		if( !isset( $_GET['niz'] ) || !preg_match( '/^[a-zA-Z0-9]{1,20}$/', $_GET['niz'] ) ){
      if(!isset($_GET['niz']))
        exit("ne vidim niz");
      else
        exit( 'Nešto ne valja s nizom.' );
    }
		$db = DB::getConnection();

		try
		{
			$st = $db->prepare( 'SELECT * FROM projekt_useri WHERE registration_sequence=:registration_sequence' );
			$st->execute( array( 'registration_sequence' => $_GET['niz'] ) );
		}
		catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

		$row = $st->fetch();

		if( $st->rowCount() !== 1 )
			exit( 'Taj registracijski niz ima ' . $st->rowCount() . 'korisnika, a treba biti točno 1 takav.' );
		else
		{
			try
			{
				$st = $db->prepare( 'UPDATE projekt_useri SET has_registered=1 WHERE registration_sequence=:registration_sequence' );
				$st->execute( array( 'registration_sequence' => $_GET['niz'] ) );
			}
			catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
		}

    $this->registry->template->show('login_registrationcomplete');
	}
  /*************************************************/
	public function availableHotels()
	{
		$qs = new HotelService();

		$this->registry->template->title = 'Available hotels';

		$this->registry->template->hotelList = $qs->getAvailableHotels();

    $this->registry->template->show('hotels_index');
  }
?>
