<?php

// db credentials
define('DB_HOST', 'localhost:3308'); //WAMP users can get the localhost port number through the icon tray -> MySQL icon
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'aaron_music');

// Connect to the database.
function connect()
{
  $connect = mysqli_connect(DB_HOST ,DB_USER ,DB_PASS ,DB_NAME);

  if (mysqli_connect_errno($connect)) {
    die("Failed to connect:" . mysqli_connect_error());
  }

  mysqli_set_charset($connect, "utf8");

  return $connect;
}


?>