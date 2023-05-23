<?php require_once __SITE_PATH . '/view/_header.php'; ?>
<?php require_once __SITE_PATH . '/view/output.php'; ?>
	<br>
	<h3 class="header">Narrow your search:</h3>
	<form class="" action="<?php echo __SITE_URL; ?>/index.php?rt=hotels/narrowedSearch" method="post">
		Select the city you want to stay in:
		<select name="city">
			<option value="Zagreb">Zagreb</option>
			<option value="Zagreb">Split</option>
			<option value="Zagreb">Rijeka</option>
			<option value="Zagreb">Osijek</option>
		</select>
		<br>
		Type in your lower and upper limit for the price.
		<input type="text" name="lowPrice">
		-
		<input type="text" name="upPrice">
		<br>
		How close to the center do you want to be?
		<input type="text" name="distance">
		<br>
		On a scale from 1 to 10, what range of ratings of the hotel are you ok with?
		
		<input type="text" name="lowRating">
		-
		<input type="text" name="upRating">
		<button type="submit" name="">Filter</button>
	</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
