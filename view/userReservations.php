<?php require_once __SITE_PATH . '/view/_header.php'; ?>
<?php
	foreach($commentsList as $comment){
		echo '<table class="listing">' .
			'<tr>' .
			'<td class="hotel"> Hotel: ' . $comment[5] . '</td>' .
			'</tr>' .
			'<tr>' .
			'<td class="hotel">' . "Check-in: " . $comment[3] . '</td>' .
			'</tr>' . '<tr>' .
			'<td class="hotel">' . "Check-out: " . $comment[4] .'</td>' .
			'</tr>';
			if($comment[6]===0){ //rezervacija je nekada u buducnosti pa ju korisnik jos moze ponistiti
				?>
				<tr>
				<td class="hotel">
				<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/deleteReservation'?>">
				<?php
				echo '<button type="submit" name="deleteReservation" value="'. $comment[0] . "|" . $comment[3] . "|" . $comment[4] . '">'. 'Delete Reservation</button>';
				?>
				</form>
				</td>				
				</tr>
				<?php
			}
			else{
				if($comment[2]!==NULL && $comment[1]!==NULL){//postoji komentar i ocjena
					echo '<tr>' .
					'<td class="hotel"> Rating:' . $comment[2] . '</td>' .
					'</tr>'. '<tr>' .
					'<td class="hotel">' . $comment[1] . '</td>' .
					'</tr>';
					?>
						<tr>
						<td class="hotel">
						<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/editCommentAndRating'?>">
						<?php
							echo '<button type="submit" name="editComment" value="'. $comment[7] . '">'. 'Edit comment and rating</button>';
						?>
						</form>
						</td>				
						</tr>
						<tr>
						<td class="hotel">
						<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/deleteComment'?>">
						<?php
							echo '<button type="submit" name="deleteComment" value="'. $comment[7] . '">'. 'Delete</button>';
						?>
						</form>
						</td>				
						</tr>
					<?php
				}else if($comment[2]===NULL && $comment[1]===NULL){
					echo '<tr>' .
					'<td class="hotel">' . $comment[1] . '</td>' .
					'</tr>';
					?>
						<tr>
						<td class="hotel">
						<form method="post" action="<?php echo __SITE_URL . '/index.php?rt=hotels/addCommentAndRating'?>">
						<?php
							echo '<button type="submit" name="enterComment" value="'. $comment[0] . '|' .$comment[5] . "|" . $comment[3] . "|" . $comment[4] . '">'. 'Add comment and rating</button>';
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