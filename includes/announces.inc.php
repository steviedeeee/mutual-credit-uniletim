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



// NEW ANNOUNCE
function announces_new ($sess,$chtext,$a_id,$dp,$platn,$chcena,$rub,$pri,$error,$result,$h3) {

	$menu= "ann";
	$loc_page = _NEW_ANNOUNCE ;
	page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page);

	page_result_error ($result,$error);
?>

	<div  class="content-border">
	 <table cellspacing="0" class="content-form">
	  <form name="add" method="post" action="index.php?action=form&type=new">
		<tr>
			<td class="form-i-name"><? echo _ANNO_CONTENT ?>:</td>
			<td><TEXTAREA NAME="text" COLS="30" ROWS="8"><? echo $chtext; ?></TEXTAREA></td>
		</tr><?
	if ($dp == "news"):?>
			<input type="hidden" name="a_id" value="<? echo "$sess[2]";?>">
			<input type="hidden" name="dp" value="news"><?
	else:
		if ($sess[5] == "1"):?>
			<input type="hidden" name="a_id" value="<? echo "$sess[2]";?>"><?
		else:?>
		<tr>
			<td class="form-i-name"><?
			 	echo _FROM;?>:
			</td>
			<td>
				<select name="a_id">
						<OPTION value="0"><? echo _SELECT ?></OPTION><?
						
					if ($sess[3] == "lets" & $a_id == "") $a_id = $sess[2];
					$pse = mysql_query("SELECT M.*, P.perm_group FROM uniletim_members M
								LEFT JOIN uniletim_perms P ON M.mbr_id = P.perm_member WHERE P.perm_group = '$sess[4]' ORDER BY mbr_login");
					while ( $row = mysql_fetch_row($pse)):?>
						<OPTION value="<? echo "$row[0]";?>"<?if ($row[0] == $a_id) { echo " selected";}?>><? echo "$row[1] - $row[5]";?></OPTION>\n";<?
					endwhile;?>
				</SELECT>
			</td>
		</tr><?
		endif;?>
		<tr>
			<td class="form-i-name">
				<? echo _SUBSECTION ?>:
			</td>
			<td><?
		$pse = mysql_query("SELECT * FROM uniletim_subsections WHERE ul_group = '$sess[4]' ORDER BY sub_section");
		if (mysql_affected_rows() == 0):

		echo "<div class=error>" . _NO_SECTION . " " .  _NO_SUBSECTION . " " . _CREATE_SUB_FIRST . "</div>";

		else:?>
				<select name="pri">
						<OPTION value="0"><? echo _SELECT_SUB ?></OPTION><?
				if($rubx != ""):
					$pse = mysql_query("SELECT * FROM uniletim_subsections WHERE sub_section = '$rub' AND ul_group = '$sess[4]' ORDER BY sub_name");
					while ( $row = mysql_fetch_row($pse)):?>
						<OPTION value="<? echo "$row[0]";?>"<?if ($row[0] == $pri) { echo " selected";}?>><? echo "$row[1]";?></OPTION>\n";<?
					endwhile;
				else:
					$pse = mysql_query("SELECT * FROM uniletim_subsections WHERE ul_group = '$sess[4]' ORDER BY sub_section");
					while ( $row = mysql_fetch_row($pse)):
						$psr = mysql_query("SELECT * FROM uniletim_sections WHERE sec_id = '$row[2]' AND ul_group = '$sess[4]'");
						$ror = mysql_fetch_row($psr);?>
						<OPTION value="<? echo "$row[0]";?>"<?if ($row[0] == $pri) { echo " selected";}?>><? echo "$ror[1] - $row[1]";?></OPTION>\n";<?
					endwhile;
				endif;	?>
				</SELECT><?
		endif;?>
			</td>
		</tr>
		<tr>
			<td class="form-i-name">
				<? echo _VALIDITY ?>:
			</td>
			<td>
				<select name="platn">
					<OPTION value="2000"><? echo _TO_CANCEL ?></OPTION>
					<OPTION value="7"<?if ($platn == "7") { echo " selected";}?>><? echo _WEEK ?></OPTION>
					<OPTION value="14"<?if ($platn == "14") { echo " selected";}?>><? echo _2WEEKS ?></OPTION>
					<OPTION value="31"<?if ($platn == "31") { echo " selected";}?>><? echo _MONTH ?></OPTION>
					<OPTION value="92"<?if ($platn == "92") { echo " selected";}?>><? echo _3MONTHS ?></OPTION>
					<OPTION value="183"<?if ($platn == "183") { echo " selected";}?>><? echo _6MONTHS ?></OPTION>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td class="form-i-name">&nbsp;</td>
			<td>
				<select name="dp">
					<OPTION value="0"><? echo _SELECT ?></OPTION>
					<OPTION value="ponuka"<?if ($dp == "ponuka") echo " selected" ?>><? echo _OFFER ?></OPTION>
					<OPTION value="dopyt"<?if ($dp == "dopyt") echo " selected" ?>><? echo _QUERY ?></OPTION>
				</SELECT>
			</td>
		</tr><?
	 	if ($sess[3] != "timebank"):?>
		<tr>
			<td class="form-i-name">
				<? echo _PRICE ?>:
			</td>
			<td>
				<INPUT TYPE="text" NAME="cena" SIZE="10" value="<? echo $chcena; ?>"> <? echo _UNITS ?>
			</td>
		</tr><?
  		endif;
	endif;?>
		<tr>
			<td class="form-i-name">&nbsp;</td>
			<td>
				<input type="hidden" name="ri" value="ri">
				<INPUT TYPE="submit" NAME="pridaj" VALUE="<? echo _INSERT ?>">
			</td>
		</tr>
	</FORM>
	</TABLE>
	</div>


<?
}


