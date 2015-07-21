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
	echo "There is no config.php file. I will try to create it.<br />";
	if (!copy ("config.default.php", "config.php")) {
		echo "There are no privilegs to write a file. Please copy the <b>config.default.php</b> to <b>config.php</b> manually.";
	exit;
	}
	chmod ("config.php", 0666);
	echo "The file <b>config.php</b> successfully created. Please reload the page.";
	exit;
}

// configuration file
include "./config.php";

// authorization of users
$SN = "hvxator";
Session_name("$SN");
Session_start();
$sid = Session_id();
$date = Date("U");
$ad = Date("U") - 1800;

$MSQ = @MySQL_Query("SELECT * FROM uniletim_auth WHERE (aut_id = '$sid')"); // AND (aut_date >= '$ad')
$sess = @MySQL_Fetch_Row($MSQ);
If (@MySQL_Num_Rows($MSQ) < 1):
 		$auth = "0";
		// test if the db.tables are created; if not, jump to install.php
		$dbInstalled = (MySQL_Num_Rows(MySQL_Query("SHOW TABLES")) ? 1 : 0);
		if (!$dbInstalled):
			include "./includes/tables.inc.php";
		endif;
		$memberExists = (MySQL_Num_Rows(MySQL_Query("SELECT mbr_id FROM uniletim_members")) ? 1 : 0);
		if (!$memberExists):
			include "./install.php";
			exit;
		endif;
		If ($lang == ""):
		 $lang = $app_lang;
		endif;;

Else:
	$lang = $sess[9];
	$MSQ = MySQL_Query("UPDATE uniletim_auth SET aut_date = $date WHERE aut_id = '$sid'");
Endif;

// change group
if ($group_ch != ""):
	mysql_query("UPDATE uniletim_auth SET aut_group='$group_ch', aut_group_name='$grp_name' WHERE aut_id='$sess[0]'");
	$MSQ = MySQL_Query("SELECT * FROM uniletim_auth WHERE (aut_id = '$sid')"); // AND (aut_date >= '$ad')
	$sess = mysql_fetch_row($MSQ);
endif;

// included files
include "language/lang-$lang.php";

	include "./includes/page.inc.php";
	include "./includes/announces.inc.php";
	include "./includes/members.inc.php";

if ($action == "print"):
	include "./includes/announces-print.inc.php";

	// printing of announces
	announces_print ($sess,$uoz,$rub,$pri,$keyword,$age);

else:

	include "./includes/admin.inc.php";
	if (!$menu) $menu = "ann"; //selecting of location menu

	// create header of the page
	head ($sess,$kx,$auth,$design,$menu);

	if ($auth == "0"):
	// unauthorized user
		if ($echo == "lo"):
		// user logged out
			$result = _LOGGED_OUT;?>
			<div  class="res"><? echo $result;?></div>
			<?
		else:
		// welcome user
			echo $welcome_call_unauth;
			index_unauth ($sess,$menu);
		Endif;

	else:
	// authorized user

		if($edid != "" || $sedid != "" || $did != ""):
		// edit or delete announce
			include "./includes/post.inc.php";
		endif;

		if ($action == "mail"):
		//  message to admin - form
			mail_form ($sess);

		elseif ($action == "form"):
		// forms

			if ($type == "new"):
			// new announce
				if ($text != ""):
					include "./includes/post.inc.php";
				endif;
				announces_new ($sess,$chtext,$a_id,$dp,$platn,$chcena,$rub,$pri,$error,$result,h3);
			else:
			// edit announce
				announces_edit ($sess,$eid,$chtext,$a_id,$dp,$platn,$chcena,$rub,$pri,$error,$result);
			endif;


		else:



			if ($action == "user"):
			// user´s announces



				announces_user ($sess,$uoz,$anned,$page);

			elseif ($action == "about"):
			// about
					page_about_program ();

			elseif ($action == "stat"):
				// statistic
			admin_statistic ();

			elseif($pri == "all"):

				include "./o_vypis-vs.php";

			else:
				if($action == "send"):
				//  sending message to admin
					mail_send ($admin_mail,$m_body,$sess);
				endif;

				announces_selected ($sess,$rub,$pri,$keyword,$age,$page);

			endif;

		endif;

	endif;
	// create footer of the page
	foot ($sess,$menu);

endif;
?>
