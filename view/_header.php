<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>IDC Booking</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>
	<h1 class="header">IDC Booking</h1>
	<br>
	<br>
	<br>
	<nav>
		<ul id="navigationBarList">
			<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=hotels/availableHotels">Available hotels</a></li>
			<li id="logout"><a href="<?php echo __SITE_URL; ?>/index.php?rt=hotels">Logout</a></li>
			<li><?php
				echo "@" . htmlentities($username, ENT_QUOTES);
				echo "\n";
				?></li>
		</ul>
	</nav>

	<h3 class="header"><?php echo $title; ?></h3>
