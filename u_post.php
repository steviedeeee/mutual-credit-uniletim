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

if ($usname != "")
{

  if ($password == "" & $sess[3] != "timebank")
   {
      $error = "<DIV ALIGN=CENTER><font color=Red><b>" . _INS_RQRD_DATA . "</b></font></DIV>\n";
   }
  elseif ($password != $password2)
   {
      $error = "<DIV ALIGN=CENTER><font color=Red><b>" . _PASSWD_TWICE_RQRD . "</b></font></DIV>\n";
   }
   else
   {

      $u_id = md5(uniqid($hash_secret));
	  	$pass = md5($password);
		mysql_query("insert into uniletim_members values ('$u_id', '$usname', '$pass', '', '$u_priezvisko', '$u_meno', '$u_email', '$u_web', '$u_info', '$u_send', '$u_phone', '', '', '', '')");
		mysql_query("insert into uniletim_perms values ('', '$u_id', '$sess[4]', '$perms', 'd')");
		if (mysql_affected_rows() == 0) {
         $error = "<DIV ALIGN=CENTER><font color=red><b>" . _ERROR . "</b> \"$query\"</font></DIV>\n";
         }
      else   {
	     $result = "<DIV ALIGN=CENTER><font color=green><b>" . _USER . ' "' . $usname .'" ' . _WAS_CREATED_MALE . "</b></font></DIV>\n";
         $id = $u_id;
		 }

   }
}

if ($upid != "")

{
if ($changed == "dgroup")
{
$d = "d";
$sqx = mysql_query("SELECT * FROM uniletim_perms WHERE perm_default = '$d'");
while ($row = mysql_fetch_row($sqx))
	{
	$sql = mysql_query("update uniletim_perms SET perm_default = '' where perm_id = '$row[0]'");
	}
$sql = mysql_query("update uniletim_perms SET perm_default = 'd' where perm_group = '$gid'");
      $result = _USER_WAS_CHANGED_MALE;
}
elseif ($passw == "" & $changed == "passw")
   {
      $error = _PASSWD_NULL;
      $edit = "passw";
   }
elseif ($passw != "" & $passw != $passw2)
   {
      $error = _PASSWD_TWICE_RQRD;
   }
   else
   {
    // $sql = mysql_query("select * from uniletim_members where login = '$usrname' AND user_id not '$upid' AND ul_group = '$sess[4]'");
    // if (mysql_num_rows($sql) > 1)
	//  {
    //   $error = " " . _USER . ' "' . $usrname .'" ' . _ALREADY_EXISTS . " \n";
    //  }
   // else   {
	   if ($passw == ""){
		  $query = "update uniletim_members SET mbr_login = '$usrname', 
mbr_surname = '$u_priezvisko', mbr_name = '$u_meno', mbr_email = 
'$u_email', mbr_web = '$u_web', mbr_info = '$u_info', mbr_send = '$u_send', 
mbr_phone = '$u_phone' where mbr_id = '$upid'";
			//mysql_query($query);
		} else{
		  $pass = md5($passw);
		  $query = "update uniletim_members SET mbr_password = '$pass' where 
mbr_id = '$upid'";
		}
		$result = mysql_query($query);
		if (!$result) {
			 $error = " " . _ERROR . ":</b> \"$query\" \n";
		} else {
				$result = " " . _USER . ' "' . $usrname .'" ' . _WAS_CHANGED_MALE . " \n";
				$id = $upid;
		 }
      }
   // }
}

// set user not active


if ($uppid != "")
{
		$sqk = mysql_query("SELECT * FROM uniletim_perms WHERE perm_member = '$uppid' AND perm_group = '$sess[4]'");
		$rod = mysql_fetch_row($sqk);
		$query = "update uniletim_perms SET perm_perms = '$perms' where mbr_id = '$rod[0]'";
      mysql_query($query);
      if (mysql_affected_rows() == 0) {
         $error = " " . _ERROR . ":</b> \"$query\" \n";
         }
      else   {
	     $result = " " . _PERM . ' "' . $usrname .'" ' . _WAS_CHANGED_MIDDLE . " \n";
         $id = $uppid;
		 $edu = "";
		 }
}

// delete user
if ($did != "")
{
@$sql = mysql_query("DELETE FROM uniletim_members WHERE mbr_id='$did'");
@$sql = mysql_query("DELETE FROM uniletim_announces WHERE ann_member='$did'");
      $result = _USER_DELETED;
}

// set user not active
if ($nid != "")
{
$sql = mysql_query("update uniletim_members SET mbr_state = 'd' where mbr_id = '$nid'");
      $result = _USER_DELETED;
}

if ($exid != "")
{

		mysql_query("insert into uniletim_perms values ('', '$exid', '$perm_group', '$perms', '')");
      if (mysql_affected_rows() == 0) {
         $error = "<DIV ALIGN=CENTER><font color=red><b>" . _ERROR . "</b> \"$query\"</font></DIV>\n";
         }
      else   {
			$sql = mysql_query("SELECT mbr_login FROM uniletim_members WHERE mbr_id = '$exid'");
			$row = mysql_fetch_row($sql);
	     	$result = "<DIV ALIGN=CENTER><font color=green><b>" . _USER . ' "' . $row[0] .'" ' . _WAS_CREATED_MALE . "</b></font></DIV>\n";
         $id = $u_id;
		 }
		 $id = $exid;

}
?>