<?php require_once __SITE_PATH . '/view/_header.php'; ?>
<?php
	foreach($commentsList as $comment){
		echo '<table class="listing">' .
			'<tr>' .
			'<td class="hotel"> Hotel: ' . $comment[6] . '</td>' .
			'</tr>' .
			'<tr>' .
			'<td class="hotel"> Room type: ' . $comment[1] . '</td>' .
			'</tr>' .
			'<tr>' .
			'<td class="hotel">' . "Check-in: " . $comment[4] . '</td>' .
			'</tr>' . '<tr>' .
			'<td class="hotel">' . "Check-out: " . $comment[5] .'</td>' .
			'</tr>';
			if($comment[7]===0){ //rezervacija je nekada u buducnosti pa ju korisnik jos moze ponistiti
				?>
				<tr>
				<td class="hotel">
				<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/deleteReservation'?>">
				<?php
				echo '<button type="submit" name="deleteReservation" value="'. $comment[0] . "|" . $comment[4] . "|" . $comment[5] . '">'. 'Delete Reservation</button>';
				?>
				</form>
				</td>				
				</tr>
				<?php
			}
			else{
				if($comment[3]!==NULL && $comment[2]!==NULL){//postoji komentar i ocjena
					echo '<tr>' .
					'<td class="hotel"> Rating:' . $comment[3] . '</td>' .
					'</tr>'. '<tr>' .
					'<td class="hotel">' . $comment[2] . '</td>' .
					'</tr>';
					?>
						<tr>
						<td class="hotel">
						<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/editCommentAndRating'?>">
						<?php
							echo '<button type="submit" name="editComment" value="'. $comment[8] . '">'. 'Edit comment and rating</button>';
						?>
						</form>
						</td>				
						</tr>
						<tr>
						<td class="hotel">
						<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/deleteComment'?>">
						<?php
							echo '<button type="submit" name="deleteComment" value="'. $comment[8] . '">'. 'Delete</button>';
						?>
						</form>
						</td>				
						</tr>
					<?php
				}else if($comment[3]===NULL && $comment[2]===NULL){ //rezervacija je u proslosti, ali korisnik nije ostavio ocjenu i komentar
					echo '<tr>' .
					'<td class="hotel">' . $comment[2] . '</td>' .
					'</tr>';
					?>
						<tr>
						<td class="hotel">
						<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/addCommentAndRating'?>">
						<?php
							echo '<button type="submit" name="enterComment" value="'. $comment[0] . "|" . $comment[9] . '|' .$comment[6] . "|" . $comment[4] . "|" . $comment[5] . '">'. 'Add comment and rating</button>';
						?>
						</form>
						</td>				
						</tr>
					<?php		
				}

			}
			'</table>' .
				'<br>';
	}
?>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>