<?php require_once __SITE_PATH . '/view/_header.php'; ?>
	<!-- <h2><?php echo $msg; ?></h2>
	<br> -->
	<form class="form" action="<?php echo __SITE_URL; ?>/index.php?rt=hotels/editCommentAndRatingResults" method="post">
		<label for="">Hotel: <?php echo $imeHotela; ?></label>
        <br>
        <label for="">Check-in: <?php echo $dolazak; ?></label>
        <br>
        <label for="">Check-out: <?php echo $odlazak; ?></label>
		<br>
        <br>
        <label for="">On a scale of 1-10, how would you rate your experience?</label>
        <br>
        <textarea type="text" name="rating" rows="1" cols="130"> <?php echo $ocjena ?></textarea>

		<br>
		<label for="">Add your comment</label>
		<br>
		<textarea type="text" name="comment" rows="4" cols="130"> <?php echo $komentar ?></textarea>

		<br>
		<?php
			echo '<button type="submit" name="share" value="'. $idOcjene . '">'. 'Add comment and rating</button>';
		?>
	</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>