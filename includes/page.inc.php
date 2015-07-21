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




// HEADER PAGE
function head ($sess,$kx,$auth,$design,$menu) {

 	if ($auth == "0"):
 		global $app_design,$app_style;
 		$design = $app_design;
		$style = $app_style;
	else:
 		$design = $sess[6];
		$style = $sess[7];
	endif;

 	// don't save to the internet browser's cache
	 // Header("Pragma: No-cache");
 	// Header("Cache-Control: No-cache, Must-revalidate");
 	// Header("Expires: ".GMDate("D, d M Y H:i:s")." GMT");

	include "./themes/$design/head.inc.php";

}

// FOOTER PAGE
function foot ($sess,$menu) {
 	if ($sess[6] == ""):
 		global $app_design, $auth;
 		$design = $app_design;
		$style = $app_style;
	else:
 		$design = $sess[6];
		$style = $sess[7];
	endif;

include "./themes/$design/foot.inc.php";
}


function index_unauth ($sess,$menu) {

 	if ($sess[6] == ""):
 		global $app_design, $auth;
 		$design = $app_design;
		$style = $app_style;
	else:
 		$design = $sess[6];
		$style = $sess[7];
	endif;
?>

<div class="unauth">
<a href="login.php">Login / Prihlási» sa</a>

<h4>Vyskú¹ajte si / Test the demo:</h4>
<a href="login.php?type=demo">Test login</a>

<h4><? echo _CREATE ?>:</h4>
<a href="install.php"><? echo _NEW_GROUP ?></a>
</div>

<?php
}

// LOCATION OF PAGE
function page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page) {
	if($rub != ""):
					$sql = mysql_query("SELECT * FROM uniletim_sections WHERE sec_id = '$rub' AND ul_group = '$sess[4]'");
					$row = mysql_fetch_row($sql);
					$h3 = "<a href=index.php?rub=$row[0]>$row[1]</a><b>&nbsp;>&nbsp;</b>";
	if($pri != ""):
					$sql = mysql_query("SELECT * FROM uniletim_subsections WHERE sub_id = '$pri' AND ul_group = '$sess[4]'");
					$row = mysql_fetch_row($sql);
					$h3 = "$h3<a href=index.php?rub=$row[2]&pri=$row[0]>$row[1]</a><b>&nbsp;>&nbsp;</b>";
	endif;
	endif;

	if($eid != ""):
	// links on section and subsection
		$sql = mysql_query("SELECT ann_member, ann_sub FROM uniletim_announces WHERE ann_id = '$eid'");
		$roa = mysql_fetch_row($sql);

		$sql = mysql_query("SELECT sub_id, sub_name FROM uniletim_subsections WHERE sub_id = '$roa[1]'");
		$row = mysql_fetch_row($sql);

		$sql = mysql_query("SELECT sec_id, sec_name FROM uniletim_sections WHERE sec_id = '$row[2]'");
		$ror = mysql_fetch_row($sql);

		$sql = mysql_query("SELECT mbr_login FROM uniletim_members WHERE mbr_id = '$roa[0]'");
		$rom = mysql_fetch_row($sql);

		$h3 = "<a href=index.php?rub=$ror[0]>$ror[1]</a>&nbsp;<b>></b>&nbsp;";
		$h3 = "$h3<a href=index.php?rub=$row[2]&pri=$row[0]>$row[1]</a>&nbsp;<b>></b>&nbsp;";

		$h31 = "<br>" . _MEMBER . ": <a href=u_info.php?id=$roa[0]>$rom[0]</a>&nbsp;<b>></b>&nbsp;";
		$h31 = "$h31<a href=index.php?action=user&uoz=$uoz>" . _ANNOUNCES . "</a>&nbsp;<b>></b>&nbsp;";
	endif;

	if($uoz != ""):
		$sql = mysql_query("SELECT mbr_login FROM uniletim_members WHERE mbr_id = '$uoz'");
		$rom = mysql_fetch_row($sql);
		$h3 = "<a href=u_info.php?id=$uoz>$rom[0]</a>&nbsp;<b>></b>&nbsp;";
	endif;

	if($menu == "ann"):
		$loc_group = _ANNOUNCES ;
	elseif($menu == "mbr"):
		$loc_group = _MEMBERS ;
	elseif($menu == "pay"):
		$loc_group = _PAYMENTS ;
	elseif($menu == "adm"):
		$loc_group = _ADMINISTRATION ;
	elseif($menu == "help"):
		$loc_group = _HELP ;
	else:
	endif;

	$h3 = "$loc_group: $h3$loc_page$h31" ;

?>
      <div class="location">
       <h3>
        <? echo $h3; ?>
       </h3>
      </div>

<?
}

// RESULTS OF SCRIPTS
function page_result_error ($result,$auth) {
	if($result != "" || $error != ""):?>
			<div  class="result"><? echo "$result";?></div>&nbsp;
			<div  class="error"><? echo "$error";?></div><?
	endif;
}

