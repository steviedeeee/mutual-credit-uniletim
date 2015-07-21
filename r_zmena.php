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


include "./r_post.php"; 
                 
 
// page header 
head ($sess,$x,$auth,$design,$menu); 


@$sql = mysql_query("SELECT S.*,count(D.ann_id) FROM uniletim_sections S 
                     LEFT JOIN uniletim_announces D ON S.sec_id=D.ann_sec WHERE S.ul_group = '$sess[4]' 
                     GROUP BY S.sec_id ORDER BY S.sec_name"); 
 
if (mysql_num_rows($sql) == 0) 
{ 
   $error = "<h3><b>" . _NO_SECTION . "</b></h3>\n"; 
}
$loc_page = _SECTIONS ;
page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page);
page_result_error ($result,$error);?>

<div  class="content-border">
	<table cellspacing="0" class="content">
	  	<thead>
      		<tr class="th_main">
      	    	 <th align=left colspan="5" class="td_tmave">
       	     	    <? echo _NEW_SECTION ?>
      			</th>
       		</tr>
		<thead>
        <tbody>
            <tr>
            <form method="post" action="r_zmena.php">
                <td COLSPAN=4>
                     <INPUT TYPE="TEXT" NAME="rni" MAXLENGTH="50" SIZE="13">
                </td>
                <td>
                     <input type="hidden" name="rz" value="i">
                     <input type="Submit" value="<? echo _CREATE ?>">
                </td>
            </form>
            </tr>
		</tbody>
		<thead>
            <tr class="th_main">
                <th colspan="5">
                     <? echo _CHANGE_SECTIONS ?>
                </th>
            </tr>
		</thead><?
   $i = 0; 
   while ($row = mysql_fetch_row($sql)) 
   { 
		if ($i%2==0) $tb_class=''; else $tb_class=" class=tb_dark";?>
		<tbody <? echo $tb_class; ?>>
			<tr>
              <form method="get" action="r_zmena.php">
                   <td>
                         <INPUT TYPE="TEXT" NAME="rne" MAXLENGTH="50" SIZE="13" value="<? echo $row[1]; ?>">
                    </td>
                    <td>
                          <? echo $row[4]; ?>
                    </td>
                    <td align=right >
                          <input type="hidden" name="rie" value="<? echo $row[0]; ?>">
                          <input type="hidden" name="rz" value="e">
                          <input type="Submit" value="<? echo _CHANGE ?>">
                    </td>
               </form>
 
               <form method="post" action="r_pr_zmena.php">
                     <td align=center height=15 <? echo $bgcolor; ?>>
                         <input type="hidden" name="rub" value="<? echo $row[0]; ?>">
                         <input type="submit" value="<? echo _SUBSECTIONS ?>">
                     </td>
               </form>
               <form method="post" action="r_zmena.php">
                     <td align=center height=15 <? echo $bgcolor; ?>>
                         <input type="hidden" name="rnd" value=<? echo $row[1]; ?>>
                         <input type="hidden" name="rid" value=<? echo $row[0]; ?>>
                         <input type="hidden" name="rz" value="d">
                       <?if($row[4] == "0"):?>
                         <input type="submit" value="<? echo _DELETE ?>" onclick="return confirm('<? echo _RLY_DLT_SCTN ?>')">
                       <?endif;?>
                     </td>
				</tbody>
               </form>
           </tr>
   <? 
           $i++;
   } ?>
           </TABLE>
		</div>

<? 
// page footer 
foot ($sess,$menu);
?> 
