<?php require_once __SITE_PATH . '/view/premium_header.php'; ?>
<div id="filters">
  <h3 class="header">Sort your search:</h3>
  <div id="premSort">
    <div class="form">
      <label for="">Price:</label>
      <label class="pdecorated-label" id="dl1">highest to lowest</label>
      <label class="pdecorated-label" id="dl2">lowest to highest</label>
      <br>
      <label for="">Type:</label>
      <label class="pdecorated-label" id="dl3">A-Z</label>
      <label class="pdecorated-label" id="dl4">Z-A</label>
      <br>
      <button type="button" id="pSort">Sortiraj</button>
    </div>
  </div>
  <h3 class="header">Add/Edit room:</h3>
  <div id="premNarrow">
  	<form class="form" action="<?php echo __SITE_URL; ?>/index.php?rt=hotels/addeditroom" method="post">
  		<label for="">Room id: </label><input type="text" name="id_sobe"> <br>
      <label for="">Room type: </label><input type="text" name="tip"> <br>
  		<label for="">Room price: </label><input type="text" name="cijena"> <br>
  		<button type="submit" name="">Add/Edit room</button>
  	</form>
  </div>
</div>
  <div id="premiumList">
  <?php
  echo '<table id="premiumSort">';
  echo '<tr>';
  echo '<th>id sobe</th>';
  echo '<th>tip sobe</th>';
  echo '<th>cijena sobe (€)</th>';
  echo '</tr>';

  foreach ($sobe_list as $soba) {
    echo '<tr>';

    echo '<td class="room">';
    echo $soba[0];
    echo '</td>';

    echo '<td class="room">';
    echo $soba[1];
    echo '</td>';

    echo '<td class="room">';
    echo $soba[2];
    echo '</td>';

    echo '<td class="room">';

    echo '<form class="" action="index.php?rt=hotels/removeroom" method="post">';
    echo '<input id="x" type="submit" name="' . $soba[0] . '" value="X">';
    echo '</form>';

    echo '</td>';

    echo' </tr>';
  }
  echo '</table>';
  ?>
</div>
<?php
  echo '<br><br><br>';
  if (isset($is) && $is === 0){
    echo "Room ID taken, given id: " . $max;
    echo "<br>";
  }
 ?>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
