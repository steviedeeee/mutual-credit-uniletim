
<? 
?> 
<HTML>
	<HEAD>
		<meta http-equiv="Expires" content="max-age=0">
		<META HTTP-EQUIV="content-type" CONTENT="text/html;charset=<? echo _AppEncoding ?>">
		<META HTTP-EQUIV="Author" CONTENT="Priestor, o.z.">
		<TITLE>uniLETIM - <? echo $sess[8] ?></TITLE>
		<LINK REL="stylesheet" HREF="./themes/css/<? echo $style ?>.css">
		
	
		
	</HEAD>
	<BODY BGCOLOR="White" leftmargin="0" topmargin="0">
	<? if ($auth != "0"): ?>
<SCRIPT language=JavaScript type=text/javascript>
/*
 Milonic DHTML Website Navigation Menu - Version 3.x
 Written by Andy Woolley - Copyright 2002 (c) Milonic Solutions Limited. All Rights Reserved.
 Please visit http://www.milonic.co.uk/menu or e-mail menu3@milonic.com for more information.
 
 The Free use of this menu is only available to Non-Profit, Educational & Personal web sites.
 Commercial and Corporate licenses  are available for use on all other web sites & Intranets.
 All Copyright notices MUST remain in place at ALL times and, please keep us informed of your 
 intentions to use the menu and send us your URL.
*/


//The following line is critical for menu operation, and MUST APPEAR ONLY ONCE. If you have more than one menu_array.js file rem out this line in subsequent files
menunum=0;menus=new Array();_d=document;function addmenu(){menunum++;menus[menunum]=menu;}function dumpmenus(){mt="<script language=javascript>";for(a=1;a<menus.length;a++){mt+=" menu"+a+"=menus["+a+"];"}mt+="<\/script>";_d.write(mt)}
//Please leave the above line intact. The above also needs to be enabled if it not already enabled unless this file is part of a multi pack.



////////////////////////////////////
// Editable properties START here //
////////////////////////////////////

// Special effect string for IE5.5 or above please visit http://www.milonic.co.uk/menu/filters_sample.php for more filters
effect = "Fade(duration=0.2);Alpha(style=0,opacity=88);Shadow(color='#777777', Direction=135, Strength=5)"


timegap=500			// The time delay for menus to remain visible
followspeed=5		// Follow Scrolling speed
followrate=40		// Follow Scrolling Rate
suboffset_top=4;	// Sub menu offset Top position 
suboffset_left=6;	// Sub menu offset Left position
closeOnClick = true

"#ffffff","yellow","#339966","green"
style1=[			// style1 is an array of properties. You can have as many property arrays as you need. This means that menus can have their own style.
"yellow",				// Mouse Off Font Color
"green",			// Mouse Off Background Color
"#ffffff",			// Mouse On Font Color
"#449966",			// Mouse On Background Color
"000000",			// Menu Border Color 
12,					// Font Size in pixels
"normal",			// Font Style (italic or normal)
"bold",				// Font Weight (bold or normal)
"Helvetica, Arial",	// Font Name
4,					// Menu Item Padding
,		// Sub Menu Image (Leave this blank if not needed)
,					// 3D Border & Separator bar
"66ffff",			// 3D High Color
"000099",			// 3D Low Color
"yellow",			// Current Page Item Font Color (leave this blank to disable)
"#339966",				// Current Page Item Background Color (leave this blank to disable)
,		// Top Bar image (Leave this blank to disable)
"ffffff",			// Menu Header Font Color (Leave blank if headers are not needed)
"000099",			// Menu Header Background Color (Leave blank if headers are not needed)
"black",				// Menu Item Separator Color
]