// EDIT ANNOUNCE
function announces_edit ($sess,$eid,$chtext,$a_id,$dp,$platn,$chcena,$rub,$pri,$error,$result) {

	$menu= "ann";
	$loc_page = _EDIT_ANNOUNCE ;
	page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page);

	page_result_error ($result,$error);

	$ske = mysql_query("SELECT * FROM uniletim_announces WHERE ann_id='$eid' AND ul_group = '$sess[4]'");
    $sker = mysql_fetch_row($ske)?>

	<div  class="content-border">
	 <table cellspacing="0" class="content-form">
	  <form name="add" method="post" action="index.php?action=user">
		<tr>
			<td class="form-i-name">
				<b><? echo _ANNO_CONTENT ?>:</b>
			</td>
			<td>
				<TEXTAREA NAME="info" COLS="30" ROWS="8"><? echo "$sker[7]";?></TEXTAREA>
			</td>
		</tr>
		<tr>
			<td class="form-i-name">
				<b><? echo _SUBSECTION ?>:</b>
			</td>
			<td>
				<select name="pr">
						<OPTION value="0"><? echo _SELECT_SUB ?></OPTION><?
				if($rubx != ""):
					$pse = mysql_query("SELECT * FROM uniletim_subsections WHERE sub_section = '$rub' AND ul_group = '$sess[4]' ORDER BY sub_name");
					while ( $row = mysql_fetch_row($pse)):?>
						<OPTION value="<? echo "$row[0]";?>"<?if ($row[0] == $pri) { echo " selected";}?>><? echo "$row[1]";?></OPTION>\n";<?
					endwhile;
				else:
					$pse = mysql_query("SELECT * FROM uniletim_subsections WHERE ul_group = '$sess[4]' ORDER BY sub_section");
					while ( $row = mysql_fetch_row($pse)):
						$psr = mysql_query("SELECT * FROM uniletim_sections WHERE sec_id = '$row[2]' AND ul_group = '$sess[4]'");
						$ror = mysql_fetch_row($psr);?>
						<OPTION value="<? echo "$row[0]";?>"<?if ($row[0] == $sker[3]) { echo " selected";}?>><? echo "$ror[1] - $row[1]";?></OPTION>\n";<?
					endwhile;
				endif;	?>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td class="form-i-name">
				<b><? echo _VALIDITY ?>:</b>
			</td>
			<td><?
				if ($sker[5] == "0000-00-00" || $sker[5] >= "2007-01-01"):
					$sker[5] = _TO_CANCEL;
				endif;
				echo "$sker[5]";?>
			</td>
		</tr>
		<tr>
			<td class="form-i-name">&nbsp;</td>
			<td>
				<select name="ponuka_dopyt">
					<OPTION value="0"><? echo _SELECT ?></OPTION>
					<OPTION value="ponuka"<? if ($sker[9] == "ponuka") { echo " selected";} ?>><? echo _OFFER ?></OPTION>
					<OPTION value="dopyt"<? if ($sker[9] == "dopyt") { echo " selected";} ?>><? echo _QUERY ?></OPTION>
				</SELECT>
			</td>
		</tr><?
	if ($sess[3] != "timebank"):?>
		<tr>
			<td class="form-i-name">
				<b><? echo _PRICE ?>:</b>
			</td>
			<td>
				<INPUT TYPE="text" NAME="cena" SIZE="10" value="<? echo "$sker[8]";?>"> <? echo _UNITS . " (0 = " . _GIFT . ")" ?>
			</td>
		</tr><?
	endif;?>
		<tr>
			<td class="form-i-name">&nbsp;    		</td>						
			<td>
				<input type="hidden" name="edid" value="<? echo "$sker[0]";?>">
				<input type="hidden" name="uoz" value="<? echo "$sker[1]";?>">
				<input type="hidden" name="perms" value="user">
				<INPUT TYPE="submit" NAME="pridaj" VALUE="<? echo _CHANGE ?>">
			</td>
		</tr>
	</FORM>		
	</TABLE>
	</div>
