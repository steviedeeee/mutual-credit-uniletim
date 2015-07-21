

<?
if ($menu == "all") {
	if ($auth != "0"){?>
			<ul>
        	  <li><A HREF="index.php"><? echo _MAIN_PAGE ?></A></li>
     		</ul>
			<hr width="100%" size="1" noshade><?
		}?>
		<h3><? echo _LOGGED_AS ?>:</h3><?
	if ($auth == "0"){
			echo _ANONYMOUS ?><br>
			<A HREF="login.php"><? echo _LOGIN ?></A><?
		}
	else {
			member_name ($sess[2]);?><br>
			<A HREF="login.php?lo=true"><? echo _LOGOUT ?></A><?
		}
	}
	if ($menu == "mbr" || $menu == "all"){?>
		<h3><? echo _MEMBERS ?>:</h3>
			<ul><?
			 if ($sess[3] == "lets"){?>
			 <li><A HREF="u_zmena.php"><? echo _MY_PROFILE ?></A></li><?
				}?>
			 <li><A HREF="u_zoznam.php"><? echo _MEMBERS ?></A></li>
			 <li><A HREF="u_novy.php"><? echo _NEW_MEMBER ?></A></li>
            </ul>
			<hr><?}


	if ($menu == "ann" || $menu == "all"){
			$sql = mysql_query("SELECT * FROM uniletim_sections where ul_group = '$sess[4]'");
			if (mysql_num_rows ($sql) >= "0"){ ?>
		<h3><? echo _ANNOUNCES ?>:</h3>
		<ul><?
			while ($row = mysql_fetch_row($sql)){ ?>
         <li><a href="index.php?rub=<? echo "$row[0]"; ?>"><? echo $row[1]; ?></a></li><?
				}}?>
		 <li><A HREF="index.php?action=form&type=new"><? echo _NEW_ANNOUNCE ?></A></li>
		 <li><A HREF="index.php?action=print" target="_blank"><? echo _PRINT ?></A></li><?
			if ($sess[3] == "lets"){?>
		 <li><A HREF="index.php?action=user"><? echo _MY_ANNOUNCES ?></A></li>
        </ul>
		<hr><?
				}
		}
	if ($menu == "pay" || $menu == "all"){?>
		<h3><? echo _PAYMENTS ?>:</h3>
		<ul>
         <li><A HREF="platby.php?action=view"><? echo _PAYMENTS ?></A></li><?
			if ($sess[3] == "lets"){?>
		 <li><A HREF="platby.php?action=user"><? echo _MY_PAYMENTS ?></A></li><?
			}?>
		 <li><A HREF="platby.php?action=write"><? echo _PAYING_ORDER ?></A></li>
        </ul>
		<hr><?
		}
	if ($menu == "adm" || $menu == "all"){
			if ($sess[5] >= "2"){ ?>
		<h3><? echo _ADMINISTRATION ?>:</h3>
		<ul>
         <li><A HREF="r_zmena.php"><? echo _SECTIONS ?></A></li>
		 <li><A HREF="group.php?action=edit"><? echo _GROUP ?></A></li><?
				}?>
		 <li><A HREF="group.php?action=new"><? echo _NEW_GROUP ?></A></li><?
			if ($sess[5] == "3"){?>
		 <li><A HREF="group.php?action=list"><? echo _GROUPS ?></A></li><?
 				}?>
        </ul>
		<hr><?
		}
	if ($menu == "help" || $menu == "all"){?>
		<h3><? echo _HELP ?>:</h3>
		<ul>
         <li><A HREF="/doc/manual_sk.html"><? echo _DOCUMENTATION ?></A></li>
		 <li><A HREF="index.php?action=about"><? echo _ABOUT_APP ?></A></li>
		 <li><A HREF="group.php?action=info"><? echo _ABOUT_GROUP ?></A></li>
        </ul><?
		}?>
