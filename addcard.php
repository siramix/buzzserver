<?php

require_once 'constants.php';

require_once 'config.php';

header(CONTENT_TYPE);

$token = $_REQUEST['token'];
$title = $_REQUEST['title'];
$badwords = $_REQUEST['badwords'];

$dd = new PDO(DB_CONNECTION_STRING, $u, $p);

$sql = 'SELECT id FROM games WHERE token= ? ';
$sth = $dd->prepare($sql);
if($sth->execute( array($token) ))
  {
  $sth->setFetchMode(PDO::FETCH_BOTH);
  $r = $sth->fetch();
  if($r)
    {
    $id = $r['id'];
    $sql = 'INSERT INTO cards (game,title,badwords,active) VALUES (?,?,?,?)';
    $sth = $dd->prepare($sql);
    if($sth->execute( array($id,$title,$badwords,true) ))
      {
      $qid = $dd->lastInsertId();
      $sql = 'UPDATE cards SET active=? WHERE game=? AND id!=?';
      $sth = $dd->prepare($sql);
      if( $sth->execute( array(false,$id,$qid) ))
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
