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

// if config.php file does not exist, try to create it
if (!file_exists("config.php")) {
	echo "There is no config.php file. I will try to create it.";
	if (!copy ("config.default.php", "config.php")) {
		echo "There are no privilegs to write a file. Please copy the <b>config.default.php</b> to <b>config.php</b> manually.";
	exit;
	}
	chmod ("config.php", 0666);
}

If ($lang == ""):
 $lang = $app_lang;
endif;

include "./config.php";
include "language/lang-$app_lang.php";
include "./includes/group.inc.php";
include "./includes/page.inc.php";


$auth = "0";

if (!IsSet($action)) $action = "info";
if (!IsSet($group)) $group = "$sess[4]";

// page header
head ($sess,$x,$auth,$design,$menu);
?>
<td width="500" align="center" valign="top">
<?
			if ($group_add != ""):		
				include "./includes/group-post.inc.php";
			endif;

			if($result1 != "" & $result2 != ""): 
				group_created ($result1,$result2,$error1,$error2); 	
			else:
				group_new ($sess); 
			endif;

?>
</td>
<?
// page footer
foot ($sess,$design);

?>


