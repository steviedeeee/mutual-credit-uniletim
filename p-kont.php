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
 	<td class="form-i-name"><? echo _SERVICE_PROVIDER ?>:</td>
	<td><? member_link_full ($komuf); ?></td>
 </tr>
  <?if ($sess[5] >= "2"):?>
  <tr>
 	<td class="form-i-name"><? echo _SERVICE_RECIPIENT ?>:</td>
	<td><? member_link_full ($ktof); ?></td>
 </tr>
 <?endif;?>
 <tr>
 	<td class="form-i-name">
	<? if ($sess[3] == "timebank") { echo _HOURS;}
	else { echo _UNITS;}?>:
	</td>
	<td><?echo $kolkof;?></td>
 </tr>

 <tr>
	<td class="form-i-name"><? echo _SERVICE ?>:</td>
	<td><?echo $zacof;?></td>
  </tr>
  
 <tr>
 	<td></td>
 	<td>
<a href="p-post.php?&write=auth&action=write&komuf=<? echo "$komuf"; ?>&ktof=<? echo "$ktof"; ?>&kolkof=<? echo "$kolkof"; ?>&zacof=<? echo "$zacof"; ?>&lgr=<? echo "$sess[4]"; ?>"><? echo _CONFIRM ?></a>
&nbsp;I&nbsp;<a href="platby.php?&write=&action=write&komuf=<? echo "$komuf"; ?>&ktof=<? echo "$ktof"; ?>&kolkof=<? echo "$kolkof"; ?>&zacof=<? echo "$zacof"; ?>"><? echo _CHANGE ?></a>
&nbsp;I&nbsp;<a href="platby.php"><? echo _CANCEL ?></a>
	</td>
 </tr>
</table>
</div>

