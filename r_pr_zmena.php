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
if (!$menu) $menu = "adm"; //selecting of location menu


include "./r_pr_post.php"; 
 
 
// page header 
head ($sess,$x,$auth,$design,$menu); 


			$sql = mysql_query("SELECT * FROM uniletim_sections WHERE sec_id = '$rub' AND ul_group = '$sess[4]'"); 
			$row = mysql_fetch_row($sql); 
			$rn = $row[1]; 
 
					@$sql = mysql_query("SELECT S.*,count(D.ann_id) FROM uniletim_subsections S 
					LEFT JOIN uniletim_announces D ON S.sub_id=D.ann_sub 
					WHERE S.sub_section='$rub' AND S.ul_group = '$sess[4]' GROUP BY S.sub_id ORDER BY S.sub_name"); 
 
			if (mysql_num_rows($sql) == 0) 
			{ 
				$error = _NO_SUBSECTION; 
			} 
 



 $loc_page = "$rn: " . _SUBSECTION ;
page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page);
page_result_error ($result,$error);?>

<div  class="content-border">
	<table cellspacing="0" class="content">
	  	<thead>
      		<tr class="th_main">
      	    	 <th align=left colspan="5" class="td_tmave">
       	     	    <? echo _NEW_SUNSECTION ?>
      			</th>
       		</tr>
		<thead>
			<TR> 
	<form method="post" action="r_pr_zmena.php"> 
									<td COLSPAN=3 height=19> 
									<INPUT TYPE="TEXT" NAME="prni" MAXLENGTH="50" SIZE="13"> 
									</td> 
					<td height=19 align=center > 
											<input type="hidden" name="rub" value="<? echo $rub; ?>"> 
											<input type="hidden" name="prz" value="i"> 
											<input type="Submit" value="<? echo _CREATE ?>"> 
		</td> 
				</form> 
			</TR> 
													<TR class="th_main">
											<Th align=left colspan="4" class="td_tmave">
							<? echo _CHANGE_SUBSECTIONS ?> 
				</Th>
			</TR> 
	<? 
	$i = 0; 
	while ($row = mysql_fetch_row($sql)) 
	{ 
				if ($i%2==0) $bgcolor=''; else $bgcolor=" bgcolor=#DEDEDE"; 
?> 
			<tr <? echo $bgcolor; ?>> 
	<form method="post" action="r_pr_zmena.php"> 
									<td height=19> 
									<INPUT TYPE="TEXT" NAME="prne" MAXLENGTH="50" SIZE="13" value="<? echo $row[1]; ?>"> 
									</td> 
									<td height=19 align=center> 
									<? echo $row[4]; ?> 
									</td> 
					<td height=19 align=right > 
									<input type="hidden" name="rub" value="<? echo $rub; ?>"> 
											<input type="hidden" name="prie" value="<? echo $row[0]; ?>"> 
											<input type="hidden" name="prz" value="e"> 
											<input type="Submit" value="<? echo _CHANGE ?>"> 
		</td> 
				</form> 
																<form method="post" action="r_pr_zmena.php"> 
								<td align=center height=15 <? echo $bgcolor; ?>> 
									<input type="hidden" name="rub" value="<? echo $rub; ?>"> 
							<input type="hidden" name="prnd" value="<? echo $row[1]; ?>"> 
								<input type="hidden" name="prid" value="<? echo $row[0]; ?>"> 
							<input type="hidden" name="prz" value="d"> 
<?if($row[4] == "0"):?> 
					<input type="submit" value="<? echo _DELETE ?>" onclick="return confirm('<? echo _RLY_DLT_SUBSCTN ?>')"> 
<?endif;?> &nbsp; 
				</td> 
			</form> 
	</tr> 
	<? 
 
	$i++; 
	} 
 
 
?> 

</TABLE>
</TD></TR></TABLE>
<br><br>

<? 
// page footer 
foot ($sess,$design); 
?> 
