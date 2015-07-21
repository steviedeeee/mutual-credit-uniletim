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

if ($update != "all"){
mysql_query("ALTER TABLE uniletim_auth CHANGE aut_design aut_design VARCHAR(20) NOT NULL");
 mysql_query("ALTER TABLE uniletim_members CHANGE mbr_design mbr_design VARCHAR(20) NOT NULL");
 mysql_query("ALTER TABLE uniletim_groups CHANGE grp_design grp_design VARCHAR(20) NOT NULL");
 mysql_query("ALTER TABLE uniletim_sections CHANGE type sec_type VARCHAR(10) NOT NULL");

mysql_query("ALTER TABLE uniletim_auth CHANGE aut_style aut_style VARCHAR(20) NOT NULL");
 mysql_query("ALTER TABLE uniletim_members CHANGE mbr_style mbr_style VARCHAR(20) NOT NULL");
 mysql_query("ALTER TABLE uniletim_groups CHANGE grp_style grp_style VARCHAR(20) NOT NULL");

mysql_query("CREATE TABLE uniletim_perms (
  perm_id int(3) unsigned NOT NULL auto_increment,
  perm_member varchar(40) NOT NULL default '',
  perm_group varchar(40) NOT NULL default '',
  perm_perms varchar(255) NOT NULL default '',
  perm_default varchar(1) default NULL,
  PRIMARY KEY  (perm_id)
)");

$sql = mysql_query("SELECT mbr_id, ul_group, mbr_perms FROM uniletim_members");

while ($row = mysql_fetch_row($sql))
	{
	mysql_query("INSERT INTO uniletim_perms VALUES('','$row[0]', '$row[1]', '$row[2]', 'd')");
	}


$sql = mysql_query("SELECT mbr_id FROM uniletim_members");

while ($row = mysql_fetch_row($sql))
	{
	mysql_query("UPDATE uniletim_members SET ul_group = '', mbr_perms = '' WHERE mbr_id = '$row[0]'");
	}
}
mysql_query("ALTER TABLE uniletim_groups CHANGE grp_logo grp_lang VARCHAR( 20 ) NOT NULL");
mysql_query("ALTER TABLE uniletim_auth ADD aut_lang VARCHAR( 20 ) NOT NULL");
mysql_query("ALTER TABLE uniletim_members CHANGE mbr_email mbr_email VARCHAR(30) NOT NULL");
mysql_query("ALTER TABLE uniletim_services CHANGE ser_amount ser_amount decimal(6,2) NOT NULL default '0.00'");



echo "updated";

?>