<?
}


// SELECTED ANNOUNCES
function announces_selected ($sess,$rub,$pri,$keyword,$age,$page) {

	global $welcome_call,$view;
	
	if (!IsSet($age)) $age = "2000";
	$pag = $page + 1;

	// select extract - sections, subsections
	if($pri != ""):
		$rubsel = "ann_sub = '$pri'";
		$sql = mysql_query("SELECT * FROM uniletim_subsections WHERE sub_id = '$pri' AND ul_group = '$sess[4]'");
		$sub_row = mysql_fetch_row($sql);
		$prn = $sub_row[1];
		$rub = $sub_row[2];
		$sql = mysql_query("SELECT * FROM uniletim_sections WHERE sec_id = '$rub' AND ul_group = '$sess[4]'");
		$sec_row = mysql_fetch_row($sql);
		$rn = $sec_row[1];
		$is_H3 = "<a href=index.php?rub=$sec_row[0]>$sec_row[1]</a>&nbsp;>&nbsp;<a href=index.php?rub=$sec_row[0]&pri=$sub_row[0]>$sub_row[1]</a>&nbsp;>&nbsp;$pag";

	elseif($rub != ""):
		$rubsel = "ann_sec = '$rub'";

		$sql = mysql_query("SELECT * FROM uniletim_sections WHERE sec_id = '$rub' AND ul_group = '$sess[4]'");
		$sec_row = mysql_fetch_row($sql);
		$rn = $sec_row[1];
		$is_H3 = "<a href=index.php?rub=$sec_row[0]>$sec_row[1]</a>&nbsp;>&nbsp;$pag";

	else:
		if($keyword != ""):
		$sa = _SELECTED_ANNO;
		$is_H3 = "$sa&nbsp;>&nbsp;$pag";
		else:
			@$sql_user = mysql_query("SELECT * FROM uniletim_members WHERE mbr_id = '$sess[2]'");
	    	$row_user = mysql_fetch_row($sql_user);
			$wel = "<b>$row_user[1]</b>$welcome_call<br>";
		endif;

		$rubsel = "ann_text like '%'";
	endif;
			$agesec = Time()-$age*24*3600;
			$agesel = "ann_date >= '$agesec'";
			$keysel = "ann_text like '%$keyword%'";

			$select = "$agesel AND $keysel AND $rubsel";	


	//numbers of table colums
	$cs = "4";
	$cs1 = "3";

	$menu= "ann";
	page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page);

	page_result_error ($result,$error);

	// welcome call
	if($wel == "d"):?>
		<div  class="content-noborder">	<?
			echo $wel;?>
		</div><?
	endif;

	if($age != "2000" || $keyword != ""):?>
		<div  class="search">
			<?if($keyword != ""): echo _KEYWORD_R;?>:&nbsp;<? echo $keyword; ?> &nbsp;<?endif;?>
			<?if($age != "" & $age != "2000"): echo _AGE_R;?>:&nbsp;<? echo $age; endif;?>
		</div><?
	endif;

	if($rub != "" || $pri != ""):
	// subsections
		announces_subsections ($sess,$rub,$pri,$cs,$cs1);

	// news
	else:	
		announces_sections ($sess,$rub);
	
	endif;
	
  if($sess[3] == "d" & $rub == ""):	?>
	<div  class="content-border">
	 <table cellspacing="0" class="content" cellspacing="0"><?
		$lres = _NEWS;
		$dopon = "news";
 		$view_number = 10; // number of listed items
		announces_listing ($sess,$dopon,$select,$lres,$view_number,$page,$cs,$cs1,$uoz,$rub,$pri,$keyword,$age);?>
	 </table>
	</div><?
 endif;
  ?>

	<div  class="content-border">
	 <table cellspacing="0" class="content" cellspacing="0"><?
		$view_number = 10; // number of listed items
 
		if($tbp != "dop"):
		// offers
			$lres = _OFFER;
			$dopon = "ponuka";
			if($view == "admin"):
				$view_number = 30;
				announces_listing_admin ($sess,$dopon,$select,$lres,$view_number,$page,$cs,$cs1,$uoz,$rub,$pri,$keyword,$age);
			else:
				announces_listing ($sess,$dopon,$select,$lres,$view_number,$page,$cs,$cs1,$uoz,$rub,$pri,$keyword,$age);
			endif;
		endif;?>
	 </table>
	</div>
	
	<div  class="content-border">
	 <table cellspacing="0" class="content" cellspacing="0"><?
		if($tbp != "pon"):
		// queries
			$lres = _QUERY;
			$dopon = "dopyt";
			if($view == "admin"):
				$view_number = 30;
				announces_listing_admin ($sess,$dopon,$select,$lres,$view_number,$page,$cs,$cs1,$uoz,$rub,$pri,$keyword,$age);
			else:
				announces_listing ($sess,$dopon,$select,$lres,$view_number,$page,$cs,$cs1,$uoz,$rub,$pri,$keyword,$age);
			endif;
		endif;?>
	 </table>
	</div>

	<div  class="content-border">
	 <table cellspacing="0" class="content" cellspacing="0">
		<thead>
		  <tr class="th_main">
			<form method="post" action="index.php">
			<th colspan="<? echo $cs1; ?>">
				<input type="text" name="keyword" size="10" maxlength="40">
				<select name="rub">
							<OPTION value=""<?if ($row[0] == $rub) { echo " selected";}?>><? echo _ALL ?></OPTION><?
					 $sql = mysql_query("SELECT * FROM uniletim_sections where ul_group = '$sess[4]'");
						if (mysql_num_rows ($sql)):
						while ($row = mysql_fetch_row($sql)): ?>
							<OPTION value="<? echo "$row[0]";?>"<?if ($row[0] == $rub) { echo " selected";}?>><? echo "$row[1]";?></OPTION><?
						endwhile;
						endif;?>
				</select>
				<select name="age">
					<OPTION value="2000"><? echo _NO_LIMIT ?></OPTION>
					<OPTION value="1"<?if ($age == "1") { echo " selected";}?>><? echo _1DAY ?></OPTION>
					<OPTION value="3"<?if ($age == "3") { echo " selected";}?>><? echo _3DAYS ?></OPTION>
					<OPTION value="7"<?if ($age == "7") { echo " selected";}?>><? echo _WEEK ?></OPTION>
					<OPTION value="14"<?if ($age == "14") { echo " selected";}?>><? echo _2WEEKS ?></OPTION>
					<OPTION value="31"<?if ($age == "31") { echo " selected";}?>><? echo _MONTH ?></OPTION>
					<OPTION value="92"<?if ($age == "92") { echo " selected";}?>><? echo _3MONTHS ?></OPTION>
				</SELECT>
				<input type="submit" value="<? echo _SEARCH ?>">
			</th>
			</form>
			<th align="right">
				<b><a target="_blank" href="index.php?action=print&rub=<? echo "$rub"; ?>&pri=<? echo "$pri"; ?>&keyword=<? echo "$keyword"; ?>&age=<? echo "$age"; ?>"><? echo _PRINT ?></a></b>
			</th>
		  </tr>
		</thead>
	 </table>
	</div>
	<?

}


