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

include "./config.php";
include "./auth.php";
include "language/lang-$lang.php";
include "./includes/members.inc.php";
include "./includes/page.inc.php";
if (!$menu) $menu = "mbr"; //selecting of location menu

if ($upid != "")
{
include "./u_post.php";
$id = "$upid";
}
;
if ($id == ""):
$id = $sess[2];
endif;

@$sqk = mysql_query("SELECT M.*, P.perm_group, P.perm_perms FROM uniletim_members M
								LEFT JOIN uniletim_perms P ON M.mbr_id = P.perm_member
								WHERE mbr_id LIKE '$id'");
$rod = mysql_fetch_row($sqk);

// page header
head ($sess,$x,$auth,$design,$menu);


$loc_page = _MEMBERS_PROFILE_CHNG ;
page_location_announces ($sess,$menu,$rub,$pri,$id,$eid,$loc_page);
page_result_error ($result,$error);
?>
	<div  class="content-border">
	 <table cellspacing="0" class="content-form">
					<form name="edit" method="post" action="u_info.php">
						<tr>
							<td class="form-i-name"><? echo _NAME ?>:</td>
							<td><INPUT TYPE="text" NAME="u_meno" SIZE="24" value="<? echo $rod[5]; ?>"></td>
						</tr>
						<tr>
							<td class="form-i-name"><? echo _SURNAME ?>:</td>
							<td><INPUT TYPE="text" NAME="u_priezvisko" SIZE="24" value="<? echo $rod[4]; ?>"></td>
						</tr>
						<tr>
							<td class="form-i-name"><? echo _USER_NAME ?>*:</td>
							<td><INPUT TYPE="text" NAME="usrname" SIZE="24" value="<? echo $rod[1]; ?>"></td>
						</tr>
<?if ($pw == "edit"):?>
						<tr>
							<td class="form-i-name"><? echo _PASSWORD ?>*:</td>
							<td><INPUT TYPE="password" NAME="passw" SIZE="24"></td>
						</tr>
						<tr>
							<td class="form-i-name"><? echo _PASSWORD ." (" . _CONFIRM . ")*:" ?></td>
							<td><INPUT TYPE="password" NAME="passw2" SIZE="24">
							<input type="hidden" name="pw" value="changed">
							</td>
						</tr>
<?endif;?>
						<tr>
							<td class="form-i-name"><? echo _PHONE?>:</td>
							<td><INPUT TYPE="text" NAME="u_phone" SIZE="24" value="<? echo $rod[10]; ?>"></td>
						</tr>
						<tr>
							<td class="form-i-name"><? echo _EMAIL ?>:</td>
							<td><INPUT TYPE="text" NAME="u_email" SIZE="24" value="<? echo $rod[6]; ?>"></td>
						</tr>
						<tr>
							<td class="form-i-name"><? echo _HOME_PAGE ?>:</td>
							<td><INPUT TYPE="text" NAME="u_web" SIZE="24" value="<? echo $rod[7]; ?>"></td>
						</tr>
						<tr>
							<td class="form-i-name"><? echo _PERSONAL_INFO ?>:</td>
							<td><TEXTAREA NAME="u_info" COLS="35" ROWS="4"><? echo $rod[8]; ?></TEXTAREA></td>
						</tr>
<?if ($sess[3] == "lets"):?>
						<tr>
							<td class="form-i-name"><? echo _RECEIVE_NEWS ?>:</td>
							<td><INPUT TYPE="checkbox" VALUE="y" NAME="u_send"<?if ($rod[9] == "y") { echo " checked";}?>></td>
						</tr>
<?endif;?>
						<tr>
							<td class="form-i-name"><? echo _DEFAULT_GROUP ?>:</td>
							<td><? member_group_def_view ($rod);?></td>
						</tr>
						<tr>
							<td class="form-i-name"></td>
							<td>
<?if ($sess[5] >= "2" & $sess[3] == "lets"):?>
							<A HREF="u_info.php?id=<? echo $id; ?>&edit=perms"><? echo _CHNG_PERMS ?></A><br>
							<A HREF="u_info.php?id=<? echo $id; ?>&edit=passw"><? echo _CHNG_PASSWORD ?></A><br>
				         <A HREF="u_info.php?id=<? echo $id; ?>&edit=dgroup"><? echo _CHNG_DEFAULT_GROUP ?></A><br>
<?elseif ($rod[0] == $sess[2]):?>
							<A HREF="u_info.php?id=<? echo $id; ?>&edit=passw"><? echo _CHNG_PASSWORD ?></A><br>
				         <A HREF="u_info.php?id=<? echo $id; ?>&edit=dgroup"><? echo _CHNG_DEFAULT_GROUP ?></A><br>
<?endif;?>
						</tr>
						<tr>
							<td></td>
							<td>
							<input type="hidden" name="upid" value="<? echo $rod[0]; ?>">
							<input type="hidden" name="perms" value="<? echo $rod[3]; ?>">
							<input type="submit" name="uloz" value="<? echo _SAVE ?>"></td>
						</tr>
					</form>
					</table>
					</div>

<?
// page footer
foot ($sess,$menu);
?>
