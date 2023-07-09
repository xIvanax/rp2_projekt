<?php function debug()
    {
        echo '<pre>';

        echo '$_POST = '; print_r( $_POST );
        echo '$_SESSION = '; print_r( $_SESSION );

        echo '</pre>';
    } ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>IDC Booking</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
	<script src="https://kit.fontawesome.com/512d1b1458.js" crossorigin="anonymous"></script>
	<script src="bookingScript.js"></script>
	<script src="premiumSort.js"></script>
<body>
	<?php debug(); ?>
	<div class="navbar">
		<h1 class="mainHeader">IDC Booking</h1>
		<ul>
			<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=hotels/premiumindex"><i class="fas fa-book"></i>Your offers</a></li>
			<li id="logout"><a href="<?php echo __SITE_URL; ?>/index.php?rt=hotels"><i class="fas fa-lock"></i>Logout</a></li>
			<li><i class="fas fa-user"> </i><?php
					echo " " . htmlentities($_SESSION["username"], ENT_QUOTES);?></li>
		</ul>
	</div>
	<div class="container">
		<h3 class="header"><?php echo $title; ?></h3>
