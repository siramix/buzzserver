<?php

require_once 'constants.php';
require_once 'utils.php';

require_once 'config.php';

header(CONTENT_TYPE);

$lat = $_REQUEST['lat'];
$long = $_REQUEST['long'];

// Get bounding box and format it for MySQL
$bbox = getBoundingBox( $lat, $long, PLAYER_RADIUS );
$bboxString = 'POLYGON(('.
  $bbox[2].' '.$bbox[0].','.
  $bbox[2].' '.$bbox[1].','.
  $bbox[3].' '.$bbox[1].','.
  $bbox[3].' '.$bbox[0].','.
  $bbox[2].' '.$bbox[0].'))';

$dd = new PDO(DB_CONNECTION_STRING, $u, $p);
$sql = 'SELECT token FROM games WHERE MBRContains(GeomFromText(?),location)';
$sth = $dd->prepare($sql);
if($sth->execute( array($bboxString) ))
  {
  $sth->setFetchMode(PDO::FETCH_NUM);
  $r = $sth->fetch();
  if($r)
    {
    $arr = array('games'=>$r,
                 'status'=>1);
    print json_encode($arr);
    }
  else
    {
    print json_encode(array('status'=>0));
    }
  }
else
  {
  print json_encode(array('status'=>0));
  }

?>
