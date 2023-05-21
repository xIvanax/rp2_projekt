<?php
// template od dz2
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Quack</title>
  </head>
  <body>
    <ul>
      <li> <a = href = "index.php?rt=quacks/index"> Moji quackovi </a></li>
      <li> <a = href = "index.php?rt=quacks/PratimQuacks"> Quackovi koje pratim </a></li>
      <li> <a = href = "index.php?rt=users/Followers"> Moji pratitelji </a></li>
      <li> <a = href = "index.php?rt=quacks/SpomenutiQuacks"> Quackovi koji me spominju </a></li>
      <li> <a = href = "index.php?rt=quacks/search"> Traži # </a></li>
    </ul>
    <h1>
    <?php
    echo $title;
    ?>
    </h1>
