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

/**
 * Generate an alpha-numeric string of specified length.
 */
function generateRandomString($length)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
  $string = '';
  for ($p = 0; $p < $length; $p++)
    {
    $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }
  return $string;
}

/**
 * hacked out by ben brown <ben@xoxco.com>
 * http://xoxco.com/clickable/php-getboundingbox
 *
 * Given a latitude and longitude in degrees (40.123123,-72.234234) and a
 * distance in miles this function calculates a bounding box with corners
 * $distance_in_miles away from the point specified.
 * 
 * returns $min_lat,$max_lat,$min_lon,$max_lon
 */
function getBoundingBox( $lat_degrees, $lon_degrees, $distance_in_miles )
{
  $radius = 3963.1; // of earth in miles

  // bearings
  $due_north = 0;
  $due_south = 180;
  $due_east = 90;
  $due_west = 270;

  // convert latitude and longitude into radians
  $lat_r = deg2rad($lat_degrees);
  $lon_r = deg2rad($lon_degrees);

  // find the northmost, southmost, eastmost and westmost corners
  // $distance_in_miles away. Original formula from
  // http://www.movable-type.co.uk/scripts/latlong.html
  $dist_over_rad =  $distance_in_miles/$radius;
  $northmost = asin(sin($lat_r) * cos($dist_over_rad) +
                    cos($lat_r) * sin ($dist_over_rad) * cos($due_north));
  $southmost = asin(sin($lat_r) * cos($dist_over_rad) +
                    cos($lat_r) * sin ($dist_over_rad) * cos($due_south));

  $eastmost = $lon_r + atan2(sin($due_east)*sin($dist_over_rad)*cos($lat_r),
                             cos($dist_over_rad)-sin($lat_r)*sin($lat_r));
  $westmost = $lon_r + atan2(sin($due_west)*sin($dist_over_rad)*cos($lat_r),
                             cos($dist_over_rad)-sin($lat_r)*sin($lat_r));

  $northmost = rad2deg($northmost);
  $southmost = rad2deg($southmost);
  $eastmost = rad2deg($eastmost);
  $westmost = rad2deg($westmost);

  // sort the lat and long so that we can use them for a between query
  if ($northmost > $southmost)
    {
    $lat1 = $southmost;
    $lat2 = $northmost;
    }
  else
    {
    $lat1 = $northmost;
    $lat2 = $southmost;
    }

  if ($eastmost > $westmost)
    {
    $lon1 = $westmost;
    $lon2 = $eastmost;
    }
  else
    {
    $lon1 = $eastmost;
    $lon2 = $westmost;
    }

  return array( $lat1, $lat2, $lon1, $lon2 );
}

?>
