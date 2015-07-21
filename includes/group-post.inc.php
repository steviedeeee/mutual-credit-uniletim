
<?
// EDIT GROUP
	if ($group_ed != "")
	{
		mysql_query("UPDATE uniletim_groups SET grp_name='$grp_name', grp_design='$grp_design', grp_style='$grp_style' WHERE grp_id='$group_ed'");
		mysql_query("UPDATE uniletim_auth SET aut_design='$grp_design', aut_style='$grp_style', aut_group_name='$grp_name' WHERE aut_id='$sess[0]'");
		$MSQ = MySQL_Query("SELECT * FROM uniletim_auth WHERE aut_id='$sess[0]'"); 
$sess = mysql_fetch_row($MSQ);		
		$result =  _GROUP . " " . _WAS_CHANGED_FEMALE;
//		$group_ed == "";
//		header("Location: ./group.php?action=info"); 
	}
	
// DELETE GROUP
	if ($group_del != "")
	{
		@$sql = mysql_query("DELETE FROM uniletim_groups WHERE grp_id = '$group_del'");
		@$sql = mysql_query("DELETE FROM uniletim_announces WHERE ul_group = '$group_del'");
		@$sql = mysql_query("DELETE FROM uniletim_members WHERE ul_group = '$group_del'");
		@$sql = mysql_query("DELETE FROM uniletim_sections WHERE ul_group = '$group_del'");
		@$sql = mysql_query("DELETE FROM uniletim_subsections WHERE ul_group = '$group_del'");
		
		$result = _GROUP . " " . _WAS_DELETED_FEMALE;
	}

// ADD GROUP
if ($group_add != "")
{
	mysql_query("select * from uniletim_groups");
	if (mysql_affected_rows() == 0) {
			$dbInstalled = (MySQL_Num_Rows(MySQL_Query("SHOW TABLES")) ? 1 : 0);
			if (!$dbInstalled):
				include "./includes/tables.inc.php";
			endif; }
	if ($mbr_password == "" || $grp_name == "")
		{
		$error = _INS_RQRD_DATA ."\n";
		} 
	elseif ($mbr_password != $mbr_password2)
		{
			$error = _PASSWD_TWICE_RQRD . "\n"; 
		}
	else 
		{
		mysql_query("select * from uniletim_members where mbr_login = '$mbr_name'");
		if (mysql_affected_rows() > 0) {
			$error1 = "<b>$in_chu</b>\n"; 
		} 
		else 
		{ 
		mysql_query("select * from uniletim_groups where grp_name = '$grp_name'");
		if (mysql_affected_rows() > 0) { 
			$error1 = "<b>" . _GROUP_EXISTS . "</b>\n";
		}
		else
			{
			$inst = "yes";
			include "./i-tab.php";

			$grp_id = md5(uniqid($hash_secret));
			$query = "insert into uniletim_groups values ('$grp_id','$grp_name','0','$grp_type', '$app_design', '$app_style', '')";
			mysql_query($query);
			if (mysql_affected_rows() == 0) {
				$error1 = "<b>" . _ERROR . ":</b> \"$query\"<br>\n";
			}
			else   { 
				$result1 = "<b>" . _GROUP . " \"$grp_name\" " . _WAS_CREATED_FEMALE . "</b><br>\n";
			} 

			$mbr_id=md5(uniqid($hash_secret));
			$mbr_password = md5($mbr_password);
			$query = "insert into uniletim_members values ('$mbr_id','$mbr_name','$mbr_password','$perms','','','','','','','','$s_id', '', '', '')";
			mysql_query($query);
			if (mysql_affected_rows() == 0) {
				$error2 = "<b>" . _ERROR . ":</b> \"$query\"\n"; 
				} 
			else   {
				$query = "insert into uniletim_perms values ('','$mbr_id','$grp_id','$perm_perms','d')";
				mysql_query($query);
						$result2 = "<b>" . _USER . " \"$mbr_name\" " . _WAS_CREATED_MALE . "</b>\n";
         } 
				} 
		} 
 
	} 
}
?>
