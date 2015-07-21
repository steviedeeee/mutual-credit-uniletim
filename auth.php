<?
//  uniLETIM - LETS & TimeBank announcing and accounting system 
//  Copyright (C) 2003 PRIESTOR o.z., Ondrej Vegh, Robert Zelnik, Michal Jurco

//  This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License (in Slovak Republic
//  in the terms of the Vseobecna zverejnovacia licencia GNU) as published by the Free Software Foundation; either version 2 
//  of the License, or (at your option) any later version.

//  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

//  You should have received a copy of the GNU General Public License  along with this program; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 or visit http://www.gnu.sk/ for Vseobecna zverejnovacia licencia GNU



// skript sluzi k autorizacii uzivatelov

include "./config.php";
$SN = "hvxator";
Session_name("$SN");
Session_start();
$sid = Session_id();
$date = Date("U");
$ad = Date("U") - 1800;

$MSQ = MySQL_Query("SELECT * FROM uniletim_auth WHERE (aut_id = '$sid')"); // AND (aut_date >= $ad)
$sess = mysql_fetch_row($MSQ);
If (MySQL_Num_Rows($MSQ) <> 1):
header("Location: ./login.php");
$auth = "0";
Exit;
Else:
$lang = $sess[9];
$MSQ = MySQL_Query("UPDATE uniletim_auth SET aut_date = $date WHERE aut_id = '$sid'");
Endif;

// change group
if ($group_ch != ""):
	mysql_query("UPDATE uniletim_auth SET aut_group='$group_ch', aut_group_name='$grp_name' WHERE aut_id='$sess[0]'");
	$MSQ = MySQL_Query("SELECT * FROM uniletim_auth WHERE (aut_id = '$sid')"); // AND (aut_date >= '$ad')
	$sess = mysql_fetch_row($MSQ);
endif;
?>

