
<?
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />
  <meta name="author" content="Priestor, o.z. - Ondrej Vegh, Robert Zelnik; e-mail: uniletim@vsieti.sk" />
  <meta name="robots" content="all,follow" />
  <title>
   uniLETIM
  </title>
  <link rel="stylesheet" media="screen" type="text/css" href="./themes/css/xhtml.css" />
 </head>
 <body>
	<!--<SCRIPT language=JavaScript type=text/javascript>
	 <?php //include "./includes/menu-rol.inc.php";?>
    </SCRIPT>
    <SCRIPT language=JavaScript src="./js/mmenu.js" type=text/javascript></SCRIPT>-->

     <div id="main">
      <div id="header">
	  <div id="right"><?php
	   if ($auth!="0") {
			member_name ($sess[2]);
			echo "&nbsp;@&nbsp;";
			member_group_select ($sess);
			echo "<br />
        	<a href=\"login.php?lo=true\">logout</a>"; }
		else { echo "
			<a href=\"login.php\">login</a>"; } ?>

       </div>
       <h1>
        uniLETIM
       </h1>
       <p id="about">
        <? echo _UNILETIM_DESCRPTN ?>
       </p>

      </div><?
	  if ($auth!="0") {?>
      <div id="subheader"><?
		    include "./includes/menu.class.php";?>
      </div><?
	  }?>

	  <div id="center">

