<?php require_once __SITE_PATH . '/view/_header.php'; ?>
<br>
	<br>
	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/availableRooms'?>">
		<div class="date-pickers">
			<div class="wrapper">
				<div class="box1">
					<label name="date" class="calLab">Check-in date</label>
					<input name="start" type="text" id="dateInput1" placeholder="<?php echo $placeholder1 ?>" readonly>
					<div id="datePicker1" class="datePicker">
						<span class="close"><span id="x">X</span></span>
						<div id="calendarContainer1"></div>
					</div>
				</div>
				<div class="box2">
					<label name="date" class="calLab">Check-out date</label>
					<input name="end" type="text" id="dateInput2" placeholder="<?php echo $placeholder2 ?>" readonly>
					<div id="datePicker2" class="datePicker">
						<span class="close"><span id="x">X</span></span>
						<div id="calendarContainer2"></div>
					</div>
				</div>
			<br>
			<button name="apply" type="submit" id="apply">Show available rooms</button>
		</div>
	</div>
	</form>
	<h2><?php echo $msg; ?></h2>
	<br>
	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/bookRoom'?>">
		<?php require_once __SITE_PATH . '/view/rooms_index.php'; ?>
		<button type="submit" name="reserve">Reserve</button>
	</form>
<br>
<br>
<h3 class="header">Reviews</h3>
<?php require_once __SITE_PATH . '/view/reviews.php'; ?>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
