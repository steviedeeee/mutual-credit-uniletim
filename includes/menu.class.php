<?php

class Menux {

  var $items;
  var $class;
  var $perm_mbr;
  var $mod;

  # konstruktor
  function Menux($items = array()) {
  	global $sess;
    $this->perm_mbr = $sess[5];

    reset($items);
    while (list($name, $url, $perm, $mod) = each($items)) {
      $this->names[] = $name;
      $this->urls[] = $url;
      $this->perms[] = $perm;
      $this->mods[] = $mod;
     }
  }

  # vlo¾ení nové polo¾ky menu
  function insert($name, $url, $perm, $mod="main") {
    $this->names[] = $name;
    $this->urls[] = $url;
    $this->perms[] = $perm;
    $this->mods[] = $mod;
  }

  # zobrazení jedné polo¾ky menu
  function viewItem($x,$mod,$modsens) {

	if (!$modsens & $this->mods[$x] == $mod) {
    	print '<span>' . $this->names[$x] . '</span>';
		}
	elseif (!$modsens || $this->mods[$x] == $mod) {
    	print '<a href="' . $this->urls[$x] . '">' . $this->names[$x] . '</a>';
		}

  }

  # vypsání menu na stránku
  function view($mod,$modsens="1") {

    if ($this->class) print '<p class="' . $this->class . '">';
	else print '<p>';
    for ($x = 0; $x < count($this->urls); $x++) {
    	if ($this->perm_mbr >= $this->perms[$x])
		$this->viewItem($x,$mod,$modsens);
    }
    print '</p>';
  }



}

class Menu1 extends Menux {

  # konstruktor
  function Menu1($items) {
  	global $sess;
    $this->perm_mbr = $sess[5];

	$count = Count($items);
	for($i=0; $i < $count; $i++) {
      $this->names[] = $items[$i][0];
      $this->urls[] = $items[$i][1];
      $this->perms[] = $items[$i][2];
      $this->mods[] = $items[$i][3];
		}

  }

}

class Menu2 extends Menux {

  function Menu2($items) {
  	global $sess;
    $this->perm_mbr = $sess[5];

	$count = Count($items);
	for($i=0; $i < $count; $i++) {

      $this->names[] = $items['id'][$i];
      $this->urls[] = $items['name'][$i];
		}
  }

  function viewItem($x,$mod) {
    print '<a href="' . $this->urls[$x] . '">'
       . $this->names[$x] . '</a>';
  }
}


$menu_m[] = array(_ANNOUNCES,"./index.php","1","ann");
$menu_m[] = array(_MEMBERS,"./u_zoznam.php","1","mbr");
$menu_m[] = array(_PAYMENTS,"./platby.php?action=view","1","pay");
$menu_m[] = array(_ADMINISTRATION,"?menu=adm","1","adm");
$menu_m[] = array(_HELP,"?menu=help","1","help");


$menu_i[] = array(_ANNOUNCES,"./index.php","1","ann");
$menu_i[] = array(_MY_ANNOUNCES,"./index.php?action=user","1","ann");
$menu_i[] = array(_NEW_ANNOUNCE,"./index.php?action=form&type=new","1","ann");
$menu_i[] = array(_PRINT,"./index.php?action=print","1","ann");

$menu_i[] = array(_MEMBERS,"./u_zoznam.php","1","mbr");
$menu_i[] = array(_NEW_MEMBER,"./u_novy.php","2","mbr");
$menu_i[] = array(_MY_PROFILE,"./u_zmena.php","1","mbr");
$menu_i[] = array(_PRINT,"./u_zoznam.php?action=print","1","mbr");

$menu_i[] = array(_PAYMENTS,"./platby.php?action=view","1","pay");
$menu_i[] = array(_PAYING_ORDER,"./platby.php?action=form","1","pay");
$menu_i[] = array(_MY_PAYMENTS,"./platby.php?action=user","1","pay");
$menu_i[] = array(_PRINT,"./platby.php?action=print","1","pay");

$menu_i[] = array(_SECTIONS,"./r_zmena.php","2","adm");
$menu_i[] = array(_GROUP,"./group.php?action=edit","2","adm");
$menu_i[] = array(_NEW_GROUP,"./group.php?action=new","1","adm");
$menu_i[] = array(_GROUPS,"./group.php?action=list","3","adm");

$menu_i[] = array(_DOCUMENTATION,"./doc/manual_sk.html","1","help");
$menu_i[] = array(_ABOUT_APP,"./index.php?action=about","1","help");
$menu_i[] = array(_ABOUT_GROUP,"./group.php?action=info","1","help");


$top_menu = new Menu1($menu_m);
$top_menu->class = "brother";
$top_menu->view($menu,"0");


$sub_menu = new Menu1($menu_i);
$sub_menu->class = "child";
$sub_menu->view($menu);
?>
<!--






?>-->
