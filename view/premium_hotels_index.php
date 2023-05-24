<?php require_once __SITE_PATH . '/view/premium_header.php'; ?>

  <br>
  <?php
  echo "<table>";
  foreach ($sobe_list as $soba) {
    echo "<tr>";

    echo "<td>";
    echo  "id sobe: " . $soba[0];
    echo "</td>";

    echo "<td>";
    echo  "tip sobe: " . $soba[1];
    echo "</td>";

    echo "<td>";
    echo  "cijena sobe: " . $soba[2];
    echo "</td>";

    echo "<td>";

    echo '<form class="" action="index.php?rt=hotels/removeroom" method="post">';
    echo '<input type="submit" name="' . $soba[0] . '" value="X">';
    echo '</form>';

    echo "</td>";

    echo "</tr>";
  }
  echo "</table>";
  echo "<br><br><br>";
  if (isset($is) && $is === 0){
    echo "Room ID taken, given id: " . $max;
    echo "<br>";
  }
 ?>
	<br>
	<form class="" action="<?php echo __SITE_URL; ?>/index.php?rt=hotels/addeditroom" method="post">
		<br>
		Add/Edit room: <br>
		Room id: <input type="text" name="id_sobe"> <br>
    Room type: <input type="text" name="tip"> <br>
		Room price: <input type="text" name="cijena"> <br>
		<button type="submit" name="">Add room</button>
	</form>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
