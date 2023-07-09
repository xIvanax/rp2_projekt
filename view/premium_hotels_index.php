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
      <button type="button" id="pSort">Sort</button>
    </div>
  </div>
  <h3 class="header">Add/Edit room:</h3>
  <div id="premNarrow">
  	<form class="form" action="<?php echo __SITE_URL; ?>/index.php?rt=hotels/addeditroom" method="post">
    <div class="popup">
      <label for="id_sobe">Room id:</label>
      <div class="popuptext">If you enter an id of an existing room in your hotel you will edit the information about that room.
        If you don't enter an id, or if you enter an id that is already in our database you will be automatically assigned an available id.
        If you enter an id and we do not have it in our database the room will be assigned that id.
      </div>
    </div>
    <input type="text" name="id_sobe"> <br>
    <label for="">Room type: </label><input type="text" name="tip"> <br>
    <label for="">Room price: </label><input type="text" name="cijena"> <br>
    <button type="submit" name="">Add/Edit room</button>
    <h2><?php echo $msg; ?></h2>
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

<script>
    //js za popup
    window.addEventListener('DOMContentLoaded', () => {
        const popup = document.querySelector('.popup');
        const popuptext = document.querySelector('.popuptext');

        popup.addEventListener('mouseover', () => {
            popuptext.style.visibility = 'visible';
            popuptext.style.opacity = 1;
        });

        popup.addEventListener('mouseout', () => {
            popuptext.style.visibility = 'hidden';
            popuptext.style.opacity = 0;
        });
    });
</script>
<?php require_once __SITE_PATH . '/view/_footer.php'; ?>
