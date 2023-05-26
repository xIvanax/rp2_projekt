<?php require_once __SITE_PATH . '/view/_header.php'; ?>

	<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/availableRooms'?>">
		<label name="date">Check-in date</label>
		<?php require_once __SITE_PATH . '/view/selectStartDate.php'; ?>
		<label name="date">Check-out date</label>
		<?php require_once __SITE_PATH . '/view/selectEndDate.php'; ?>
		<button name="apply" type="submit">Apply</button>
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
