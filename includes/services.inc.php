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


//printing list of services
function services_list_printing ($sess,$what) {

// page header
head_printing ();

?>

	  <table width="650" border="0" cellspacing="0" cellpadding="3" align="center">

	<TR class="td_tmave">   
		<td colspan="5" class="dark">
		<h2><?
	//zobrazujeme aktuální nebo staré zprávy
	if($what=="all"):
		echo _ALL_SERVICES;
		$sort = "ser_recipient like '%'";
	else:
	  	echo "->> " . _PAYMENTS . ":" ;
		$sort = "to_date < NOW()";
	endif;
	?>	</h25> 
      </td>
  
   </TR>
   <TR class="middle">
        <TD width="100"><? echo _DATE ?></TD>
		<TD width="110"><? echo _SERVICE_RECIPIENT ?></TD>
		<TD width="110"><? echo _SERVICE_PROVIDER ?></TD>
		<TD><? echo _SERVICE ?></TD>
		<TD width="70" align=right><? echo _AMOUNT ?></TD>
	</TR>
 <?

 $message = MySQL_Query("SELECT * FROM uniletim_services WHERE $sort AND ul_group = '$sess[4]' ORDER BY ser_time DESC") or die($query_error); //vybíráme zprávy - seøazeno podle id

 //vypiseme tabulky se zpravami
 $i = 0;
 while ($entry = MySQL_Fetch_Array($message)):
   if ($i%2==0) $bgcolor=''; else $bgcolor=" class=row";
 ?>
	<TR <? echo $bgcolor; ?>>
		<td><? $ke = Explode("-", $entry[3]);
		    echo " ". $ke[2] . ". " . $ke[1] . ". " . $ke[0] . "";?></td>
		<td><? member_name ($entry[1]); ?></td>
	   <td><? member_name ($entry[2]); ?></td>
		<td><? echo "$entry[4]";?></td>
		<td align=right><? echo "$entry[5]";?></td>
	</TR>

 <?$i++;
 endwhile;

// page footer
foot_printing ($sess);

	}
	

	
?>

