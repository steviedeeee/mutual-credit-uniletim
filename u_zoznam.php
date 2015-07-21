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
include "language/lang-$lang.php";
include "./includes/members.inc.php";
include "./includes/page.inc.php";
if (!$menu) $menu = "mbr"; //selecting of location menu

if ($action == "print"):
//printing list of members
members_list_printing ($sess);

else:

if ($usname != "" || $nid != "")
{
include "./u_post.php";
}
// page header
head ($sess,$x,$auth,$design,$menu);

$result = "";
$error = "";
$ua = "";

if (!IsSet($order)) $order = "mbr_login";
if (!IsSet($adesc)) $adesc = "ASC";


if ($adesc == "ASC"):
  @$sqp = mysql_query("SELECT M.*, P.perm_group FROM uniletim_members M
        LEFT JOIN uniletim_perms P ON M.mbr_id = P.perm_member
        WHERE P.perm_group = '$sess[4]' AND M.mbr_state != 'd' ORDER BY '$order' ASC");
 $adesc = "DESC";
else:
  @$sqp = mysql_query("SELECT M.*, P.perm_group FROM uniletim_members M
        LEFT JOIN uniletim_perms P ON M.mbr_id = P.perm_member
        WHERE P.perm_group = '$sess[4]' AND M.mbr_state != 'd' ORDER BY '$order' DESC");
 $adesc = "ASC";
endif;

  if (mysql_num_rows($sqp) == 0)
        {
        $result = " ". _NO_USER . " \n";

 page_location_announces ($sess,$rub,$pri,$uoz,$eid,$loc_page);
 page_result_error ($result,$error);

        }
     else
        {

if ($sess[5] >= "2"):
$cs1 = " colspan=2";
$cs2 = " colspan=6";
else:
$cs1 = "";
$cs2 = " colspan=4";
endif;

 page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page);
 page_result_error ($result,$error);
?>
  <div class="content-border">
   <table class="content" cellspacing="0">
    <thead>
     <tr class="th_main">
      <th<? echo $cs2; ?>>
       <?php  echo _GROUP ?>: <?php
            $message = MySQL_Query("SELECT * FROM uniletim_groups WHERE grp_id = '$sess[4]'") or die($query_error); //vybíráme zprávy - seøazeno podle id
            $entry = MySQL_Fetch_Row($message);
            echo $entry[1]?>
      </th>
     </tr>
     <tr class="th_sub">
      <th class="uc1">
       <a href="u_zoznam.php?order=mbr_login&adesc=<?php  echo $adesc; ?>"><?php  echo _USER_NAME ?></a>
      </th>
      <th class="uc2">
       <a href="u_zoznam.php?order=mbr_name&adesc=<?php  echo $adesc; ?>"><?php  echo _NAME ?></a>
      </th>
      <th class="uc3">
       <a href="u_zoznam.php?order=mbr_surname&adesc=<?php  echo $adesc; ?>"><?php  echo _SURNAME ?></a>
      </thclass="uc4">
      <th align="right">
       <a href="u_zoznam.php"><?php  echo _ACCOUNT_STATUS ?></a>
      </th><?php 
         if ($sess[5] >= "2"):
           if ($sess[3] != "lets"):?>
      <th class="uc5">
        
      </th><?php 
           endif;?>
      <th class="uc6">
        
      </th><?php
         endif;?>
     </tr>
    </thead><?php 
       $i = 0;
       while ($row = mysql_fetch_row($sqp))
       {
		if ($i%2==0) $tb_class=''; else $tb_class=" class=tb_dark";?>
	<tbody <? echo $tb_class; ?>>
	<tr class="tb_content">
     <td>
      <a href="u_info.php?id=<?php echo $row[0]; ?>"><?php  echo $row[1]; ?></a>
     </td>
     <td>
      <?php  echo $row[5]; ?>
     </td>
     <td>
      <?php  echo $row[4]; ?>
     </td>
     <td align="right">
      <?php
            if ($sess[5] >= "2"){
           $mbr_id = $row[0];
           member_count_services ($mbr_id,$sess);
           echo " I ";
           member_count_announces ($mbr_id,$sess);
           echo " I ";
             }
           member_account ($mbr_id,$sess);?>
     </td><?php if ($sess[5] >= "2"):
           if ($sess[3] != "lets"):?>
     <td align="right">
      <a href="u_zmena.php?id=<?php echo $row[0]; ?>"><?php  echo _CHANGE ?></a>
     </td><?php endif;?>
     <td align="right">
      <a href="u_zoznam.php?nid=<?php echo $row[0]; ?>" onclick="return confirm('<?php  echo _RLY_DLT_MBR ?>')"><?php  echo _DELETE ?></a>
     </td><?php endif;?>
    </tr>
	</tbody><?php

              $i++;
       }



    ?>
	<tfoot>
    <tr class="th_sub">
     <th <? echo $cs2; ?>>
      <?php if ($sess[5] >= "2"):?><a href="u_novy.php"><?php  echo _NEW_MEMBER ?></a> <?php endif;?>  
     </th>
	</tr>
    <tr class="th_main">
     <th <? echo $cs2; ?>>
      <b><a class="tm" target="_blank" href="u_zoznam.php?action=print"><?php  echo _PRINT ?></a></b>
     </th>
    </tr>
	</tfoot>
   </table>
   </div><?php
   }

    // create footer of the page
    foot ($sess,$menu);
   endif;
   ?>
