<?php require_once __SITE_PATH . '/view/_header.php'; ?>

	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/availableRooms'?>">
		<div class="date-pickers">
			<div class="wrapper">
				<div class="box1">

			<label name="date" class="calLab">Check-in date</label>
			<input name="start" type="text" id="dateInput1" placeholder="Check-in date" readonly>
			<div id="datePicker1" class="datePicker">
				<span class="close">X</span>
				<div id="calendarContainer1"></div>
			</div>
</div>
			<?php //require_once __SITE_PATH . '/view/selectStartDate.php'; ?>
<div class="box2">


			<label name="date" class="calLab">Check-out date</label>
			<input name="end" type="text" id="dateInput2" placeholder="Check-out date" readonly>
			<div id="datePicker2" class="datePicker">
				<span class="close">X</span>
				<div id="calendarContainer2"></div>
			</div>

			</div>
			<button name="apply" type="submit" id="apply">Show available hotels</button>
		</div>
	</div>
				<?php //require_once __SITE_PATH . '/view/selectEndDate.php'; ?>
	</form>
<br>
	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/bookRoom'?>">
		<?php require_once __SITE_PATH . '/view/rooms_index.php'; ?>
		<button type="submit" name="reserve">Reserve</button>
	</form>

<br>
<br>
<label name="reviews">Reviews</label>
<?php require_once __SITE_PATH . '/view/reviews.php'; ?>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
