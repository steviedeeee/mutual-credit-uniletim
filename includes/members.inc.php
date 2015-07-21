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


// MEMBER NAME ECHO
function member_name ($mbr_id) {
	$sql = mysql_query("SELECT * FROM uniletim_members WHERE mbr_id = '$mbr_id'");
	$row = mysql_fetch_row($sql);
	echo "$row[1]";
}

// MEMBER INFO LINK
function member_link ($mbr_id) {
	$sql = mysql_query("SELECT * FROM uniletim_members WHERE mbr_id = '$mbr_id'");
	$row = mysql_fetch_row($sql);
	echo "<A HREF=\"u_info.php?id=$row[0]\">$row[1]</A>";
}

// MEMBER INFO LINK FULL
function member_link_full ($mbr_id) {
	$sql = mysql_query("SELECT * FROM uniletim_members WHERE mbr_id = '$mbr_id'");
	$row = mysql_fetch_row($sql);
	echo "<A HREF=\"u_info.php?id=$row[0]\">$row[1] - $row[5] $row[4]</A>";
}

// mySQL QUERY FOR MEMBER
function member_query ($sess,$mbr_select,$mbr_order) {

	@$sql = mysql_query("SELECT M.*, P.perm_group FROM uniletim_members M
								LEFT JOIN uniletim_perms P ON M.mbr_id = P.perm_member
								WHERE $mbr_select P.perm_group != '$sess[4]' ORDER BY $mbr_order");
}

// MEMBER ACCOUNT STATUS
function member_account ($mbr_id,$sess) {
	$message = MySQL_Query("SELECT SUM(ser_amount) FROM uniletim_services WHERE ser_provider like '$mbr_id' AND ul_group = '$sess[4]'");
	$entry = MySQL_Fetch_Row($message);
	$count = $entry[0];
	$message = MySQL_Query("SELECT SUM(ser_amount) FROM uniletim_services WHERE ser_recipient like '$mbr_id' AND ul_group = '$sess[4]'");
	$entry = MySQL_Fetch_Row($message);
	$count = $count-$entry[0];
	echo $count;
}

// MEMBER ANNOUNCES
function member_count_announces ($mbr_id,$sess) {
$message = MySQL_Query("SELECT count(ann_id) FROM uniletim_announces WHERE ann_member like '$mbr_id' AND ul_group = '$sess[4]'");
	$entry = MySQL_Fetch_Row($message);
	echo $entry[0];
}

// MEMBER SERVICES
function member_count_services ($mbr_id,$sess) {
$message = MySQL_Query("SELECT count(ser_id) FROM uniletim_services WHERE (ser_recipient = '$mbr_id' OR ser_provider = '$mbr_id') AND ul_group = '$sess[4]'");
	$entry = MySQL_Fetch_Row($message);
	echo $entry[0];
}

// PERMS OF MEMBER
function member_perms ($perms) {
	if ($perms[16] == "3"):
		echo _MAIN_ADMIN;
	elseif ($perms[16] == "2"):
		echo _GROUP_ADMIN;
	else:
		echo _USER;
	endif;
}

// PERMS SELECTING
function member_perms_select ($perms,$sess) {?>
   <select name="perms">
		<OPTION value="1"<?if ($perms == "1") { echo " selected";}?>><? echo _USER ?></OPTION>
		<?if ($sess[5] >= "2") { ?><OPTION value="2"<?if ($perms[16] == "2") { echo " selected";}?>><? echo _GROUP_ADMIN ?></OPTION><?}?>
		<?if ($sess[5] == "3") { ?><OPTION value="3"<?if ($perms[16] == "3") { echo " selected";}?>><? echo _MAIN_ADMIN ?></OPTION><?}?>

	</SELECT> <?
}

function member_group_select ($sess) {
	@$sql = mysql_query("SELECT P.perm_group, G.* FROM uniletim_perms P
								LEFT JOIN uniletim_groups G ON P.perm_group = G.grp_id
								WHERE P.perm_member = '$sess[2]' ORDER BY G.grp_name");
	if (mysql_num_rows($sql) == 1)
		{
		$row = mysql_fetch_row($sql);
		echo $row[2];
		}
	else {?>
	<form method="post">
		<select name="group_ch" onchange="this.form.submit()"><?
		while ($row = mysql_fetch_row($sql))
			{?>
			<OPTION value="<? echo $row[1]; ?>"<?if ($row[0] == $sess[4]) echo " selected";?>><? echo $row[2]; ?></OPTION><?
			} ?>
		</select>
	</form><?
		}

}

function member_group_def_view ($member) {
	$d ="d";
	@$sql = mysql_query("SELECT P.perm_group, P.perm_default, G.* FROM uniletim_perms P
								LEFT JOIN uniletim_groups G ON P.perm_group = G.grp_id
								WHERE P.perm_member = '$member[0]' AND P.perm_default = 'd'");
	$row = mysql_fetch_row($sql);
	echo $row[3];
}

function member_group_def_change ($member) {
	@$sql = mysql_query("SELECT P.perm_group, P.perm_default, G.* FROM uniletim_perms P
								LEFT JOIN uniletim_groups G ON P.perm_group = G.grp_id
								WHERE P.perm_member = '$member[0]' ORDER BY G.grp_name");
	if (mysql_num_rows($sql) == 1)
		{
		echo $row[1];
		}
	else {?>
	<!--<form method="post" action="u_info.php">-->
		<select name="gid"><?
		while ($row = mysql_fetch_row($sql))
			{?>
			<OPTION value="<? echo $row[0]; ?>"<?if ($row[1] == "d") echo " selected";?>><? echo $row[3]; ?></OPTION><?
			} ?>
		</select><?
		//$sql = mysql_query("SELECT * FROM uniletim_members WHERE mbr_id = '$member[0]'");
		//$row = mysql_fetch_row($sql);
		?>
		<!--<input type="hidden" name="upid" value="<? echo $row[0]; ?>">
		<input type="hidden" name="usrname" value="<? echo $row[1]; ?>">
		<input type="hidden" name="changed" value="dgroup">
   		<INPUT type="submit" name="save" value="<? echo _SAVE ?>">
	</form>-->
	<?
		}

}



function member_add_existing ($sess,$menu) {

	@$sql = mysql_query("SELECT DISTINCT M.* FROM uniletim_members M
								LEFT JOIN uniletim_perms P ON M.mbr_id = P.perm_member
								WHERE P.perm_group != '$sess[4]' AND M.mbr_state != 'd' ORDER BY M.mbr_login");
	if (mysql_num_rows($sql) == 0)
			{
			$error = _NO_USER;
			}

$loc_page = _EXISTING_USER ;
page_location_announces ($sess,$menu,$rub,$pri,$id,$eid,$loc_page);
page_result_error ($result,$error);?>

	<div  class="content-border">
	 <table class="content-form">
	<form name="add_ex" method="post" action="u_info.php">
		<tr>
			<td class="form-i-name"><? echo _USER ?></td>
			<td>
				<select name="exid">
					<OPTION value="0"><? echo _SELECT ?></OPTION>	<?
				while ($row = mysql_fetch_row($sql))
				{
				?>
					<OPTION value="<? echo $row[0]; ?>"><? echo "$row[4] $row[5] - $row[1]"; ?></OPTION>
				<? } ?>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td class="form-i-name"><? echo _PERMS ?>:</td>
			<td>
           <?member_perms_select ($perms,$sess)?>
			</td>
		</tr>
		<tr>
			<td class="form-i-name"></td>
			<td>
				<INPUT TYPE="hidden" NAME="perm_group" VALUE="<? echo $sess[4]; ?>">
				<INPUT TYPE="submit" NAME="uloz" VALUE="<? echo _CREATE ?>"></td>
		</tr>
	</form>
	</table></div>
	<?
}

//printing list of members
function members_list_printing ($sess) {

// page header
head_printing ();


@$sqp = mysql_query("SELECT M.*, P.perm_group FROM uniletim_members M
								LEFT JOIN uniletim_perms P ON M.mbr_id = P.perm_member
								WHERE P.perm_group = '$sess[4]' AND M.mbr_state != 'd' ORDER BY M.mbr_login");

	 if (mysql_num_rows($sqp) == 0)
        {
        echo "<tr><td COLSPAN=5>". _NO_USER . "</td></tr></table>\n";
        }
     else
        {
?>

	<table width="720" border="0" align="center" cellspacing="0" cellpadding="3">
		<tr class="dark">
			<td colspan="6"><h2><? echo _GROUP ?>: 
				<?  $message = MySQL_Query("SELECT * FROM uniletim_groups WHERE grp_id = '$sess[4]'") or die($query_error); //vybíráme zprávy - seøazeno podle id
					$entry = MySQL_Fetch_Row($message);
					echo $entry[1] ?></h25>
						</td></tr>
						<TR class="middle">
							<td width="130">
							<? echo _USER_NAME ?></td>
							<td><? echo _NAME ?></td>
							<td><? echo _SURNAME ?></td>
							<TD width="80"><? echo _PHONE ?></td>
							<TD width="120"><? echo _EMAIL ?></td>
							<td width="70" align="right"><? echo _ACCOUNT_STATUS ?></td>

						</tr>
<?
   $i = 0;
   while ($row = mysql_fetch_row($sqp))
   {
      if ($i%2==0) $bgcolor=''; else $bgcolor=" class=row";
   ?>
						<TR <? echo $bgcolor; ?>>
							<TD <? echo $bgcolor; ?>><? echo $row[1]; ?></td>
							<TD <? echo $bgcolor; ?>><? echo $row[5]; ?></td>
							<TD <? echo $bgcolor; ?>><? echo $row[4]; ?></td>
							<TD <? echo $bgcolor; ?>><? echo $row[10]; ?></td>
							<TD <? echo $bgcolor; ?>><? echo $row[6]; ?></td>
							<TD <? echo $bgcolor; ?> align="right"><?
								$message = MySQL_Query("SELECT SUM(ser_amount) FROM uniletim_services WHERE ser_provider like '$row[0]' AND ul_group = '$sess[4]'") or die($query_error); //vybíráme zprávy - seøazeno podle id
								$entry = MySQL_Fetch_Row($message);
								$count = $entry[0];
								$message = MySQL_Query("SELECT SUM(ser_amount) FROM uniletim_services WHERE ser_recipient like '$row[0]' AND ul_group = '$sess[4]'") or die($query_error); //vybíráme zprávy - seøazeno podle id
								$entry = MySQL_Fetch_Row($message);
								$count = $count-$entry[0];
								echo $count; ?></td>
						</tr>
   <?

          $i++;
   }
		}
// page footer
foot_printing ($sess);

	}
	

	
?>

