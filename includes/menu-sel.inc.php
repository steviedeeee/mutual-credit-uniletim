<? ?>
<form action="./redirect.php" method="post">
           
<select name="spage" onchange="this.form.submit()" class="navigator">
		<option value="index.php">>>Navigator</option>
	<optgroup label="<? echo _ANNOUNCES ?>:"><?
		$sql = mysql_query("SELECT * FROM uniletim_sections where ul_group = '$sess[4]'");
		if (mysql_num_rows ($sql) >= "0"){
			while ($row = mysql_fetch_row($sql)){ ?>
         <option value="index.php?rub=<? echo "$row[0]"; ?>"><? echo $row[1]; ?></option><?
			}}?>
		 <option value="index.php?action=form&type=new"<?php if (isset($d)) { echo 'selected'; } ?>><? echo _NEW_ANNOUNCE ?></option><?
		if ($sess[3] == "lets"){?>
		 <option value="index.php?action=user"><? echo _MY_ANNOUNCES ?></option><?
		 	}?>
		 <option value="index.php?action=print" target="_blank"><? echo _PRINT ?></option>
	</optgroup>

  	<optgroup label="<? echo _MEMBERS ?>:">
			<option value="u_zoznam.php"><? echo _MEMBERS ?></option>
			<option value="u_novy.php"><? echo _NEW_MEMBER ?></option> <?
		if ($sess[3] == "lets"){?>
			<option value="u_zmena.php"><? echo _MY_PROFILE ?></option><?
			}?>
	</optgroup>

	<optgroup label="<? echo _PAYMENTS ?>:">
         <option value="platby.php?action=view"><? echo _PAYMENTS ?></option><?
		if ($sess[3] == "lets"){?>
		 <option value="platby.php?action=user"><? echo _MY_PAYMENTS ?></option><?
			}?>
		 <option value="platby.php?action=write"><? echo _PAYING_ORDER ?></option>
	</optgroup>
	<optgroup label="<? echo _ADMINISTRATION ?>:"><?
		if ($sess[5] >= "2"){ ?>
         <option value="r_zmena.php"><? echo _SECTIONS ?></option>
		 <option value="group.php?action=edit"><? echo _GROUP ?></option><?
			}?>
		 <option value="group.php?action=new"><? echo _NEW_GROUP ?></option><?
		if ($sess[5] == "3"){?>
		 <option value="group.php?action=list"><? echo _GROUPS ?></option><?
 			}?>
    </optgroup>

	<optgroup label="<? echo _HELP ?>:">
         <option value="/doc/manual_sk.html"><? echo _DOCUMENTATION ?></option>
		 <option value="index.php?action=about"><? echo _ABOUT_APP ?></option>
		 <option value="group.php?action=info"><? echo _ABOUT_GROUP ?></option>
       </optgroup>
</select>
         </form>
