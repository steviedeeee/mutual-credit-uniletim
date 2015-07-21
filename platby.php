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
include "language/lang-$lang.php"; 
include "./includes/page.inc.php"; 
include "./includes/members.inc.php";
include "./includes/services.inc.php";
if (!$menu) $menu = "pay"; //selecting of location menu

if (!IsSet($action)) $action = "view"; //je�t� nen� zinicializov�na prom�nn� $action 
if (!IsSet($what)) $what = "all"; //je�t� nen� zinicializov�na prom�nn� $what 
if (!IsSet($page)) $page = 0; //je�t� nen� zinicializov�na prom�nn� $page 
if (!IsSet($order)) $order = "ser_time"; //je�t� nen� zinicializov�na prom�nn� $page 
 
if ($action == "print"): 
//printing list of services 
services_list_printing ($sess,$what); 
 
else: 
 
 //zobrazujeme zpr�vy 
 
// page header 
head ($sess,$x,$auth,$design,$menu); 
 

if ($action=="view"):
 
    require("p-vypis.php"); 
 
elseif ($action=="user"): 
    require("p-user.php"); 
	 
else: //formul�� nebo ulo�en� zpr�vy 
 
 
	if ($write == "auth"): //z�pis do datab�ze 
 	require("p-post.php"); 
	$komuf = ""; 
	$zacof = ""; 
	$kolkof = ""; 
	endif; 
if ($write == "kont"): //kontrola udajov 
	 if($ktof=="" ||$komuf=="" || $zacof=="" || $kolkof==""):	//byly vypln�ny v�echny povinn� �daje? 
		$error = _MUST_FILL_ALL; 
 	 require("p-form.php"); 
	 else: 
    require("p-kont.php"); 
     endif; 
else: 
 	 require("p-form.php"); 
endif; 
 
endif; 
 
// page footer 
foot ($sess,$menu); 
 
endif; 
?> 
 
