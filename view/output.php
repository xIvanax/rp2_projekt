Sort by: City, Name, Distance from the city centre, Price
<div id="list">
<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/getAvailability'?>">
<?php
	foreach($hotelList as $hotel){
		echo '<table class="listing">' .
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