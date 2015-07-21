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



// ANNOUNCES - PRINTING
function announces_print ($sess,$uoz,$rub,$pri,$keyword,$age) {

	// create header of page
	head_printing ();
	?>
	<table width="720" border="0" cellspacing="0" cellpadding="3" align="center">
	<?
	if($uoz != ""):
	// user listing of announces
			announces_print_selected ($sess,$keyword,$age,$uoz);

	elseif($keyword != "" || $age != ""):
	// selected announces
				
			$agesec = Time()-$age*24*3600;
			$agesel = "ann_date >= '$agesec'";
			$keysel = "ann_text like '%$keyword%'";
			$sel_keys = "$agesel AND $keysel";	
	
			@$sql_sub = mysql_query("SELECT count(ann_id) FROM uniletim_announces WHERE $sel_keys AND ul_group = '$sess[4]'");
		
			$row_sub = mysql_fetch_row($sql_sub);
			
			if ($row_sub[0] < 20):
				// listing of selected announces
				announces_print_selected ($sess,$keyword,$age,$uoz);
			else:
				// listing of subsections
				announces_print_subsections ($sess,$rub,$pri,$keyword,$age);
			endif;
	else:
			// listing of subsections
			announces_print_subsections ($sess,$rub,$pri,$keyword,$age);
	endif;

	// create footer of page
	foot_printing ($sess);
}


// LIST OF SELECTED SUBSECTIONS - PRINTING 
function announces_print_subsections ($sess,$rub,$pri,$keyword,$age) {

		if($rub != ""):
		// selected section	
			$sec_sel = "sec_id = '$rub'";
		else:
		// all
			$sec_sel = "sec_name like '%'";
		endif;
	
 	$sql_sec = mysql_query("SELECT * FROM uniletim_sections WHERE $sec_sel AND ul_group = '$sess[4]'");
	while ($row_sec = mysql_fetch_row($sql_sec)) 
		{
		$rub = $row_sec[0];
	
		if($pri != ""):
		// subsections
			$sub_sel = "S.sub_id='$pri'";
		else:
		// sections
			$sub_sel = "S.sub_section='$rub'";
		endif;
		
		// section name
 		$sql_head = mysql_query("SELECT * FROM uniletim_sections WHERE sec_id = '$rub' AND ul_group = '$sess[4]'");
		$row_head = mysql_fetch_row($sql_head);	
		?>

		<TR>
			<td colspan="3" class="dark">
				<h2><? echo $row_head[1]; ?></h2>
			</td>
		</TR>
	<?if($age != "" || $keyword != ""):?>
		<tr><td  colspan="3" class="row">
			<?if($keyword != ""): echo _KEYWORD_R;?>:&nbsp;<? echo $keyword; ?> &nbsp;<?endif;?>
			<?if($age != "" & $age != "2000"): echo _AGE_R;?>:&nbsp;<? echo $age; endif;?>
		</td></tr><?
	endif;?>
		<TR>   
			<td width="360"><b>
				<? echo _OFFER ?></b>
			</td>
			<td width="2" class="center">
				<img src="obr/plocha.gif" width="0" border="0" alt="" hspace="0" vspace="0">
			</td>
			<td width="360">
				<b><? echo _QUERY ?></b>
			</td>
		</TR>
			<?

	if($keyword != "" || $age != ""):
	// selected announces
				
		$agesec = Time()-$age*24*3600;
		$agesel = "D.ann_date >= '$agesec'";
		$keysel = "D.ann_text like '%$keyword%'";
		$sel_pr = "$agesel AND $keysel";	
	else:
		$sel_pr = "D.ann_text like '%'";	
	endif;

	//subsections
	@$sql_sub = mysql_query("SELECT S.*,count(D.ann_id) FROM uniletim_subsections S LEFT JOIN uniletim_announces D ON S.sub_id=D.ann_sub WHERE $sub_sel AND $sel_pr AND S.ul_group = '$sess[4]' AND D.ul_group = '$sess[4]' GROUP BY S.sub_id ORDER BY S.sub_name");
		
	while ($row_sub = mysql_fetch_row($sql_sub)) 
		{
			$sub_name = $row_sub[1];
			$sub_id = $row_sub[0];
			
			if ($row_sub[4] > 0):

					if($keyword != "" || $age != ""):
				// selected announces
					$rubsel = "D.ann_sub = '$sub_id'";
					$sel_ann = "$agesel AND $keysel AND $rubsel";
					
				elseif($uoz != ""):
				// user´s announces
					$sel_ann = "D.ann_member = '$uoz' AND D.ann_sub = '$sub_id'";
				else:
				// all
					$sel_ann = "D.ann_sub = '$sub_id'";
				endif;
?>
		<TR>   
			<td colspan="3" class="middle"><? echo $sub_name; ?></td>
		</TR>
		<TR>   
			<td valign="top"><?
				//offers
				$dopon = "ponuka";
				announces_print_listing ($sub_id,$sel_ann,$dopon,$uoz,$sess);
				?>	
			</td>
			<td class="center">
				<img src="obr/plocha.gif" width="0" border="0" alt="" hspace="0" vspace="0">
			</td>
			<td valign="top"><?
				// queries
				$dopon = "dopyt";
				announces_print_listing ($sub_id,$sel_ann,$dopon,$uoz,$sess);?>
			</td>
		</TR><?	
			endif;	
		}
	}
}


