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


//form for sending message to admin
function mail_form ($sess) {


?>
	<table width="460" border="0" cellspacing="0" cellpadding="3">
	<form method="post">
		<tr>
			<td valign="top" class="table"><b><? echo _MESSAGE ?>:</b></td>
			<td><textarea cols="40" rows="4" name="m_body" class="input"></textarea></td>
		</tr> 
				<input type="hidden" name="action" value="send">
		<tr>
			<td class="table">&nbsp;</td>
			<td><input type="submit" value="<? echo _INSERT ?>"></td>
		</tr>
	</form>
	</table>
<?	
}
	
//sending mesage from form
function mail_send ($admin_mail,$m_body,$sess) {

	@$sql_user = mysql_query("SELECT * FROM uniletim_members WHERE mbr_id = '$sess[2]'");
	$row_user = mysql_fetch_row($sql_user);
	$m_subject = "uniLETIM from: $row_user[1]"; 


	mail($admin_mail, $m_subject, $m_body, '');
	$result = _WAS_SENT;
	}

// STATISTIC
function admin_statistic () {
?>
	<H3>STATISTIKA</H3>
	
	<div  class="res"><? echo $result ?></div>&nbsp;
	<div  class="error"><? echo $error ?></div><br>
    <p>Tato funkcia este nie je vytvorena</p>
	<TABLE BORDER="0" CELLPADDING="8" CELLSPACING="0">
		<TR>
			<TD VALIGN="top" ALIGN="right">
				
			</TD>
			<TD>
				<
			</TD>
		</TR>
	</TABLE>
<? 
}
	
?>

