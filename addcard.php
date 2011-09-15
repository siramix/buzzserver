<?php
/*****************************************************************************
 *  Buzzserver enables online buzzing between buzzwords clients.
 *  Copyright (C) 2011 Siramix Team
 *  
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 ****************************************************************************/
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
        $arr = array('status'=>1,
                     'message'=>'Card added successfully!');
        print json_encode($arr);
        }
      else
        {
        $arr = array('status'=>0,
                     'message'=>'Buzzserver database failure (card update).');
        print json_encode($arr);
        }
      }
    else
      {
      $arr = array('status'=>0,
                   'message'=>'Buzzserver database failure (cards).');
      print json_encode($arr);
      }
    }
  else
    {
    $arr = array('status'=>0,
                 'message'=>'There is no game with that token.');
    print json_encode($arr);
    }
  }
else
  {
  $arr = array('status'=>0,
               'message'=>'Buzzserver database failure (game).');
  print json_encode($arr);
  }

?>