//SELECTED ANNOUNCES - PRINTING 
function announces_print_selected ($sess,$keyword,$age,$uoz) {

	if($uoz != ""):
	// user listing of announces
		$sql_head = mysql_query("SELECT * FROM uniletim_members WHERE mbr_id = '$uoz'");
		$row_head = mysql_fetch_row($sql_head);	
		// mysql query
		$sel_ann = "ann_member = '$uoz'";
		
	else:	
	// listing of selected announces
		$agesec = Time()-$age*24*3600;
		$agesel = "ann_date >= '$agesec'";
		$keysel = "ann_text like '%$keyword%'";
		// mysql query
		$sel_ann = "$agesel AND $keysel";	
	
	
	?>
		<TR class="dark">   
			<td colspan="3">
				<h2><? echo _SELECTED_ANNO ?></h25>
			</td>
		</TR>
		<tr><td  colspan="3" class="row">
			<?if($keyword != ""):?><b><? echo _USER;?>:</b>&nbsp;<? echo "$row_head[5] $row_head[4]"; ?> &nbsp;<?endif;?>
			<?if($keyword != ""):?><b><? echo _KEYWORD_R;?>:</b>&nbsp;<? echo $keyword; ?> &nbsp;<?endif;?>
			<?if($age != "" & $age != "2000"):?><b><? echo _AGE_R;?>:</b>&nbsp;<? echo $age; endif;?>
		</td></tr>
	<?endif;?>
		<TR>   
			<td width="360"><b>
				<? echo _OFFER ?></b>
			</td>
			<td width="2" class="center">
				<img src="obr/plocha.gif" width="0" border="0" alt="" hspace="0" vspace="0">
			</td>
			<td width="360">
				<b><? echo _QUERY ?></b>
			</td>
		</TR>
		<TR class="middle">   
			<td colspan="3">&nbsp;</td>
		</TR>
		<TR>   
			<td valign="top"><?
				//offers
				$dopon = "ponuka";
				announces_print_listing ($sub_id,$sel_ann,$dopon,$uoz,$sess);
				?>	
			</td>
			<td class="center">
				<img src="obr/plocha.gif" width="0" border="0" alt="" hspace="0" vspace="0">&nbsp;
			</td>
			<td valign="top"><?
				// queries
				$dopon = "dopyt";
				announces_print_listing ($sub_id,$sel_ann,$dopon,$uoz,$sess);?>
			</td>
		</TR>
<?				
}


//  LIST OF ANNOUNCES - PRINTING
function announces_print_listing ($sub_id,$sel_ann,$dopon,$uoz,$sess) {

	@$sql_ann = mysql_query("SELECT * FROM uniletim_announces D WHERE $sel_ann AND D.ann_oq = '$dopon' AND D.ul_group = '$sess[4]' ORDER BY D.ann_date");
	if (mysql_num_rows($sql_ann) > 0):?>
	
	<table width="360" border="0" cellspacing="0" cellpadding="3"><?
	
	$i = 0;
	while ($row_ann = mysql_fetch_row($sql_ann))
		{?>
		
		<TR>
			<TD class="row" class="row">
				<?
				 echo "$row_ann[7]";?>
			</td><?
		If ($sess[3] != "timebank"):?>	
			<TD width="30" align="right" valign="top" class="row">
				<? echo "$row_ann[8]";?>&nbsp;
			</td><?
		endif;?>				
			<td width="50" align="right" class="row"><?
			if($uoz == ""):
				member_name ($row_ann[1]);
			endif;?>
			</td>
		</TR><?
		
		$i++;
		}?>
	
	</table><?
	
	endif;	
}


	
?>

