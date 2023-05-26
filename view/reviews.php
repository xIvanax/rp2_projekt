<?php
	foreach($reviewList as $ocjena){
		echo '<table class="listing">' .
			'<tr>' .
			'<td class="komentar">' . $ocjena[0]. '</td>' .
			'</tr>' .
			'<tr>' .
			'<td class="komentar">' . $ocjena[1] . '</td>' .
			'</tr>' .
			'<tr>' .
			'<td class="komentar">' . $ocjena[2] . '</td>' .
			'</tr>' .
			'</table>' .
			'<br>';
	}
?>