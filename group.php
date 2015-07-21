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

include "./config.php";
include "./auth.php";

if ($group_ed != ""):		
	include "./includes/post.inc.php";
	$group = "$group_ed";
endif;

include "language/lang-$lang.php";
include "./includes/members.inc.php";
include "./includes/group.inc.php";
include "./includes/page.inc.php";

if (!$menu) $menu = "adm";

if (!IsSet($action)) $action = "info"; 
if (!IsSet($group)) $group = "$sess[4]";

// page header
head ($sess,$x,$auth,$design,$menu);

$result = "";
$error = "";
$ua = "";

	if ($action == "info"): 
	//  group info
			group_info ($sess,$group,$error,$result); 

	elseif ($action == "new"): 
	//  group new
			if ($group_add != ""):		
				include "./includes/group-post.inc.php";
			endif;
			if($result1 != "" & $result2 != "" & $auth != "0"): 
				group_list ($sess,$group,$result,$result1,$result2,$error,$error1,$error2); 	
			elseif($result1 != "" & $result2 != ""): 
				group_created ($result1,$result2,$error1,$error2); 	
			else:
				group_new ($sess); 
			endif;
				 
	elseif ($action == "edit"): 
	//  group info
			group_edit ($sess,$group,$error,$result); 
		 
	else: 
	// list of groups - superadmin
			if ($group_del != ""):		
				include "./includes/post.inc.php";
				$group = "$group_del";
			endif;
			group_list ($sess,$group,$result,$result1,$result2,$error,$error1,$error2); 	 
	endif;

// page footer
foot ($sess,$menu);

?>

