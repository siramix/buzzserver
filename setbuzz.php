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

$dd = new PDO(DB_CONNECTION_STRING, $u, $p);
$sql = 'UPDATE games SET buzzing=? WHERE token=?';
$sth = $dd->prepare($sql);
if($sth->execute( array(true,$token) ))
  {
  $arr = array('status'=>1,
               'message'=>'Buzzing state unset successfully!');
  print json_encode($arr);
  }
else
  {
  $arr = array('status'=>0,
               'message'=>'Buzzserver database failure (game).');
  print json_encode($arr);
  }

?>
