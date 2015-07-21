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


		$sql = mysql_query("SELECT * FROM uniletim_sections WHERE sec_id = '$rub' AND ul_group = '$sess[4]'");
		$sec_row = mysql_fetch_row($sql);
		$rn = $sec_row[1];
?>
			
					<H3 class="tit1"><? echo "$rn";?>&nbsp;>&nbsp;<? echo _ALL ?></H3>
	  

			<table width="460" border="0" cellspacing="0" cellpadding="3">

                   <?
	//numbers of table colums
	$cs = "4";
	$cs1 = "3";
 
	// subsections
		announces_subsections ($sess,$rub,$pri,$cs,$cs1);

// vypis hlasiek	
if($result != "" || $error != ""):?>
			<tr><td>
				<div  class="res"><? echo "$result";?></div>&nbsp;<div  class="error"><? echo "$error";?></div>
			</td></tr>

<?endif;

// výpis ponúk  
if($tbp != "dop"): 
?>
			</TABLE>

	
	<table width="460" border="1" cellspacing="0" cellpadding="0" align="center">
		<TR><td>
			<table width="460" align="center" border="0" cellspacing="0" cellpadding="5">		
 
					<TR class="td_tmave">   
						<td colspan="4" class="td_tmave">Ponuka</td>
					</TR>
				 <?

					 	$sqk = mysql_query("SELECT * FROM uniletim_subsections WHERE sub_section='$rub' AND ul_group = '$sess[4]' ORDER BY sub_name");
                          while ($rok = mysql_fetch_row($sqk)) {

					    $rn = $rok[1];
						$pri = $rok[0];
						
                   @$sqo = mysql_query("SELECT * FROM uniletim_announces WHERE ann_sub = '$pri' AND ann_oq = 'ponuka' AND ul_group = '$sess[4]' ORDER BY ann_date ");
                        if (mysql_num_rows($sqo) > 0)
                           {
				  ?>
					<TR>   
						<td colspan="4">&nbsp;</td>
					</TR>
					<TR class="td_st">   
						<td colspan="2" class="td_st"><b><? echo "$rn";?></b></td>
					    <TD align=right height=16 class="td_st" noWrap>
					     <a HREF="o_novy.php?rub=<? echo "$rub"; ?>&pri=<? echo "$pri"; ?>&dp=ponuka"><? echo _INSERT ?></A>
					    </TD>
					</TR>
                 <?						   
                          $i = 0;
                          while ($roz = mysql_fetch_row($sqo))
                             {						
                    if ($i%2==0) $bgcolor=''; else $bgcolor=" class=td_rd";?>	
				  	<TR <? echo $bgcolor; ?>>			
				        <TD COLSPAN="3" class="hlavicka"><? echo "$roz[7]";?>
					</TR>
					<TR class="paticka" <? echo $bgcolor; ?>>   
						<td<? echo $bgcolor; ?>><B>Vlo¾il:</B> <A HREF="u_info.php?id=<? echo "$roz[1]";?>"><?
						  @$squ = mysql_query("SELECT * FROM uniletim_members WHERE mbr_id = '$roz[1]' AND ul_group = '$sess[4]'");
						  $rou = mysql_fetch_row($squ);
						  echo "$rou[1]";?></A></td>
						<td<? echo $bgcolor; ?>><? $timed = Date("d.m.Y", $roz[4]); echo "$timed";?></td>
						<td<? echo $bgcolor; ?>>&nbsp;
						<? if ($sess[3] != "timebank"):?>
						<B>Cena: </B><? echo "$roz[8]";?>
						<?endif;?>
						</td>
						</TR>
		
                  <?
                                $i++;
                              }
                           }
					 	}
?>

			</TABLE>
		</td></TR>
	</TABLE>
	
	<br><br>
	
 <?// výpis dopytov
endif; 
if($tbp != "pon"):?>
	<table width="460" border="1" cellspacing="0" cellpadding="0" align="center">
		<TR><td>
			<table width="460" align="center" border="0" cellspacing="0" cellpadding="5">		


					<TR class="td_tmave">   
						<td colspan="4" class="td_tmave">Dopyt</td>
					</TR>
                 <?
						
				   		$sqk = mysql_query("SELECT * FROM uniletim_subsections WHERE sub_section='$rub' AND ul_group = '$sess[4]' ORDER BY sub_name");
                          while ($rok = mysql_fetch_row($sqk)) {

					    $rn = $rok[1];
						$pri = $rok[0];
                   @$sqo = mysql_query("SELECT * FROM uniletim_announces WHERE ann_sub = '$pri' AND ann_oq = 'dopyt' AND ul_group = '$sess[4]' ORDER BY ann_date ");
                        if (mysql_num_rows($sqo) > 0)
                           {
                  ?>	
					<TR>   
						<td colspan="4">&nbsp;</td>
					</TR>
					<TR class="td_st">   
						<td colspan="2" class="td_st"><b><? echo "$rn";?></b></td>
					    <TD align=right height=16 class="td_st" noWrap>
					     <a HREF="o_novy.php?rub=<? echo "$rub"; ?>&pri=<? echo "$pri"; ?>&dp=dopyt"><? echo _INSERT ?></A>
					    </TD>
					</TR>
                  <?						   
                          $i = 0;
                          while ($roz = mysql_fetch_row($sqo))
                             {
							if ($i%2==0) $bgcolor=''; else $bgcolor=" class=td_rd";
                  ?>	
				  	<TR <? echo $bgcolor; ?>>			
				        <TD COLSPAN="3" class="hlavicka"><? echo "$roz[7]";?>
					</TR>
					<TR class="paticka">   
						<td<? echo $bgcolor; ?>><B>Vlo¾il:</B> <A HREF="u_info.php?id=<? echo "$roz[1]";?>"><?
						  @$squ = mysql_query("SELECT * FROM uniletim_members WHERE mbr_id = '$roz[1]' AND ul_group = '$sess[4]'");
						  $rou = mysql_fetch_row($squ);
						  echo "$rou[1]";?></A></td>
						 <td<? echo $bgcolor; ?>><? $timed = Date("d.m.Y", $roz[4]); echo "$timed";?></td>
						<td<? echo $bgcolor; ?>>&nbsp;
						<? if ($sess[3] != "timebank"):?>
						<B>Cena: </B><? echo "$roz[8]";?>
						<?endif;?>
						</td>
					</TR>
		
                  <?
                                $i++;
                              }
                           }

					 	}
endif;	  
				  ?>
			</TABLE>
		</td></TR>
	</TABLE>

