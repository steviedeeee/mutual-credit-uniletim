<?

// GROUP TYPE
function group_type ($row) {
	if ($row[3] == "timebank"):
		echo _TIMEBANK;
	elseif ($row[3] == "localets"):
		echo _LETS_SINGLE;
	else:
		echo _LETS_MULTI;
	endif;

}


// NEW GROUP
function group_new ($sess) {

$loc_page = _NEW_GROUP;
page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page);
page_result_error ($result,$error);
?> 

<div  class="content-border">
	<table class="content">
			<form name="add" method="post">
				<TR> 
					<TD ALIGN="right"><? echo _GROUP_NAME ?>:</TD> 
					<TD><INPUT TYPE="text" NAME="grp_name" SIZE="24"></TD>
				</TR> 
				<TR> 
					<TD ALIGN="right"><? echo _GROUP_TYPE ?>:</TD> 
					<TD>
						<select name="grp_type">
							<option value="timebank"><? echo _TIMEBANK ?></OPTION>
							<option value="localets"><? echo _LETS_SINGLE ?></option>
							<option value="lets" selected><? echo _LETS_MULTI ?></option> 							
						</SELECT> 
 					</TD>
				</TR> 
 				<TR> 
					<TD ALIGN="right"> 
						&nbsp;
					</TD> 
					<TD>
						<b><? echo _GROUP_ADMIN ?>:</b>
					</TD> 
				</TR> 
 				<TR> 
					<TD ALIGN="right"> 
						<? echo _USER_NAME ?>:
					</TD> 
					<TD>
						<INPUT TYPE="text" NAME="mbr_name" SIZE="24">
					</TD> 
				</TR> 
				<TR> 
					<TD ALIGN="right"><? echo _PASSWORD . "*:" ?></TD> 
					<TD><INPUT TYPE="password" NAME="mbr_password" SIZE="24"></TD>
				</TR> 
				<TR> 
					<TD ALIGN="right"><? echo _PASSWORD . " (" . _CONFIRM . "):" ?></TD> 
					<TD><INPUT TYPE="password" NAME="mbr_password2" SIZE="24"></TD>
				</TR>
				<TR> 
					<TD ALIGN="right"></TD> 
					<TD> 
					<input type="hidden" name="perm_perms" value="2">
					<input type="hidden" name="action" value="new">
					<input type="hidden" name="group_add" value="yes"> 
					<INPUT TYPE="submit" NAME="save" VALUE="<? echo _SAVE ?>"></TD>
				</TR> 
			</TABLE> 
			</form> </div>
<?
}


// GROUP CREATE RESULT
function group_created ($result1,$result2,$error1,$error2) {
?>
	<div  class="res"><? echo "$result1"; echo "$result2";?></div>&nbsp; 
	<div  class="error"><? echo "$error1"; echo "$error2";?></div> 
	<P align="center"><A HREF="login.php"><? echo _LOGIN ?></A></P>
<?
}


// EDIT GROUP
function group_edit ($sess,$group,$error,$result) {

$loc_page = _GROUPS_PROFILE_CHNG;
page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page);
page_result_error ($result,$error);

	$sql = mysql_query("SELECT * FROM uniletim_groups WHERE grp_id='$group'");
    $row = mysql_fetch_row($sql)?>

<div  class="content-border">
	<table class="content">
	<form name="add" method="post" action="group.php?action=info">
		<TR>
			<TD VALIGN="top" ALIGN="right">
				<b><? echo _GROUP_NAME ?>:</b>
			</TD>
			<TD>
				<INPUT TYPE="text" NAME="grp_name" SIZE="20" value="<? echo "$row[1]";?>"> 
			</TD>
		</TR>
		<TR>
			<TD ALIGN="right">
				<b><? echo _THEME ?>:</b>
			</TD>
			<TD>
			<!--<input type="hidden" name="grp_design" value="application">-->
				<select name="grp_design">
					<OPTION value="application"<?if ($row[4] == "application") { echo " selected";}?>><? echo _DROP_DOWN_MENU ?></OPTION>
					<OPTION value="web"<?if ($row[4] == "web") { echo " selected";}?>><? echo _LEFT_SIDE_MENU ?></OPTION>
					<OPTION value="lets_sk"<?if ($row[4] == "lets_sk") { echo " selected";}?>><? echo "lets.sk" ?></OPTION>
					<OPTION value="xhtml"<?if ($row[4] == "xhtml") { echo " selected";}?>><? echo XHTML ?></OPTION>
				</SELECT>
			</TD>
		</TR>
		<TR>
			<TD ALIGN="right">
				<b><? echo _STYLE ?>:</b>
			</TD>
			<TD>
			<input type="hidden" name="grp_style" value="green">
				<!--<select name="grp_style">
					<OPTION value="green"<?if ($row[5] == "green") { echo " selected";}?>><? echo _GREEN ?></OPTION>
					<OPTION value="blue"<?if ($row[5] == "blue") { echo " selected";}?>><? echo _BLUE ?></OPTION>
					<OPTION value="green-xhtml"<?if ($row[5] == "green-xhtml") { echo " selected";}?>><? echo _GREEN_XHTML ?></OPTION>
				</SELECT>-->
			</TD>
		</TR>
		<TR>
			<td align="right" valign="top">
				<b><? echo _GROUP_ADMIN ?>:</b>
			</TD>
			<TD><? 
				$sql_adm = mysql_query("SELECT * FROM uniletim_members WHERE ul_group = '$group' AND mbr_perms >= '2' ORDER BY mbr_login");         
                while ( $row_adm = mysql_fetch_row($sql_adm)):?> 
	             <A HREF="u_info.php?id=<? echo "$row_adm[0]";?>"><? echo "$row_adm[1]";?></A><br><?  
                endwhile; ?>
	             <A HREF="u_novy.php?perms=2"><? echo _NEW_ADMIN ?></A><br>
			</TD>
		</TR>
		<TR>
			<TD ALIGN="right">&nbsp;    		</TD>						
			<TD>
				<input type="hidden" name="group_ed" value="<? echo "$row[0]";?>">
				<INPUT TYPE="submit" NAME="pridaj" VALUE="<? echo _CHANGE ?>">
			</TD>
		</TR>
	</FORM>		
	</TABLE>
