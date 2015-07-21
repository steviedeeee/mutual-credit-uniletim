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

//odstraníme nebezpeèné znaky

$zaco = SubStr($zacof, 0, 1500);		//bereme pouze 1500 znakù
$zaco = Trim($zaco);				//odstraníme mezery ze zaèátku a konce øetìzce
$zaco = HTMLSpecialChars($zaco);	//odstraníme nebezpeèné znaky
$zaco = Str_Replace("\r\n"," <BR> ", $zaco);	//nahradíme konce øádkù na tagy <BR>
$zacof = WordWrap($zaco, 90, "\n", 1); //rozdìlíme dlouhá slova

$kedyf = Date("Y-m-d"); //kedy
@$tsi = time();

include "./config.php";

$kolkof = Str_Replace(",",".", $kolkof);
$kolkof = abs($kolkof);

$add = MySQL_Query("INSERT INTO uniletim_services VALUES ('', '$ktof', '$komuf', '$kedyf', '$zacof', '$kolkof', '$tsi', '$lgr')") or die($query_error1); //vloíme zprávu
$ads = MySQL_Query("select * from uniletim_services where ser_time like '$tsi' AND ul_group = '$sess[4]'") or die($query_error2); 
$adk = mysql_fetch_row($ads);

$result = _PAYMENT_SCSFL;

//zavøeme databázi
MySQL_Close();
header("Location: ./platby.php?pres=pl");

?>