// USERS ANNOUNCES
function announces_user ($sess,$uoz,$anned,$page) {

	// procesing data from forms
	if ($edid != "" || $did != ""):
		include "./o_post.php";
	endif;

	// user
	if (!IsSet($uoz)):
		$uoz = $sess[2];
	endif;
	
	// number of table columns	
	if ($sess[3] != "timebank"):
		$cs = "6";
		$cs1 = "5";
	else:
		$cs = "6";
		$cs1 = "5";
	endif;

	// secect user name
	@$uss = mysql_query("SELECT * FROM uniletim_members WHERE mbr_id = '$uoz'");
    $usv = mysql_fetch_row($uss);

	$select = "ann_member = '$uoz'";

	// number of listed items
	$view_number = 15;

	$menu= "ann";
	page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page);

	page_result_error ($result,$error);

	if ($sess[3] == "lets" & $uoz == $sess[2]):
	?>

	<div  class="content-border">
	 <table cellspacing="0" class="content"><?
		// list of news
		$lres = _NEWS;
		$dopon = "news";
		announces_listing ($sess,$dopon,$select,$lres,$view_number,$page,$cs,$cs1,$uoz,$rub,$pri,$keyword,$age);?>
	 </table>
	</div><?

	endif;	?>

	<div  class="content-border">
	 <table cellspacing="0" class="content"><?
		// list of offers
		$lres = _OFFER;
		$dopon = "ponuka";
		announces_listing ($sess,$dopon,$select,$lres,$view_number,$page,$cs,$cs1,$uoz,$rub,$pri,$keyword,$age);?>
	 </table>
	</div>

	<div  class="content-border">
	 <table cellspacing="0" class="content"><?
		// list of query
		$lres = _QUERY;
		$dopon = "dopyt";
		announces_listing ($sess,$dopon,$select,$lres,$view_number,$page,$cs,$cs1,$uoz,$rub,$pri,$keyword,$age);?>
	 </table>
	</div>
	
	<div  class="content-border">
	 <table cellspacing="0" class="content">
		<thead>
		  <tr class="th_main">
			<th><b><a target="_blank" href="index.php?action=print&uoz=<? echo "$uoz"; ?>"><? echo _PRINT ?></a></b></th>
			<th colspan="<? echo $cs1; ?>">&nbsp;</th>
		  </tr>
		</thead>
	 </table>
	</div>

