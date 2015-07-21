<?php
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
include "./language/lang-$lang.php";
include "./includes/page.inc.php";
include "./includes/members.inc.php";
if (!$menu) $menu = "mbr"; //selecting of location menu


if ($uppid != "" || $upid != "" || $usname != "" || $changed != ""|| $exid != "")
{
include "./u_post.php";
}

@$sql = mysql_query("SELECT M.*, P.perm_group, P.perm_perms FROM uniletim_members M
								LEFT JOIN uniletim_perms P ON M.mbr_id = P.perm_member
								WHERE mbr_id LIKE '$id'");
$roc = mysql_fetch_row($sql);

// page header
head ($sess,$x,$auth,$design,$menu);

$loc_page = _MEMBERS_PROFILE ;
page_location_announces ($sess,$menu,$rub,$pri,$id,$eid,$loc_page);
page_result_error ($result,$error);?>

	<div  class="content-border">
	 <table cellspacing="0" class="content-form">
	 					<tr>
							<td class="form-i-name"><?php  echo _USER_NAME ?>:</td>
							<td><?php  echo $roc[1]; ?></td>
						</tr>
						<tr>
							<td class="form-i-name"><?php  echo _NAME ?>:</td>
							<td><?php  echo $roc[5]; ?></td>
						</tr>
						<tr>
							<td class="form-i-name"><?php  echo _SURNAME ?>:</td>
							<td><?php  echo $roc[4]; ?></td>
						</tr>
						<tr>
							<td class="form-i-name"><?php  echo _PERM ?>:</td>
							<td>
<?php 
$perms=$roc;
if ($sess[5] >= "2" & $edit == "perms"):?>
					<form name="edit" method="post" action="u_info.php">
							<?php member_perms_select ($perms,$sess)?>
							<input type="hidden" name="uppid" value="<?php  echo $perms[0]; ?>">
							<input type="hidden" name="usrname" value="<?php  echo $perms[1]; ?>">
							<input type="hidden" name="changed" value="perms">
							<INPUT TYPE="submit" NAME="uloz" VALUE="<?php  echo _SAVE ?>">
					</form>
<?php else:
							member_perms ($perms);
endif;?>
<?php if ($edit == "passw"):?>
							</td>
						</tr>
					<form name="edit" method="get" action="u_info.php">
						<tr>
							<td class="form-i-name"><?php  echo _PASSWORD ?>*:</td>
							<td><INPUT TYPE="password" NAME="passw" SIZE="24"></td>
						</tr>
						<tr>
							<td class="form-i-name"><?php  echo _PASSWORD ." (" . _CONFIRM . ")*:" ?></td>
							<td><INPUT TYPE="password" NAME="passw2" SIZE="24">
							<input type="hidden" name="upid" value="<?php  echo $roc[0]; ?>">
							<input type="hidden" name="usrname" value="<?php  echo $roc[1]; ?>">
							<input type="hidden" name="changed" value="passw">
							<INPUT TYPE="submit" NAME="uloz" VALUE="<?php  echo _SAVE ?>">
							</td>
						</tr>
					</form>
<?php endif;?>
<?php if ($edit == "dgroup"):?>
							</td>
						</tr>
   		<form name="edit" method="post" action="u_info.php">
						<tr>
							<td class="form-i-name"><?php  echo _DEFAULT_GROUP . ":" ?></td>
							<td>
							<?php  member_group_def_change ($roc);?>
   				<input type="hidden" name="upid" value="<?php  echo $roc[0]; ?>">
							<input type="hidden" name="usrname" value="<?php  echo $roc[1]; ?>">
							<input type="hidden" name="changed" value="dgroup">
   							<INPUT type="submit" name="save" value="<?php  echo _SAVE ?>">
							</td>
						</tr>
   		</form>
<?php endif;?>
						<tr>
							<td class="form-i-name"><?php  echo _PHONE ?>:</td>
							<td><?php  echo $roc[10]; ?></td>
						</tr>
						<tr>
							<td class="form-i-name"><?php  echo _EMAIL ?>:</td>
							<td><A HREF="mailto:<?php  echo $roc[6]; ?>"><?php  echo $roc[6]; ?></A></td>
						</tr>
						<tr>
							<td class="form-i-name"><?php  echo _HOME_PAGE ?>:</td>
							<td><A HREF="<?php  echo $roc[7]; ?>"><?php  echo $roc[7]; ?></A></td>
						</tr>
						<tr>
							<td class="form-i-name"><?php  echo _PERSONAL_INFO ?>:</td>
							<td><?php  echo $roc[8]; ?></td>
						</tr>
						<tr>
							<td class="form-i-name"><?php  echo _OTHER_INFO ?>:</td>
							<td>


<?php if ($sess[5] >= "2"):?>
							<A HREF="u_zmena.php?id=<?php  echo $id; ?>"><?php  echo _CHNG_INFO ?></A><br>
<?php endif;?>
							<A HREF="index.php?action=user&uoz=<?php  echo $id; ?>"><?php  echo _ANNOUNCES ?></A><br>

							<A HREF="platby.php?action=user&uso=<?php  echo $id; ?>"><?php  echo _PAYMENTS ?></A>
							</td>
						</tr>
	</table>
	</div>
<?php 
// page footer
    foot ($sess,$menu);
?>