</div>
<?
}


// INFO GROUP
function group_info ($sess,$group,$error,$result) {
$loc_page = _GROUPS_PROFILE;
page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page);
page_result_error ($result,$error);

	$sql = mysql_query("SELECT * FROM uniletim_groups WHERE grp_id='$group'");	
    $row = mysql_fetch_row($sql); ?>

<div  class="content-border">
	<table class="content">
		<TR>
			<TD VALIGN="top" ALIGN="right">
				<b><? echo _GROUP_NAME ?>:</b>
			</TD>
			<TD>
				<? echo "$row[1]";?> 
			</TD>
		</TR>
	<TR>
			<TD VALIGN="top" ALIGN="right">
				<b><? echo _GROUP_TYPE ?>:</b>
			</TD>
			<TD>
				<? group_type ($row); ?> 
			</TD>
		</TR>
		<TR>
			<TD ALIGN="right">
				<b><? echo _THEME ?>:</b>
			</TD>
			<TD>
				<? echo "$row[4]";?> 
			</TD>
		</TR>
		<TR>
			<TD ALIGN="right">
				<b><? echo _STYLE ?>:</b>
			</TD>
			<TD>
				<? echo "$row[5]";?> 
			</TD>
		</TR>
		<TR>
			<TD ALIGN="right" valign="top">
				<b><? echo _GROUP_ADMIN ?>:</b>
			</TD>
			<TD><? 
				$sql_adm = mysql_query("SELECT * FROM uniletim_members WHERE ul_group = '$group' AND mbr_perms >= '2' ORDER BY mbr_login");         
                while ( $row_adm = mysql_fetch_row($sql_adm)):?> 
	             <A HREF="u_info.php?id=<? echo "$row_adm[0]";?>"><? echo "$row_adm[1]";?></A><br><?  
                endwhile; ?>  
			</TD>
		</TR>
	</TABLE></div>

<?
}

// LIST GROUPS
function group_list ($sess,$group,$result,$result1,$result2,$error,$error1,$error2) {

$cs1 = " colspan=2";
$cs2 = " colspan=6";
$loc_page = _GROUPS ;
page_location_announces ($sess,$menu,$rub,$pri,$uoz,$eid,$loc_page);
page_result_error ($result,$error);
?>
	<?
	$sql = mysql_query("SELECT * FROM uniletim_groups ORDER BY 'grp_name'");	
    ?>
<div  class="content-border">
	<table class="content">
						<tr class="td_tmave">
						<td colspan="5"><? echo _GROUPS ?>: 
						</td></tr>
<?
   $i = 0;
   while ($row = mysql_fetch_row($sql))
   {
      if ($i%2==0) $bgcolor=''; else $bgcolor=" class=td_rd";
   ?>
						<TR <? echo $bgcolor; ?>>
							<TD><A HREF="group.php?action=info&group=<? echo $row[0]; ?>"><? echo $row[1]; ?></A></TD>
							<TD><?
								group_type ($row); 
							?></TD>
							<TD align="right"><?
								$message = MySQL_Query("SELECT M.mbr_id FROM uniletim_members M LEFT JOIN uniletim_perms P ON M.mbr_id = P.perm_member WHERE P.perm_group = '$row[0]'") or die($query_error);
								$i = 0;
								while ($entry = MySQL_Fetch_Row($message)) $i++;
								echo "$i l ";
								$message = MySQL_Query("SELECT count(ann_id) FROM uniletim_announces WHERE ul_group = '$row[0]'") or die($query_error);
								$entry = MySQL_Fetch_Row($message);
								echo "$entry[0] l ";
								$message = MySQL_Query("SELECT count(ser_id) FROM uniletim_services WHERE ul_group = '$row[0]'") or die($query_error);
								$entry = MySQL_Fetch_Row($message);
								echo "$entry[0]"; 
								?></TD>
						<TD align="right">
						<A HREF="index.php?group_ch=<? echo $row[0]; ?>&grp_name=<? echo $row[1]; ?>"><? echo _LOGIN ?></A></TD>
						<TD align="right">
							<A HREF="group.php?action=list&group_del=<? echo "$row[0]";?>" onclick="return confirm('<? echo _RLY_DLT_GRP ?>')"><? echo _DELETE ?></A>
						</td>
   <?

          $i++;
   }



?>
						<tr class="td_tmave">
						<td colspan="5"><a class="tm" href="group.php?action=new"><? echo _NEW_GROUP ?></a>
						</td></tr>
						</TR>
		</TABLE>
		</div>
<?
}


?>
