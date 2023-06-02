Sort by: City, Name, Distance from the city centre, Price
<div id="filters">
<h3 class="header">Sort your search:</h3>

<div class="form">
      				<label for="">Price:</label>
          <label class="decorated-label" id="dl1">1highest to lowest</label>
          <label class="decorated-label" id="dl2">2lowest to highest</label>
				<br>
				<label for="">Rating:</label>
          <label class="decorated-label" id="dl3">3highest to lowest</label>
          <label class="decorated-label" id="dl4">4lowest to highest</label>
				<br>
				<label for="">Distance from the city centre:</label>
          <br>
          <label class="decorated-label" id="dl5">5highest to lowest</label>
          <label class="decorated-label" id="dl6">6lowest to highest</label>
        <br>
				<button type="button" id="sort">Sortiraj</button>
    </div>
</div>
<div id="list">
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/getAvailability'?>">
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
			'<td class="hotel">' .
			'<button type="submit" name="button" value="' . $hotel[0]->id_hotela . '">' . 
            'See availability</button>' .
			'</td>' .
            '</tr>' .
			'</table>';
	}
?>
</form>
</div>