<?php

require_once 'constants.php';

require_once 'config.php';

header(CONTENT_TYPE);

$token = $_REQUEST['token'];

$dd = new PDO(DB_CONNECTION_STRING, $u, $p);
$sql = 'SELECT id FROM games WHERE token= ?';
$sth = $dd->prepare($sql);
if($sth->execute( array($token) ))
  {
  $sth->setFetchMode(PDO::FETCH_BOTH);
  $r = $sth->fetch();
  if($r)
    {
    $id = $r['id'];
    $sql = 'SELECT title,badwords FROM cards WHERE game=? AND active=?';
    $sth = $dd->prepare($sql);
    if( $sth->execute( array($id,true) ))
      {
      $sth->setFetchMode(PDO::FETCH_BOTH);
      $r = $sth->fetch();
      if($r)
        {
        $arr = array('title'=>$r['title'],
                     'badwords'=>$r['badwords'],
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