// SUBSECTION NAME OR LINK
function page_subsection ($sub_id,$auth,$sess) {
	@$sql = mysql_query("SELECT * FROM uniletim_subsections WHERE sub_id = '$sub_id' AND ul_group = '$sess[4]'");
	$row = mysql_fetch_row($sql);

	If ($auth != "0"):
		echo "<A HREF=index.php?rub=$row[2]&pri=$row[0]>$row[1]</A>";
	else:
		echo $row[1];
	endif;


}

// HEADER PAGE - PRINTING
function head_printing () {

 // don't save to the internet browser's cache
 // Header("Pragma: No-cache");
 // Header("Cache-Control: No-cache, Must-revalidate");
 // Header("Expires: ".GMDate("D, d M Y H:i:s")." GMT");
?>
<HTML>
	<HEAD>
		
		<META HTTP-EQUIV="content-type" CONTENT="text/html;charset=ISO-8859-2">
		<META HTTP-EQUIV="Author" CONTENT="Priestor, o.z.">
		<TITLE>uniLETIM - <? echo $sess[8] ?></TITLE>
		<LINK REL="stylesheet" HREF="themes/css/uniletim-print.css">
	</HEAD>
	<BODY BGCOLOR="white">
<?
}


// FOOTER PAGE - PRINTING
function foot_printing ($sess) {

global $conn;
	?>
	<tr>
		<td colspan="6">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr><td colspan="2"><hr size="3" noshade></td></tr>
				</tr>	
				<td>
				<b><?$message = MySQL_Query("SELECT * FROM uniletim_groups WHERE grp_id = '$sess[4]'") or die($query_error); //vybíráme zprávy - seøazeno podle id
				 $entry = MySQL_Fetch_Row($message);
				 echo $entry[1] ?></b>
				</td>
				<td align="right">			
				<b>uniLETIM&nbsp; </b>
				<? $date = date("Y-m-d");
				$date = Explode("-", $date);
		 		echo " ". $date[2] . "." . $date[1] . "." . $date[0] . "";?>
				</td>
				</tr>
			</table>
			<br><br>
			<p class=help>
			 <a href="#" OnClick="history.back()"><? echo _BACK ?></a>
			 &nbsp;&nbsp;>&nbsp;&nbsp;
			 <a href="javascript:window.print();"><? echo _PRINT ?></a></p>
		</td>
	<tr>
</table>
</BODY>
</HTML>
	<?
	mysql_close($conn);
}
	
	
// PAGING OF EXTRACTS
function page_counter ($id,$table,$sort,$view_number,$sess,$link,$i,$page) {

	$count = MySQL_Query("SELECT $id FROM $table WHERE $sort AND ul_group = '$sess[4]'") or die($query_error); //vybíráme zprávy
	$page_count = Ceil(MySQL_Num_Rows($count)/$view_number); //poèet stran, na kterých se zprávy zobrazí
	for($i=0;$i<$page_count;$i++):
		echo " | ";
		if($page!=$i) echo "<a href=\"$link$i\">";
		echo ($i+1);
		if($page!=$i) echo '</a> ';
	endfor;
}

// ABOUT THIS PROGRAM
function page_about_program () {
?>
	<H3><? echo _ABOUT_APP ?> uniLETIM</H3>
	
	<div  class="res"><? echo $result ?></div>&nbsp;
	<div  class="error"><? echo $error ?></div>
	<table border="1" cellspacing="0" cellpadding="0" bordercolor="Green"><tr><td valign="top">
	<TABLE width="460" BORDER="0" CELLPADDING="8" CELLSPACING="0">
		<TR>
			<TD VALIGN="top" ALIGN="right">
				<b><? echo _CREATED_BY ?>:</b>
			</TD>
			<TD>
				<A HREF="http://www.domudra.sk/priestor/">PRIESTOR, o. z. </A><? echo _IN_COOP_WITH ?> <A HREF=http://www.ozkultura.sk/>OZ Kultura</A>.
			</TD>
		</TR>
		<TR>
			<TD VALIGN="top" ALIGN="right">
				<b><? echo _AUTHORS ?>:</b>
			</TD>
			<TD>
				Ondrej Vegh - <? echo _SOURCE_CODE; echo ", "; echo _DOCUMENTATION; ?><br>
				Robert Zelnik - <? echo _LOCALIZATION; echo ", "; echo _DOCUMENTATION; ?><br>
				Michal Jurco - <? echo _DOCUMENTATION; ?><br>
			</TD>
		</TR>
		<TR>
			<TD VALIGN="top" ALIGN="right">
				<b><? echo _DONATED_BY ?>:</b>
			</TD>
			<TD>
				<? echo _DONATE_TEXT ?>
			</TD>
		</TR>
		<TR>
			<TD VALIGN="top" ALIGN="right">
				<b><? echo _LICENSE ?>:</b>
			</TD>
			<TD>
				<? echo _ABOUT_LICENSE ?>
			</TD>
		</TR>
		<TR>
			<TD VALIGN="top" ALIGN="right">
				<b><? echo _MORE_INFO ?>:</b>
			</TD>
			<TD>
				<a href="./doc/manual.html#05"><? echo _LINKS ?></a> <? echo _LINK_INFO ?>
			</TD>
		</TR>
	</TABLE>
		</TD></TR></TABLE>
<?
}


?>
