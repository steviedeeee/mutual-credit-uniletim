<?
include "./config.php";
include "./auth.php";
include "./includes/page.php";
include "./includes/announces.php";
include "language/lang-$app_lang.php";


head_printing ();


	?>
<table width="720" border="0" cellspacing="0" cellpadding="3">
<?
if($uoz == ""):

	if($rub != ""):
		$sec_sel = "r_id = '$rub'";
	// sections
	else:
	$sec_sel = "r_name like '%'";
	endif;
	
 	$sql_sec = mysql_query("SELECT * FROM lets_rubriky WHERE $sec_sel AND l_group = '$sess[4]'");
		
	while ($row_sec = mysql_fetch_row($sql_sec)) 
		{
	$rub = $row_sec[0];
	// subsections
	if($pri != ""):
		$sub_sel = "S.pr_id='$pri'";
	// sections
	else:
	$sub_sel = "S.pr_rubrika='$rub'";
	endif;
	
 	$sql_head = mysql_query("SELECT * FROM lets_rubriky WHERE r_id = '$rub' AND l_group = '$sess[4]'");
	$row_head = mysql_fetch_row($sql_head);	

?>
	<TR>   
		<td colspan="3">&nbsp;</td>
	</TR>	
	<TR class="dark">   
		<td colspan="3"><h2><? echo $row_head[1]; ?></h25></td>
	</TR>
	<TR>   
		<td width="360"><b><? echo _OFFER ?></b></td>
		<td width="2" class="row"><img src="img/plocha.gif" width="0" border="0" alt="" hspace="0" vspace="0"></td>
		<td width="360"><b><? echo _QUERY ?></b></td>
	</TR>
<?
	// listing of subsections
	announces_print_subsections ($sub_sel,$sess);
		}
else:
	// user listing of announces
	announces_print_user ($uoz,$sess);
endif;


?>
		<tr>
			<td colspan="6">
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr><td colspan="2"><hr size="3" noshade></td></tr>
				</tr>	
				<td>
				<b><?$message = MySQL_Query("SELECT * FROM lets_skupiny WHERE s_id = '$sess[4]'") or die($query_error); //vybíráme zprávy - seøazeno podle id
				 $entry = MySQL_Fetch_Row($message);
				 echo $entry[1] ?></b>
				</td>
				<td align="right">			
				<b>uniLETIM</b>
				<? $date = date("Y-m-d");
				$date = Explode("-", $date);
		 		echo " ". $date[2] . ". " . $date[1] . ". " . $date[0] . "";?>
				</td>
				</tr>
			</table>
		</td>
		<tr>
</table>
<?

foot_printing ();

	?>

