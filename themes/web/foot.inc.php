<?

?>
			</td>
			<td height="490" valign="top" class="col"> 
				<? if ($sess[3] == "lets" || $auth == "0"):?> 
					<div><br><br> 
					<img src="./img/ul-logo.gif" width="115" border="0" alt="logo" hspace="0" vspace="0">
					<h4><? member_group_select ($sess); ?></h4>
					</div> 
				<? endif; ?>&nbsp; 
			</td> 
 
			</TR> 
			<TR> 
				<TD class="col" VALIGN="top"></TD> 
				<td valign="top"><br><FONT SIZE="-2"><?echo $foot_call;?></FONT></td> 
				<TD class="col" VALIGN="top"></TD> 
			</TR> 
		</TABLE> 
</BODY> 
</HTML>
