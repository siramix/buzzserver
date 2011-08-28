<?php

require_once 'config.php';

header( 'Content-Type:application/json' );

$token = $_REQUEST['token'];

$dd = new PDO('mysql:host=localhost;dbname=siramix_buzzing', $u, $p);
$sql = 'UPDATE games SET buzzing=? WHERE token=?';
$sth = $dd->prepare($sql);
if($sth->execute( array(true,$token) ))
  {
  print json_encode( array('status' => 1));
  }
else
  {
  print json_encode(array('status'=>0));
  }

?>