addmenu(menu=[		// This is the array that contains your menu properties and details
"mainmenu",			// Menu Name - This is needed in order for the menu to be called
0,					// Menu Top - The Top position of the menu in pixels
0,				// Menu Left - The Left position of the menu in pixels
130,					// Menu Width - Menus width in pixels
1,					// Menu Border Width 
,					// Screen Position - here you can use "center;left;right;middle;top;bottom" or a combination of "center:middle"
style1,				// Properties Array - this is set higher up, as above
1,					// Always Visible - allows the menu item to be visible at all time (1=on/0=off)
"center",				// Alignment - sets the menu elements text alignment, values valid here are: left, right or center
,					// Filter - Text variable for setting transitional effects on menu activation - see above for more info
,					// Follow Scrolling - Tells the menu item to follow the user down the screen (visible at all times) (1=on/0=off)
1, 					// Horizontal Menu - Tells the menu to become horizontal instead of top to bottom style (1=on/0=off)
,					// Keep Alive - Keeps the menu visible until the user moves over another menu or clicks elsewhere on the page (1=on/0=off)
,					// Position of TOP sub image left:center:right
,					// Set the Overall Width of Horizontal Menu to 100% and height to the specified amount (Leave blank to disable)
,					// Right To Left - Used in Hebrew for example. (1=on/0=off)
,					// Open the Menus OnClick - leave blank for OnMouseover (1=on/0=off)
,					// ID of the div you want to hide on MouseOver (useful for hiding form elements)
,					// Background image for menu when BGColor set to transparent.
,					// Scrollable Menu
,					// Reserved for future use
,"<? echo _ANNOUNCES ?>","show-menu=announces",,"",0 
,"<? echo _MEMBERS ?>","show-menu=members",,"",0
,"<? echo _PAYMENTS ?>","show-menu=transactions",,"",0
,"<? echo _ADMINISTRATION ?>","show-menu=administration",,"",0
,"<? echo _HELP ?>","show-menu=help",,"",0
,"<? echo _LOGOUT ?>","./login.php?lo=true",,"",0
])

	addmenu(menu=["announces",,,130,1,,style1,0,"left",effect,0,,,,,,,,,,,
<?$sql = mysql_query("SELECT * FROM uniletim_sections where ul_group = '$sess[4]'");
  while ($row = mysql_fetch_row($sql)): ?>
	,"<? echo $row[1]; ?>","./index.php?rub=<? echo "$row[0]"; ?>",,,1
<? endwhile; ?>
	,"<? echo _MY_ANNOUNCES ?>","./index.php?action=user",,,1
	,"<? echo _NEW_ANNOUNCE ?>","./index.php?action=form&type=new",,,1
	,"<? echo _PRINT ?>","./index.php?action=print",,,1
	])

	addmenu(menu=["members",,,130,1,,style1,0,"left",effect,0,,,,,,,,,,,
	,"<? echo _MEMBERS ?>","./u_zoznam.php",,,1
	<?if ($sess[5] >= "2"):?> 
 	,"<? echo _NEW_MEMBER ?>","./u_novy.php",,,1
	<?endif;?> 
	,"<? echo _MY_PROFILE ?>","./u_zmena.php",,,1
	,"<? echo _PRINT ?>","./u_zoznam.php?action=print",,,1
	])
	
	addmenu(menu=["transactions",,,130,1,,style1,0,"left",effect,0,,,,,,,,,,,
	,"<? echo _PAYMENTS ?>","./platby.php?action=view",,,1
	,"<? echo _PAYING_ORDER ?>","./platby.php?action=form",,,1
	,"<? echo _MY_PAYMENTS ?>","./platby.php?action=user",,,1
	,"<? echo _PRINT ?>","./platby.php?action=print",,,1
	])
	
	addmenu(menu=["administration",,,130,1,,style1,0,"left",effect,0,,,,,,,,,,,
	<?if ($sess[5] >= "2"):?>
	,"<? echo _SECTIONS ?>","./r_zmena.php",,,1
	,"<? echo _GROUP ?>","./group.php?action=edit",,,1
	<? endif; ?>
	,"<? echo _NEW_GROUP ?>","./group.php?action=new",,,1
	<?if ($sess[5] == "3"):?>
	,"<? echo _GROUPS ?>","./group.php?action=list",,,1
	<? endif; ?>
	])
	
	addmenu(menu=["help",,,130,1,,style1,0,"left",effect,0,,,,,,,,,,,
	,"<? echo _DOCUMENTATION ?>","./doc/manual_sk.html",,,1
	,"<? echo _ABOUT_APP ?>","./index.php?action=about",,,1
	,"<? echo _ABOUT_GROUP ?>","./group.php?action=info",,,1
	])
	

dumpmenus()

</SCRIPT>
<SCRIPT language=JavaScript src="./js/mmenu.js" type=text/javascript></SCRIPT>
<br>
<? else: ?>
<table cellpadding="0" cellspacing="0" border="0" width="780"><tr><td bgcolor="green">&nbsp;</td></tr></table>
<? endif; ?>
		<table width="780" border="0" cellspacing="0" cellpadding="10">
			<TR>
				<TD width="110" VALIGN="top" class="col" align="center">
					<? if ($auth == "0"): ?> 
							<B><? echo _LOGGED_AS ?>:</B><BR> 
							<? echo _ANONYMOUS ?><br> 
								<A HREF="login.php"><? echo _LOGIN ?></A> <br><br>
							<? echo "Vytvorte:" ?><br> 
								<A HREF="install.php"><? echo _NEW_GROUP ?></A> <br>
					<? else:  ?>
						<br><br>
						<img src="./img/ul-logo.gif" width="90" border="0" alt="logo" hspace="0" vspace="0">
				    	<h4><? member_group_select ($sess); ?></h4>
					<? endif; ?>
				</TD>
				<TD VALIGN="top" width="520" align="center">
