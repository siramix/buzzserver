<?php

require_once 'constants.php';
require_once 'utils.php';

require_once 'config.php';

header(CONTENT_TYPE);

$lat = $_REQUEST['lat'];
$long = $_REQUEST['long'];

$point = 'POINT('.$long.' '.$lat.')';

$token = generateRandomString(PLAYER_TOKEN_LENGTH);

$dd = new PDO(DB_CONNECTION_STRING, $u, $p);
$sql = "INSERT INTO games (token,location,buzzing) VALUES ".
       "(?,GeomFromText(?),?)";
$sth = $dd->prepare($sql);
if( $sth->execute( array($token,$point,false)) )
  {
  $qid = $dd->lastInsertId();

  $arr = array('id' => $qid,
               'token' => $token,
               'status' => 1);
  print json_encode($arr);
  }
else
  {
  // TODO: Better error
  print json_encode(array('status'=>0));
  }

?>