<?
}




// LIST OF ANNOUNCES
function announces_listing ($sess,$dopon,$select,$lres,$view_number,$page,$cs,$cs1,$uoz,$rub,$pri,$keyword,$age) {

	// dark row - name
	?>
		<col class="col_1">
		<col class="col_2">
		<col class="col_3">
		<col class="col_4">
		<col class="col_5">
		<thead>
		  <tr class="th_main">
			<th><? echo $lres; ?></td>
			<th colspan="<? echo $cs1; ?>">&nbsp;</td>
		  </tr>
		</thead>
    <?
	$start = $page*$view_number; //first announce for view
	$sort= "ann_oq = '$dopon' and $select"; // mysql query

	// query for announces
	@$sqo = mysql_query("SELECT * FROM uniletim_announces WHERE $sort AND ul_group = '$sess[4]' ORDER BY ann_date DESC LIMIT $start,$view_number") or die($query_error);
		if (mysql_num_rows($sqo) == 0):
			echo "<tr><td>". _NO_ANNOUNCE . "</td></tr>\n";
		else:
			$i = 0;
			while ($roz = mysql_fetch_row($sqo))
				{
				if ($i%2==0) $tb_class=''; else $tb_class=" class=tb_dark";

				// announce content
				?>
			<tbody <? echo $tb_class; ?>>
				<tr class="tb_content" <? echo $bgcolor; ?>>
					<td colspan="<? echo $cs; ?>">
						<? echo $roz[7];?>
					</td>
				</tr><?
				// announce info
					?>
				<tr class="tb_info"><?
				// author
				if ($uoz == ""):?>
					<td>
						<B><? echo _FROM ?>:&nbsp;</B><?
						If ($auth != "0"):
							member_link ($roz[1]);
						else:
							member_name ($roz[1]);
						endif;?>
					</td><?
				endif;?>
					<td>
						<? $timed = Date("d.m.Y", $roz[4]); echo "$timed";?>
					</td><?

				// news
				if ($dopon == "news"):?>
					<td>&nbsp;</td>
					<td>&nbsp;</td>	<?
				else:?>
					<td>&nbsp;<?
						If ($pri == ""):?>
						<B><? echo _SUBSECTION ?>: </B><?
						page_subsection ($roz[3],$auth,$sess);
						endif;?>
					</td><?

				// timebank (no price)
				If ($sess[3] == "timebank"):?>
					<td>&nbsp;</td><?
				// normal
				else:?>
					<td align="right">
						<B><? echo _PRICE ?>: </B><? echo "$roz[8]";?>
					</td> <?
				endif;
				endif;
				// edit or delete announce
				if ($uoz != ""):
				if ($sess[5] >= "2" || $uoz == $sess[2]):?>
		           	<td width="50" align=center<? echo $bgcolor; ?>>
						<A HREF="index.php?action=form&type=edit&eid=<? echo "$roz[0]";?>"><? echo _CHANGE ?></A>
                  	</td>
		       		<td width="50" align=center<? echo $bgcolor; ?>>
						<A HREF="index.php?action=user&type=delete&did=<? echo "$roz[0]";?>" onclick="return confirm('<? echo _RLY_DLT_ANNO ?>')"><? echo _DELETE ?></A>
        			</b></td><?
				endif;
				endif;?>
				  </tr>
				</tbody>
			<?
			if ($i == 10) { break; }
			$i++;
		}
		endif;
?>
		<tfoot>
		  <tr class="th_sub">
			<th><?
				If ($sess[5] >= "2" & $usoz != ""):?>
					<a HREF="index.php?action=form&type=new&dp=<? echo "$dopon"; ?>&rub=<? echo "$rub"; ?>&pri=<? echo "$pri"; ?>&a_id=<? echo "$uoz"; ?>"><? echo _INSERT ?></A><?
  				else:?>
					<a HREF="index.php?action=form&type=new&dp=<? echo "$dopon"; ?>&rub=<? echo "$rub"; ?>&pri=<? echo "$pri"; ?>"><? echo _INSERT ?></A><?
				endif;?>
			</th>
			<th colspan="<? echo $cs1; ?>"align="right">
				<?
				// paging of extracts
				$id = "ann_id";
				$table = "uniletim_announces";

				if (IsSet($uoz)):
					$link= "index.php?action=user&uoz=$uoz&page=";
				elseif (IsSet($pri)):
					$link= "index.php?rub=$rub&pri=$pri&page=";
				else:
					$link= "index.php?rub=$rub&keyword=$keyword&age=$age&page=";
				endif;

				page_counter ($id,$table,$sort,$view_number,$sess,$link,$i,$page);?>
				|
  			</th>
		  </tr>
		</tfoot>

<?
}


