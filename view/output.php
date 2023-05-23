<?php
			foreach($hotelList as $hotel)
			{
				echo '<table class="listing">' .
						'<tr>' .
						'<td class="hotel"> City: ' . $hotel[0]->grad . '</td><td class="hotel"> Name: ' . $hotel[0]->ime . '</td>' .
						'</tr>' .
						'<tr>' .
						'<td class="hotel"> Distance from the city centre: ' . $hotel[0]->udaljenost_od_centra . '</td><td class="hotel"> Average rating: ' . $hotel[1] . '</td>' .
						'</tr>' .
						'</table>' .
						'<br>';
			}
		 ?>
