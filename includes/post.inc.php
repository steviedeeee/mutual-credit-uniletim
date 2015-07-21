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


//ANNOUNCES

	// new announce
	if ($text != "")
	{
		if ($a_id == "0") // author
		{
			$r_title = '';
			$error = _SELECT_FROM;
			$chtext = $text;
			$chcena = $cena;
		}
		else
		{
			if ($pri == "0") // subsection
			{
				$r_title = '';
				$error = _SELECT_SECTION;
				$chtext = $text;
				$chcena = $cena;
			}
			elseif ($dp == "0") // offer-query
			{
				$r_title = '';
				$error = _SELECT_O_OR_Q;
				$chtext = $text;
				$chcena = $cena;
			}
			else
				{
				if ($text == "") // text of announce
				{
					$r_title = '';
					$error = _SELECT_TEXT;
					$chtext = $text;
					$chcena = $cena;
				}
				else
				{			
					// extract unsecure characters
					$cena = HTMLSpecialChars($cena);

					$text = SubStr($text, 0, 1500); // limit 1500 znakov
					$text = Trim($text); // trim spaces on start and end
					$text = HTMLSpecialChars($text);  // extract unsecure characters
					$text = Str_Replace("\r\n"," <BR> ", $text); // relpace ends whit tag <BR>

					$text = WordWrap($text, 90, "\n", 1); // break long words

					// crete anchors
					$text = EregI_Replace("(http://[^ ]+\.[^ ]+)", " <a href=\\1>\\1</a>", $text);
					$text = EregI_Replace("[^/](www\.[^ ]+\.[^ ]+)", " <a href=http://\\1>\\1</a>", $text);

					// povolí tyto tagy - <b> <u> <i>, možnost pøidat další
					$tag = Array("b", "u", "i");
				   for($y=0;$y<Count($tag);$y++):
					$text = EregI_Replace("<" . $tag[$y] . ">", "<" . $tag[$y] . ">", $text);
					$text = EregI_Replace("</" . $tag[$y] . ">", "</" . $tag[$y] . ">", $text);
					endfor;

					$time = time(); // timestamp
					$platnost = Date("Y-m-d", Time()+$platn*24*3600); //validity
					$sql = mysql_query("SELECT * FROM uniletim_subsections WHERE sub_id = '$pri' AND ul_group = '$sess[4]'");
					$row = mysql_fetch_row($sql);
					$rub = $row[2];

					mysql_query("insert into uniletim_announces values (null, '$a_id', '', '$pri', '$time', '$platnost', '$rub', '$text', '$cena', '$dp', '', '$sess[4]')");

					$result = _ANNO_INSERTED;
		
				}
			}	
		}
	}

	
	// edit announce
	if ($edid != "")
	{
		if ($pr == "0")
		{
			$r_title = '';
			$error = _SELECT_SECTION;
		}
		elseif ($ponuka_dopyt == "0")
		{
			$r_title = '';
			$error = _SELECT_O_OR_Q;
		}
		else
		{
			mysql_query("UPDATE uniletim_announces SET ann_sub='$pr', ann_validity='$platnost', ann_text='$info', ann_price='$cena', ann_oq='$ponuka_dopyt' WHERE ann_id='$edid'");

			$result = _ANNO_CHANGED;
		}
	}
	
	// edit subsection of announce
	if ($sedid != "")
	{
			$sql_sec = mysql_query("SELECT * FROM uniletim_subsections WHERE sub_id = '$ann_sub'");
			$row_sec = mysql_fetch_row($sql_sec);
			mysql_query("UPDATE uniletim_announces SET ann_sec='$row_sec[2]', ann_sub='$ann_sub' WHERE ann_id='$sedid'");
			$result = _ANNO_CHANGED;
	}

	
	// delete announce
	if ($did != "")
	{
		@$sql = mysql_query("DELETE FROM uniletim_announces WHERE ann_id = '$did'");
		$result = _ANNO_DELETED;
	}


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

				include "./i-tab.php"; }
	if ($password == "" || $s_nazov == "")
		{ 
		$error = _INS_RQRD_DATA ."\n";
		} 
	elseif ($password != $password2) 
		{
			$error = _PASSWD_TWICE_RQRD . "\n"; 
		}
	else 
		{
		mysql_query("select * from uniletim_members where mbr_login = '$usname'"); 
		if (mysql_affected_rows() > 0) {
			$error1 = "<b>$in_chu</b>\n"; 
		} 
		else 
		{ 
		mysql_query("select * from uniletim_groups where grp_name = '$s_nazov'");
		if (mysql_affected_rows() > 0) { 
			$error1 = "<b>" . _GROUP_EXISTS . "</b>\n";
		}
		else
			{
			$inst = "yes";
			include "./i-tab.php";

			$s_id = md5(uniqid($hash_secret));
			$query = "insert into uniletim_groups values ('$s_id','$s_nazov','0','$typ', '', '', '')";
			mysql_query($query);
			if (mysql_affected_rows() == 0) {
				$error1 = "<b>" . _ERROR . ":</b> \"$query\"<br>\n";
			}
			else   { 
				$result1 = "<b>" . _GROUP . " \"$s_nazov\" " . _WAS_CREATED_FEMALE . "</b><br>\n"; 
			} 
			mysql_query("INSERT INTO uniletim_sections VALUES ('', 'Slu¾by', '$s_id', '')"); 
			mysql_query("INSERT INTO uniletim_sections VALUES ('', 'Pomoc', '$s_id', '')"); 
			mysql_query("INSERT INTO uniletim_sections VALUES ('', 'Znalosti', '$s_id', '')"); 
 
			$u_id=md5(uniqid($hash_secret));
			$pass = md5($password);
			$query = "insert into uniletim_members values ('$u_id','$usname','$pass','$perms','','','','','','','','$s_id', '', '', '')";
			mysql_query($query);
			if (mysql_affected_rows() == 0) { 
				$error2 = "<b>" . _ERROR . ":</b> \"$query\"\n"; 
				} 
			else   { 
						$result2 = "<b>" . _USER . " \"$usname\" " . _WAS_CREATED_MALE . "</b>\n"; 
         } 
				} 
		} 
 
	} 
} 	
?>