// ADMINS LIST OF ANNOUNCES
function announces_listing_admin ($sess,$dopon,$select,$lres,$view_number,$page,$cs,$cs1,$uoz,$rub,$pri,$keyword,$age) {

		$cs = "4";
		$cs1 = "3";
		
	// dark row - name
	?>
		<col class="col_1">
		<col class="col_2">
		<col class="col_3">
		<col class="col_4">
		<col class="col_5">
		<thead>
		  <tr class="th_main">
			<th><? echo $lres; ?></td>
			<th colspan="<? echo $cs1; ?>">&nbsp;</td>
		  </tr>
		</thead>
    <?
	$start = $page*$view_number; //first announce for view
	$sort= "ann_oq = '$dopon' and $select"; // mysql query

	// query for announces
	@$sqo = mysql_query("SELECT * FROM uniletim_announces WHERE $sort AND ul_group = '$sess[4]' ORDER BY ann_date DESC LIMIT $start,$view_number") or die($query_error); 
		if (mysql_num_rows($sqo) == 0):
			echo "<tr><td>". _NO_ANNOUNCE . "</td></tr>\n";
		else:
			$i = 0;
			while ($roz = mysql_fetch_row($sqo))
				{
					@$sqp = mysql_query("SELECT * FROM uniletim_subsections WHERE sub_id = '$roz[3]' AND ul_group = '$sess[4]'");
					$rop = mysql_fetch_row($sqp);
				if ($i%2==0) $tb_class=''; else $tb_class=" class=tb_dark";

					// announce text
					?>
				<tbody <? echo $tb_class; ?>>
					<tr class="tb_content" <? echo $bgcolor; ?>>
						<td colspan="<? echo $cs1; ?>">
							<? echo $roz[7];?>
						</td>
						<td align="right" <? echo $bgcolor; ?>>
							<B><? echo _FROM ?>:</B><br />
							<? member_link ($roz[1]); ?>
						</td>
					</tr>
					<tr class="tb_info">
					<form method="post" action="index.php"> 
						<td align="right" <? echo $bgcolor; ?>>
							<select name="ann_sub" class="paticka">
								<OPTION value="0"><? echo _SELECT_SUB ?></OPTION><?
									$pse = mysql_query("SELECT * FROM uniletim_subsections WHERE ul_group = '$sess[4]' ORDER BY sub_section");
										while ( $row = mysql_fetch_row($pse)):
											$psr = mysql_query("SELECT * FROM uniletim_sections WHERE sec_id = '$row[2]' AND ul_group = '$sess[4]'");
											$ror = mysql_fetch_row($psr);?>
								<OPTION value="<? echo "$row[0]";?>"<?if ($row[0] == $roz[3]) { echo " selected";}?>><? echo "$ror[1] - $row[1]";?></OPTION><?
										endwhile;?>
							</select>
					</td>
		            <td align="right" <? echo $bgcolor; ?>>
		            		<input type="hidden" name="rub" value="<? echo $rub; ?>"> 
		            		<input type="hidden" name="pri" value="<? echo $pri; ?>"> 
		            		<input type="hidden" name="view" value="admin"> 
		            		<input type="hidden" name="sedid" value="<? echo $roz[0]; ?>"> 
								<input type="submit" class="paticka" value="<? echo _CHANGE . " " . _SUBSECTION ?>"> 
						</td>
                 </form> 		
                <form method="post" action="index.php?action=form&type=edit"> 				 
		       			<td align="right" <? echo $bgcolor; ?>>
								<input type="hidden" name="eid" value="<? echo $roz[0]; ?>"> 
								<input type="submit" class="paticka" value="<? echo _CHANGE ?>"> 
        				</b></td>
        				</form>
                  <form method="post" action="index.php?rub=<? echo "$rub"; ?>&pri=<? echo "$pri"; ?>&view=admin"> 				 
		       			<td align="right" <? echo $bgcolor; ?>>
								<input type="hidden" name="did" value="<? echo $roz[0]; ?>"> 
								<input type="submit" class="paticka" value="<? echo _DELETE ?>" onclick="return confirm('<? echo _RLY_DLT_ANNO ?>')"> 
        				</b></td>
        				</form>
         			</tr>
					<?
					if ($i == 10) { break; }
					$i++;
				}
		endif;
?>
		<tfoot>
		  <tr class="th_sub">
			<th><?
				If ($sess[5] >= "2" & $usoz != ""):?>
					<a HREF="index.php?action=form&type=new&dp=<? echo "$dopon"; ?>&rub=<? echo "$rub"; ?>&pri=<? echo "$pri"; ?>&a_id=<? echo "$uoz"; ?>"><? echo _INSERT ?></A><?
  				elseIf ($sess[5] >= "2" & $dopon == "news"):?>
					<a HREF="index.php?action=form&type=new&dp=<? echo "$dopon"; ?>"><? echo _INSERT ?></A><?
				else:?>
					<a HREF="index.php?action=form&type=new&dp=<? echo "$dopon"; ?>&rub=<? echo "$rub"; ?>&pri=<? echo "$pri"; ?>"><? echo _INSERT ?></A><?
				endif;?>
			</th>
			<th colspan="<? echo $cs1; ?>"align="right"><?
				// paging of extracts
				$id = "ann_id";
				$table = "uniletim_announces";

				if (IsSet($uoz)):
					$link= "index.php?action=user&uoz=$uoz&page=";
				elseif (IsSet($pri)):
					$link= "index.php?rub=$rub&pri=$pri&page=";
				else:
					$link= "index.php?rub=$rub&keyword=$keyword&age=$age&view=$view&page=";
				endif;

				page_counter ($id,$table,$sort,$view_number,$sess,$link,$i,$page);?>
				|
  			</th>
		  </tr>
		</tfoot>

<?
}

