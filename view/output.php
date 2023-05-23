<?php
			foreach($hotelList as $hotel)
			{
				echo '<table class="listing">' .
						'<tr>' .
						'<td class="hotel"> Grad: ' . $hotel[0]->grad . '</td><td class="hotel"> Ime hotela: ' . $hotel[0]->ime . '</td>' .
						'</tr>' .
						'<tr>' .
						'<td class="hotel"> Udaljenost od centra: ' . $hotel[0]->udaljenost_od_centra . '</td><td class="hotel"> Prosječni rating hotela: ' . $hotel[1] . '</td>' .
						'</tr>' .
						'</table>' .
						'<br>';
			}
		 ?>
