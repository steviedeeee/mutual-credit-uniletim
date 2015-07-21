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
 

// login and authorisation of user 
 
include "./config.php"; 
 
If ((IsSet($login)) AND (IsSet($password))): 
// is set urername and password 
	$password = MD5($password); 
	$SQL = MySQL_Query("SELECT * FROM uniletim_members WHERE (mbr_login LIKE '$login') AND (mbr_password LIKE '$password')");
	$INFO = mysql_fetch_row($SQL);
	If (MySQL_Num_Rows($SQL) < 1):
		header("Location: ./login.php?echo=error"); 
		Exit; 
 
	Else: 
		$SN = "hvxator"; 
		Session_name("$SN"); 
		Session_start(); 
		$sid = Session_id(); 
		$time = Date("U"); 
		$at = Date("U") - 1800; 

		$SQL = MySQL_Query("SELECT * FROM uniletim_perms WHERE perm_member = '$INFO[0]' AND perm_default = 'd'");
		$PERM = mysql_fetch_row($SQL);


		$SQL = MySQL_Query("SELECT * FROM uniletim_groups WHERE grp_id = '$PERM[2]'");
		$GROUP = mysql_fetch_row($SQL);

		If ($GROUP[4] == ""): $design = $app_design;
		else: $design = $GROUP[4];
		endif;
		If ($GROUP[5] == ""): $style = $app_style;
		else: $style = $GROUP[5];
		endif;
		If ($GROUP[6] == ""): $lang = $app_lang;
		else: $lang = $GROUP[6];
		endif;

		$MSQ = MySQL_Query("INSERT INTO uniletim_auth VALUES ('$sid', '$time', '$INFO[0]', '$GROUP[3]', '$PERM[2]', '$PERM[3]', '$design', '$style', '$GROUP[1]', '$lang')");
		// $MSQ = MySQL_Query("DELETE FROM lets_auth WHERE time < $at"); 
	endif; 
 
	header("Location: ./index.php"); 
 
elseif (IsSet($lo)): 
// logout 
 
 
	$SN = "hvxator"; 
	Session_name("$SN"); 
	Session_start(); 
	$sid = Session_id(); 
 
	$MSQ = MySQL_Query("SELECT * FROM uniletim_auth WHERE aut_id = '$sid'"); 
	$sess = mysql_fetch_row($MSQ); 
 
	$MSQ = MySQL_Query("DELETE FROM uniletim_auth WHERE  aut_id = '$sid'"); 

		header("Location: ./index.php"); 
//		header("Location: ./server/uniletim.php?action=stop"); 
 
	 
else: 
	include "language/lang-$app_lang.php"; 
	 
	if ($echo == "error"): 
		$error = _LOGGIN_ERROR; 
	endif; 
	 
	?> 
 
	<html> 
	<head> 
		<META HTTP-EQUIV=content-type CONTENT=text/html;charset=ISO-8859-2> 
		<META HTTP-EQUIV=Author CONTENT=Priestor, o.z.> 
		<TITLE>uniLETIM</TITLE> 
		<LINK REL=stylesheet HREF="./themes/css/<? echo $app_style;?>.css"> 
	</head> 
	<body> 
	<br><br><br><br><br><br>
<table border="1" cellspacing="0" cellpadding="0" bordercolor="Green" align=center><tr><td valign="top" align=center>
	<table width=250 border=0 cellspacing=0 cellpadding=3 align=center bordercolor=Black noshade=>
		<TR class=td_tmave>    
			<td align=center colspan="2">
				<font size=+1><? echo _LOGGING_IN ?></font> 
			</td> 
		</tr> 
		<tr>
			<td align=center colspan="2">
				<div  class="error"><? echo $error;?></div>
			</td>
		</tr>
			<form method="post">
		<tr>
			<td>
				<? echo _LOGIN ?>
			</td>
			<td>
				<input type="Text" name="login">
			</td>
		</tr>
		<tr>
			<td>
				<? echo _PASSWORD ?>
			</td>
			<td>
				<input type="Password" name="password">
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				<input type="submit" value="<? echo _INSERT ?>">
			</form>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				<h4>English demo:</h4>
				user: tester/tester<br />
				admin: admin/admin
				<h4>Slovenské demo:</h4>
				u¾ívateµ: Testovnik/test<br />
				admin: Administrator/admin
			</td>
		</tr>
	</table>
	</td></TR></TABLE>
	</body> 
	</html>
 <? 
endif;?> 
