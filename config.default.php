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


$server_name = "localhost"; //host
$db_name = "uniletim"; //db name
$db_user = "uniletim"; //user name
$db_pass = "pasSw0r3"; //password
$app_lang = "english"; // application language
$app_design = "xhtml";
$app_style = "green";

@$conn = MySQL_Connect($server_name, $db_user, $db_pass) or die(_NO_MYSQL_CONNECT); //connect to database
@$sdb = MySQL_Select_DB($db_name) or die(_NO_DB_CONNECT); //select database

$hash_secret = "Jabb"; // please, change the hash secret for better security


$admin_mail = "your@mail.net";

if ($app_design != "lets_sk"):
$welcome_call = ", welcome to <b>uniLETIM</b><br>";
$welcome_call_unauth = "";
$foot_call = "<hr size=1 width=90% noshade><div align=center>runs on <a href=http://uniletim.sourceforge.net/>uniLETIM</a></div>";

else:
$welcome_call = ", welcome to our LETS/TimeBank group";
 $welcome_call_unauth = "<b><h3>Welcome to www.letsportal.com</h3></b><br>
			if you are a registered user, please login...<br><br>
			if not, you can try the uniLETIM application in demo-mode as user or administrator";
$foot_call = "<hr size=1 noshade><div align=center>runs on <a href=http://uniletim.sourceforge.net/>uniLETIM</a></div>"; 	
endif;			
			
global $conn;
global $hash_secret;

?>
