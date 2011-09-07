<?php

require_once 'constants.php';
require_once 'utils.php';

require_once 'config.php';

header(CONTENT_TYPE);

$token = $_REQUEST['token'];

$dd = new PDO(DB_CONNECTION_STRING, $u, $p);
$sql = 'SELECT id FROM games WHERE token= ? ';
$sth = $dd->prepare($sql);
if($sth->execute( array($token) ))
  {
  $sth->setFetchMode(PDO::FETCH_BOTH);
  $r = $sth->fetch();
  if($r)
    {
    print json_encode(array('status'=>1));
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