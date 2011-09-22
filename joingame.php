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
  $r = $sth->fetchAll();
  if($r)
    {
    $arr = array('games'=>$r,
                 'status'=>1,
                 'message'=>'Games detected nearby!');
    print json_encode($arr);
    }
  else
    {
    $arr = array('status'=>0,
                 'message'=>'No games found in your location!');
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
