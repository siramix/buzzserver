<?php

require_once 'config.php';

header( 'Content-Type:application/json' );

function generateRandomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
  $string = '';
  for ($p = 0; $p < $length; $p++) {
    $string .= $characters[mt_rand(0, strlen($characters))];
  }
  return $string;
}

$dd = new PDO('mysql:host=localhost;dbname=siramix_buzzing', $u, $p);
$token = generateRandomString(5);
$sql = 'INSERT INTO games (token) VALUES ('.$token.')';
$sth = $dd->prepare($sql);
$sth->execute( array() );
$qid = $dd->lastInsertId();

$arr = array('id' => $qid,
             'token' => $token);
print json_encode($arr);
?>