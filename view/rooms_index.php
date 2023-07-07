<?php
	echo '<table class="listing">' .
		'<tr>' .
		'<td class="hotel">' . 'Type of room' . '</td>' .
		'<td class="hotel">' . 'Price'.'</td>' .
		'<td class="hotel" id="brojSoba">' . 'Select rooms' .'</td>' .
		'</tr>' ;
		foreach($roomsList as $room){
			echo '<tr>' .
			'<td class="hotel">' . $room[0] . '</td>' .
			'<td class="hotel">' . $room[1] . "€" .'</td>' .
			'<td class="hotel" id="brojSoba">'.
			'<select name="' . $room[0] . '">';
				for($i=0; $i<$room[2]+1; $i++)
					echo '<option value="'.$i.'">'. $i .'</option>';
			'</select>' . '</td>' . '</tr>';
		}
			
	echo '</table>';
?> 