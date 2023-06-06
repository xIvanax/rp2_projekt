<?php require_once __SITE_PATH . '/view/premium_header.php'; ?>

  <div id="premSort">
    <h3 class="header">Sort your search:</h3>
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
  <div id="premiumList">
  <?php
  echo '<table id="premiumSort">';

  foreach ($sobe_list as $soba) {
    echo '<tr>';

    echo '<td class="room">';
    echo  'id sobe: ' . $soba[0];
    echo '</td>';

    echo '<td class="room">';
    echo  'tip sobe: ' . $soba[1];
    echo '</td>';

    echo '<td class="room">';
    echo  'cijena sobe: ' . $soba[2];
    echo '</td>';

    echo '<td class="room">';

    echo '<form class="" action="index.php?rt=hotels/removeroom" method="post">';
    echo '<input type="submit" name="' . $soba[0] . '" value="X">';
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
  <div id="premNarrow">
    <h3 class="header">Add/Edit room:</h3>
  	<form class="form" action="<?php echo __SITE_URL; ?>/index.php?rt=hotels/addeditroom" method="post">
  		<label for="">Room id: </label><input type="text" name="id_sobe"> <br>
      <label for="">Room type: </label><input type="text" name="tip"> <br>
  		<label for="">Room price: </label><input type="text" name="cijena"> <br>
  		<button type="submit" name="">Add/Edit room</button>
  	</form>
  </div>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
