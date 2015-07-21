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


$loc_page = _PAYING_ORDER ;
page_location_announces ($sess,$menu,$rub,$pri,$id,$eid,$loc_page);
page_result_error ($result,$error);?>

<form method="post">
	<div  class="content-border">
	 <table cellspacing="0" class="content-form">
 <tr>
 	<td class="form-i-name">
	<? echo _SERVICE_PROVIDER ?>:</td>
	<td>
    <select name="komuf">
	<option value=""><? echo _SELECT_PROVIDER ?></option>
    			<?
					$mbr_select = "";
					$mbr_order = "mbr_login";
					$pse = mysql_query("SELECT M.*, P.perm_group FROM uniletim_members M
								LEFT JOIN uniletim_perms P ON M.mbr_id = P.perm_member
								WHERE $mbr_select P.perm_group = '$sess[4]' ORDER BY $mbr_order");

					  while ( $row = mysql_fetch_row($pse)):
				?>
              <option value="<? echo "$row[0]";?>"<?if ($row[0] == $komuf) { echo " selected";}?>><? echo "$row[1] - $row[5] $row[4]";?></option>\n";
				<?
                endwhile;
				?>
    </select></td>
 </tr>
 <?if ($sess[5] == "1"): ?>
<input type="hidden" name="ktof" value="<? echo $sess[2]; ?>">

<?else: ?>
 <tr>
 	<td class="form-i-name"><? echo _SERVICE_RECIPIENT ?>:</td>
	<td>
    <select name="ktof">
	<option value=""><? echo _SELECT_RECIPIENT ?></option>
    			<?
				if ($ktof == "") { $ktof = $sess[2];}
					$mbr_select = "";
					$mbr_order = "mbr_login";
					$pse = mysql_query("SELECT M.*, P.perm_group FROM uniletim_members M
								LEFT JOIN uniletim_perms P ON M.mbr_id = P.perm_member
								WHERE $mbr_select P.perm_group = '$sess[4]' ORDER BY $mbr_order");
                while ( $row = mysql_fetch_row($pse)): 
				?>
              <option value="<? echo "$row[0]";?>"<?if ($row[0] == $ktof) { echo " selected";}?>><? echo "$row[1] - $row[5] $row[4]";?></option>\n";
				<? 
                endwhile;
				?>   
    </select></td>
 </tr>
 <?endif;?>	 

 <tr>
 	<td class="form-i-name">
	<? if ($sess[3] == "timebank") { echo _HOURS;}
	else { echo _UNITS;}?>:
	</td>
	<td><input name="kolkof" style="WIDTH: 250px" type="text" size="10" value="<?echo $kolkof?>"></td>
 </tr>

 <tr>
	<td class="form-i-name"><? echo _SERVICE ?>:</td>
	<td><textarea name="zacof" cols="40" rows="2" class="input"><?echo $zacof?></textarea></td>
  </tr>

<input type="hidden" name="write" value="kont">
<input type="hidden" name="action" value="write">
 <tr>
	<td></td>
	<td>
	<input type="submit" value="<? echo _INSERT ?>"></td>
 </tr>
</table>
</div>
</form>


						
			
