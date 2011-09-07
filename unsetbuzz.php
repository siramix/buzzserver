<?php

require_once 'constants.php';

require_once 'config.php';

header(CONTENT_TYPE);

$token = $_REQUEST['token'];

$dd = new PDO(DB_CONNECTION_STRING, $u, $p);
$sql = 'UPDATE games SET buzzing=? WHERE token=?';
$sth = $dd->prepare($sql);
if($sth->execute( array(false,$token) ))
  {
  print json_encode( array('status' => 1));
  }
else
  {
  print json_encode(array('status'=>0));
  }

?>
