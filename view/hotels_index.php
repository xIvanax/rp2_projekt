<?php require_once __SITE_PATH . '/view/_header.php'; ?>
<?php require_once __SITE_PATH . '/view/output.php'; ?>
	<br>
	<h3 class="header">Narrow your search:</h3>
	<form class="form" action="<?php echo __SITE_URL; ?>/index.php?rt=hotels/narrowedSearchResults" method="post">
		<label for="">Select the city you want to stay in:</label>
		<select name="city">
			<option value="Zagreb">Zagreb</option>
			<option value="Split">Split</option>
			<option value="Rijeka">Rijeka</option>
			<option value="Osijek">Osijek</option>
		</select>

		<br>
		<label for="">Type in your lower and upper limit for the price.</label>
		<br>
		<input id="range" type="text" name="lowPrice" placeholder="lower limit in €">
		-
		<input id="range" type="text" name="upPrice" placeholder="upper limit in €">

		<br>
		<label for="">How close to the center do you want to be?</label>
		<input type="text" name="distance" placeholder="distance in km">

		<br>
		<label for="">On a scale from 1 to 10, what range of ratings of the hotel are you ok with?</label>
		<br>
		<input id="range" type="text" name="lowRating" placeholder="1">
		-
		<input id="range" type="text" name="upRating" placeholder="10">

		<br>
		<button type="submit" name="">Filter</button>
	</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