// LIST OF SECTIONS
function announces_sections ($sess,$rub) {

	@$sqk = mysql_query("SELECT S.*,count(D.ann_id) FROM uniletim_sections S 
	    LEFT JOIN uniletim_announces D ON S.sec_id=D.ann_sec 
	    WHERE S.ul_group = '$sess[4]' GROUP BY S.sec_id ORDER BY S.sec_name");
	$pocet = mysql_NumRows($sqk);?>

	<div  class="content-subsections"><?

				$i = 0;
				while ($rok = mysql_fetch_row($sqk)): 
					if ($i != "0"):?>
						&nbsp;|&nbsp;
					<?endif;		
					if ($pri != $rok[0]):?>
						<a href="index.php?rub=<? echo "$rok[0]"; ?>&tbp=<? echo "$tbp"; ?>"><? echo $rok[1]; ?></a>&nbsp;(<? 
					else:
						echo "<b class=error>$rok[1]</b>&nbsp;(";
					endif;						
					if ($sess[5] >= "2"): ?>
							<a href="index.php?rub=<? echo "$rok[0]"; ?>&view=admin"><? echo $rok[4]; ?></a><?
					else: 
							echo $rok[4]; 
					endif;?>
						)<?

					$i++;
				endwhile;
				?>	
	</div>
<?
}


// LIST OF SUBSECTIONS
function announces_subsections ($sess,$rub,$pri,$cs,$cs1) {

	@$sqk = mysql_query("SELECT S.*,count(D.ann_id) FROM uniletim_subsections S 
	    LEFT JOIN uniletim_announces D ON S.sub_id=D.ann_sub 
	    WHERE S.sub_section='$rub' AND S.ul_group = '$sess[4]' GROUP BY S.sub_id ORDER BY S.sub_name");
	$pocet = mysql_NumRows($sqk);?>

	<div  class="content-subsections"><?

				$i = 0;
				while ($rok = mysql_fetch_row($sqk)): 
					if ($i != "0"):?>
						&nbsp;|&nbsp;
					<?endif;		
					if ($pri != $rok[0]):?>
						<a href="index.php?rub=<? echo "$rub"; ?>&pri=<? echo "$rok[0]"; ?>&tbp=<? echo "$tbp"; ?>"><? echo $rok[1]; ?></a>&nbsp;(<? 
					else:
						echo "<b class=error>$rok[1]</b>&nbsp;(";
					endif;						
					if ($sess[5] >= "2"): ?><a href="index.php?rub=<? echo "$rub"; ?>&pri=<? echo "$rok[0]"; ?>&view=admin"><? echo $rok[4]; ?></a><?
					else: 
							echo $rok[4]; 
					endif;?>)<?

					$i++;
				endwhile;
				if ($tbp != ""): ?>
					<br><a href="index.php?rub=<? echo "$rub"; ?>&pri=all&tbp=<? echo "$tbp"; ?>"><? echo _ALL ?></a>&nbsp;|&nbsp;
				<?else: ?>
					<br><a href="index.php?rub=<? echo "$rub"; ?>&pri=all"><? echo _ALL ?></a>	&nbsp;|&nbsp;
					<a href="index.php?rub=<? echo "$rub"; ?>&pri=<? echo "$pri"; ?>&action=print"><? echo _PRINT ?></a>
				<?endif;
				if ($sess[5] >= "2"): ?>
					&nbsp;|&nbsp;
					<a href="r_pr_zmena.php?rub=<? echo "$rub"; ?>"><? echo _CHANGE ?></a><?
				endif;?>	
	</div>
<?
}


	
?>

