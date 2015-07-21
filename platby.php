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

if (!IsSet($action)) $action = "view"; //ještì není zinicializována promìnná $action 
if (!IsSet($what)) $what = "all"; //ještì není zinicializována promìnná $what 
if (!IsSet($page)) $page = 0; //ještì není zinicializována promìnná $page 
if (!IsSet($order)) $order = "ser_time"; //ještì není zinicializována promìnná $page 
 
if ($action == "print"): 
//printing list of services 
services_list_printing ($sess,$what); 
 
else: 
 
 //zobrazujeme zprávy 
 
// page header 
head ($sess,$x,$auth,$design,$menu); 
 

if ($action=="view"):
 
    require("p-vypis.php"); 
 
elseif ($action=="user"): 
    require("p-user.php"); 
	 
else: //formuláø nebo uložení zprávy 
 
 
	if ($write == "auth"): //zápis do databáze 
 	require("p-post.php"); 
	$komuf = ""; 
	$zacof = ""; 
	$kolkof = ""; 
	endif; 
if ($write == "kont"): //kontrola udajov 
	 if($ktof=="" ||$komuf=="" || $zacof=="" || $kolkof==""):	//byly vyplnìny všechny povinné údaje? 
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
 
