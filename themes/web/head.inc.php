<?
?> 
 
<HTML> 
	<HEAD> 
		<META HTTP-EQUIV="content-type" CONTENT="text/html;charset=ISO-8859-2"> 
		<META HTTP-EQUIV="Author" CONTENT="Priestor, o.z."> 
		<TITLE>uniLETIM - <? echo $sess[8] ?></TITLE> 
		<LINK REL="stylesheet" HREF="./themes/css/<? echo $style ?>.css"> 
	</HEAD> 
	<BODY BGCOLOR="white"> 
		<TABLE BORDER="0" CELLPADDING="10" CELLSPACING="0" WIDTH="100%"> 
			<TR> 
				<td colspan="3" class="head"> 
					<TABLE BORDER="0" CELLPADDING="2" CELLSPACING="2" WIDTH="100%"> 
 
						<TR> 
							<TD> 
								<P><B><FONT SIZE="6" color="yellow">uniLETIM</FONT></B><br> 
									<B><FONT SIZE="2" color="yellow">LETS & TIME BANK unite</FONT></B> 
								</P> 
							</TD> 
							<TD ALIGN="right">&nbsp;</TD> 
						</TR> 
					</TABLE> 
				</td> 
			</TR> 
			<TR> 
				<TD width="110" class="col" VALIGN="top"> 
					<? if ($kx != "x"): 
							if ($auth != "0"): ?> 
							<A HREF="index.php"><? echo _MAIN_PAGE ?></A><br> 
							<hr width="100%" size="1" noshade><?endif;?> 
							<B><? echo _LOGGED_AS ?>:</B><BR> 
							<? if ($auth == "0"): echo _ANONYMOUS ?><br> 
								<A HREF="login.php"><? echo _LOGIN ?></A> 
							<? else: 
							@$sql_user = mysql_query("SELECT * FROM uniletim_members WHERE mbr_id = '$sess[2]'"); 
                			 $row_user = mysql_fetch_row($sql_user); 
								echo "$row_user[1]"; ?><br><br> 
								<?if ($sess[3] == "lets"){?> 
								<A HREF="u_zmena.php"><? echo _MY_PROFILE ?></A><BR> 
								<?}?> 
								<A HREF="u_zoznam.php"><? echo _MEMBERS ?></A><BR> 
							<hr width="100%" size="1" noshade> 
						<? endif; 
							$sql = mysql_query("SELECT * FROM uniletim_sections where ul_group = '$sess[4]'"); 
							if (mysql_num_rows ($sql)): ?> 
								<B><? echo _SECTIONS ?>:</B><BR> 
							<?  
							while ($row = mysql_fetch_row($sql)): ?> 
								<a href="index.php?rub=<? echo "$row[0]"; ?>"><? echo $row[1]; ?></a><br> 
							<?endwhile;?> 
							<A HREF="index.php?action=form&type=new"><? echo _NEW_ANNOUNCE ?></A><BR> 
							<A HREF="index.php?action=print" target="_blank"><? echo _PRINT ?></A><BR> 
								<?if ($sess[3] == "lets"){?> 
								<A HREF="index.php?action=user"><? echo _MY_ANNOUNCES ?></A><BR> 
								<?}?> 

							<hr width="100%" size="1" noshade> 
								<A HREF="platby.php?action=view"><? echo _PAYMENTS ?></A><BR> 
								<?if ($sess[3] == "lets"){?> 
								<A HREF="platby.php?action=user"><? echo _MY_PAYMENTS ?></A><BR> 
								<?}?> 
								<A HREF="platby.php?action=write"><? echo _PAYING_ORDER ?></A><BR> 
							<hr width="100%" size="1" noshade> 
								<?if ($sess[5] >= "2"): ?> 
									<A HREF="r_zmena.php"><? echo _SECTIONS ?></A><BR> 
									<A HREF="group.php?action=edit"><? echo _GROUP ?></A><BR> 
								<? endif;?>
									<A HREF="group.php?action=new"><? echo _NEW_GROUP ?></A><BR>
								<?if ($sess[5] == "3"):?>
									<A HREF="group.php?action=list"><? echo _GROUPS ?></A><BR>
 								<? endif;?>
							<hr width="100%" size="1" noshade> 
									<A HREF="/doc/manual_sk.html"><? echo _DOCUMENTATION ?></A><BR> 
									<A HREF="index.php?action=about"><? echo _ABOUT_APP ?></A><BR> 
									<A HREF="group.php?action=info"><? echo _ABOUT_GROUP ?></A><BR> 
							<hr width="100%" size="1" noshade> 
								<A HREF="login.php?lo=true"><? echo _LOGOUT ?></A></P> 
								<? endif;?> 
					<?endif;?> 
				</TD>
				<TD VALIGN="top" width="520" align="center">
