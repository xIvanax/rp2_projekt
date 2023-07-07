<div id="filters">
  <h3 class="header">Sort your search:</h3>
  <div class="form">
    <label for="">Price:</label>
    <label class="decorated-label" id="dl1">highest to lowest</label>
    <label class="decorated-label" id="dl2">lowest to highest</label>
    <br>
    <label for="">Rating:</label>
    <label class="decorated-label" id="dl3">highest to lowest</label>
    <label class="decorated-label" id="dl4">lowest to highest</label>
    <br>
    <label for="">Distance from the city centre:</label>
    <br>
    <label class="decorated-label" id="dl5">highest to lowest</label>
    <label class="decorated-label" id="dl6">lowest to highest</label>
    <br>
    <button type="button" id="sort">Sortiraj</button>
  </div>
  <br>
  <h3 class="header">Narrow your search:</h3>
	<div id="narrow">
		<label for="">Select the city you want to stay in:</label>
		<select name="city" id="city">
			<option value="Zagreb">Zagreb</option>
			<option value="Split">Split</option>
			<option value="Rijeka">Rijeka</option>
			<option value="Osijek">Osijek</option>
		</select>

		<br>
		<label for="">Type in your lower and upper limit for the price.</label>
		<br>
		<input class="rangeInputs" type="text" name="lowPrice" placeholder="lower limit in €">
		-
		<input class="rangeInputs" type="text" name="upPrice" placeholder="upper limit in €">

		<br>
		<label for="">How close to the center do you want to be?</label>
		<input type="text" name="distance" placeholder="distance in km" id="distanceFilter">

		<br>
		<label for="">On a scale from 1 to 10, what range of ratings of the hotel are you ok with?</label>
		<br>
		<input class="rangeInputs" type="text" name="lowRating" placeholder="1">
		-
		<input class="rangeInputs" type="text" name="upRating" placeholder="10">

		<br>
		<button type="button" id="poseban">Filter</button>
		<a class="a" href="<?php echo __SITE_URL; ?>/index.php?rt=hotels/availableHotels"><button type="button">Remove filters</button></a>
	</div>
</div>
<div id="list">
  <form id="forma" method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/getAvailability'?>">
  <?php
  	foreach($hotelList as $hotel){
  		echo '<table class="listingSort">' .
  			'<tr>' .
  			'<td class="hotel"> City: ' . $hotel[0]->grad . '</td>' .
  			'</tr>' .
  			'<tr>' .
  			'<td class="hotel"> Name: ' . $hotel[0]->ime . '</td>' .
  			'</tr>' .
  			'<tr>' .
  			'<td class="hotel"> Distance from the city centre: ' . $hotel[0]->udaljenost_od_centra . 'km</td>' .
  			'</tr>' .
  			'<tr>' .
  			'<td class="hotel"> Average rating: ' . $hotel[1] . '</td>' .
  			'</tr>'.
        '<tr>' .
        '<td class="hotel"> Lowest price: ' . $hotel[2] . ' €</td>' .
  			'</tr>'.
  			'<tr>' .
  			'<td class="hotel">' .
  			'<button type="submit" class="availabilityButton" name="button" value="' . $hotel[0]->id_hotela . '">' .
              'See availability</button>' .
  			'</td>' .
              '</tr>' .
  			'</table>';
  	}
  ?>
  </form>
</div>
