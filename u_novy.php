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
include "./includes/page.inc.php";
include "./includes/members.inc.php";
if (!$menu) $menu = "mbr"; //selecting of location menu
 
 
// page header 
head ($sess,$x,$auth,$design,$menu); 


$loc_page = _NEW_MEMBER ;
page_location_announces ($sess,$menu,$rub,$pri,$id,$eid,$loc_page);
page_result_error ($result,$error);?>

	<div  class="content-border">
	 <table cellspacing="0" class="content-form">
					<form name="add" method="post" action="u_info.php">
						<tr>
							<td class="form-i-name"><? echo _NAME ?></td>
							<td><INPUT TYPE="text" NAME="u_meno" SIZE="24"></td>
						</tr>
						<tr> 
							<td class="form-i-name"><? echo _SURNAME ?></td> 
							<td><INPUT TYPE="text" NAME="u_priezvisko" SIZE="24"></td> 
						</tr> 
						<tr> 
							<td class="form-i-name"><? echo _USER_NAME ?>*:</td> 
							<td><INPUT TYPE="text" NAME="usname" SIZE="24"></td> 
						</tr> 
<?if ($sess[3] == "lets"):?> 
						<tr> 
							<td class="form-i-name"><? echo _PASSWORD ?>*:</td> 
							<td><INPUT TYPE="password" NAME="password" SIZE="24"></td> 
						</tr> 
						<tr> 
							<td class="form-i-name"><? echo _PASSWORD . " (" . _CONFIRM . ")" ?>:</td> 
							<td><INPUT TYPE="password" NAME="password2" SIZE="24"></td> 
						</tr> 
						<tr> 
							<td class="form-i-name"><? echo _PERMS ?>:</td> 
							<td> 
                       <?member_perms_select ($perms,$sess)?>
							</td> 
						</tr> 
<?else: 
      $password = md5(uniqid($hash_secret)); 
?> 
<input type="hidden" name="password" value="<? echo $password; ?>"> 
<input type="hidden" name="password2" value="<? echo $password; ?>"> 
<input type="hidden" name="perms" value="1"> 
<?endif;?> 
						<tr> 
							<td class="form-i-name"><? echo _PHONE?>:</td> 
							<td><INPUT TYPE="text" NAME="u_phone" SIZE="24"></td> 
						</tr> 
						<tr> 
							<td class="form-i-name"><? echo _EMAIL?>:</td> 
							<td><INPUT TYPE="text" NAME="u_email" SIZE="24"></td> 
						</tr> 
						<tr> 
							<td class="form-i-name"><? echo _HOME_PAGE?>:</td> 
							<td><INPUT TYPE="text" NAME="u_web" SIZE="24" VALUE="http://"></td> 
						</tr> 
						<tr> 
							<td class="form-i-name"><? echo _PERSONAL_INFO?>:</td> 
							<td><TEXTAREA NAME="u_info" COLS="35" ROWS="4"></TEXTAREA></td> 
						</tr> 
						<?if ($sess[3] == "lets"):?> 
						<tr> 
							<td class="form-i-name"><? echo _RECEIVE_NEWS?>:</td> 
							<td><INPUT TYPE="checkbox" VALUE="y" NAME="u_send" checked></td> 
						</tr> 
						<?endif;?> 
						<tr> 
							<td class="form-i-name"></td> 
							<td> 
							<INPUT TYPE="submit" NAME="uloz" VALUE="<? echo _CREATE ?>"></td> 
						</tr> 
					</form>
					</table>
					</div>
				<?
				member_add_existing ($sess,$menu);

// page footer
foot ($sess,$menu);
?>
