<?php

require_once 'config.php';

function generateRandomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
  $string = '';
  for ($p = 0; $p < $length; $p++) {
    $string .= $characters[mt_rand(0, strlen($characters)-1)];
  }
  return $string;
}

header( 'Content-Type:application/json' );

$dd = new PDO('mysql:host=localhost;dbname=siramix_buzzing', $u, $p);
$token = generateRandomString(5);
$sql = 'INSERT INTO games (token,buzzing) VALUES (?,?)';
$sth = $dd->prepare($sql);
if($sth->execute( array($token,false) ))
  {
  $qid = $dd->lastInsertId();

  $arr = array('id' => $qid,
               'token' => $token,
               'status' => 1);
  print json_encode($arr);
  }
else
  {
  print json_encode(array('status'=>0));
  }

?>