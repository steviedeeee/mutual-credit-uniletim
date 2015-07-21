
<?

?>
      </div>
      <div class="child">
		<?
		if ($auth=="0") { echo "powered by <strong>uniLETIM</strong>"; }
		else {

			$foot_menu = new Menu1($menu_i);
			$foot_menu->class = "child";
			$foot_menu->view($menu);

		}

		?>
      </div>
	  </div>
 </body>
</html>
