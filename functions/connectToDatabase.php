<?php
function connect()
{
  // define('HOST', "localhost");
  // define('USER', "root");
  // define('PASSWORD', "");
  // define('DB', "props");
  $host = "localhost";
  $user = "root";
  $password = "";
  $db = "properties";

  $conn = new mysqli($host, $user, $password, $db);
  // $conn = new mysqli(HOST, USER, PASSWORD, DB);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
  $conn->close();
}
