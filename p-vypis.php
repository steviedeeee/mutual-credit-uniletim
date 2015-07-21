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

$loc_page = _PAYMENTS ;
page_location_announces ($sess,$menu,$rub,$pri,$id,$eid,$loc_page);
page_result_error ($result,$error);?>

<form method="post">
<div  class="content-border">
<table cellspacing="0" class="content">
  <thead>
	<tr class="th_main">
		<th colspan="5">
		<?
	//zobrazujeme aktuální nebo staré zprávy
	if($what=="all"):
		echo _ALL_SERVICES;
		$sort = "ser_provider like '%'";
	else:
	  	echo "->> " . _PAYMENTS . ":" ;
		$sort = "to_date < NOW()";
	endif;

	$view_number = 10; //zpravy budou zobrazeny po ...
	$start = $page*$view_number; //prvni zprava, ktera se zobrazi
	
	if (!IsSet($order)) $order = "ser_time";
	if (!IsSet($adesc)) $adesc = "DESC";

	if ($adesc == "ASC"):
		$message = MySQL_Query("SELECT * FROM uniletim_services WHERE $sort AND ul_group = '$sess[4]' ORDER BY $order ASC LIMIT $start,$view_number") or die($query_error); //vybíráme zprávy - seøazeno podle id
		$adesc = "DESC";	
	else:
		$message = MySQL_Query("SELECT * FROM uniletim_services WHERE $sort AND ul_group = '$sess[4]' ORDER BY $order DESC LIMIT $start,$view_number") or die($query_error); //vybíráme zprávy - seøazeno podle id
		$adesc = "ASC";	
	endif;
	
	?>	 
	</th>
	</tr>
	<tr class="th_sub">
        <th width="70"><A HREF="platby.php?order=ser_time&adesc=<? echo $adesc; ?>"><? echo _DATE ?></A></th>
		<th width="60"><A HREF="platby.php?order=ser_recipient&adesc=<? echo $adesc; ?>"><? echo _SERVICE_RECIPIENT ?></A></th>
		<th width="60"><A HREF="platby.php?order=ser_provider&adesc=<? echo $adesc; ?>"><? echo _SERVICE_PROVIDER ?></A></th>
		<th width="230"><A HREF="platby.php?order=ser_service&adesc=<? echo $adesc; ?>"><? echo _SERVICE ?></A></th>
		<th width="70" align=right><A HREF="platby.php?order=ser_amount&adesc=<? echo $adesc; ?>"><? echo _AMOUNT ?></A></th>
	</tr>
  </thead>
 <?
 
 
  //vypiseme tabulky se zpravami
 $i = 0;
 while ($entry = MySQL_Fetch_Array($message)):
   if ($i%2==0) $tb_class=''; else $tb_class=" class=tb_dark"; ?>
   
	<tbody <? echo $tb_class; ?>>
	<tr <? echo $bgcolor; ?>>
		<td><? $ke = Explode("-", $entry[3]);
		    echo " ". $ke[2] . ". " . $ke[1] . ". " . $ke[0] . "";?></td>
		<td><? member_link ($entry[1]); ?></td>
		<td><? member_link ($entry[2]); ?></td>
		<td><? echo "$entry[4]";?></td>
		<td align=right><? echo "$entry[5]";?></td>
	</tr>
</tbody>
 <?$i++;
 endwhile;?>
<tfoot>
  <tr class="th_sub">
  <th colspan="3">
	  <a HREF="platby.php?action=write"><? echo _PAYING_ORDER ?></A>
  </th>
  <th colspan="2" align="right">
	<?
//odkazy na dalsie stranky vypisu
	if ($adesc == "ASC"):
		$adesc = "DESC";	
	else:
		$adesc = "ASC";	
	endif;


	$id = "ser_id";
	$table = "uniletim_services";
	$link= "platby.php?action=view&what=$what&order=$order&adesc=$adesc&page=";

	page_counter ($id,$table,$sort,$view_number,$sess,$link,$i,$page);
	?>
	|
  </th>
  </tr>
	<tr class="th_main">
		<th colspan="5"><a target="_blank" href="platby.php?action=print"><? echo _PRINT ?></a></th>
	</tr>	
</tfoot>
 </table>
</div>
