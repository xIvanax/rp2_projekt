<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>IDC Booking</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
	<script src="https://kit.fontawesome.com/512d1b1458.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="navbar">
		<h1 class="mainHeader">IDC Booking</h1>
		<ul>
			<li><a class="a" href="<?php echo __SITE_URL; ?>/index.php?rt=hotels/availableHotels"><i class="fas fa-house"></i> Available hotels</a></li>
			<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=hotels/premiumindex">Your offers</a></li>
			<li id="logout"><a href="<?php echo __SITE_URL; ?>/index.php?rt=hotels">Logout</a></li>
			<li><i class="fas fa-user"> </i><?php
					echo " " . htmlentities($_SESSION["username"], ENT_QUOTES);?></li>
		</ul>
	</div>
	<div class="container">
		<h3 class="header"><?php echo $title; ?></h3>
