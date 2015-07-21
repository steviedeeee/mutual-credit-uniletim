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
 
 
#
# structure of table `uniletim_auth`
#
 
if ($inst == "") 
{ 
include "config.php"; 
} 


#
# structure of table `uniletim_announces`
#
mysql_query("
CREATE TABLE uniletim_announces (
  ann_id int(10) unsigned NOT NULL auto_increment,
  ann_member varchar(50) default NULL,
  ann_name varchar(40) default '0',
  ann_sub int(10) unsigned NOT NULL default '0',
  ann_date int(10) unsigned NOT NULL default '0',
  ann_validity date default NULL,
  ann_sec tinyint(3) NOT NULL default '0',
  ann_text text NOT NULL,
  ann_price varchar(25) default NULL,
  ann_oq varchar(15) NOT NULL default '',
  ann_state char(1) NOT NULL default 'n',
  ul_group varchar(40) NOT NULL default '',
  PRIMARY KEY  (ann_id)
)
");
# --------------------------------------------------------


#
# structure of table `uniletim_auth`
#
 
mysql_query(" 
CREATE TABLE uniletim_auth (
  aut_id varchar(80) NOT NULL default '', 
  aut_date int(10) NOT NULL default '0', 
  aut_user varchar(50) NOT NULL default '', 
  aut_typ tinytext NOT NULL, 
  aut_group varchar(40) NOT NULL default '', 
  aut_perms varchar(5) NOT NULL default '', 
  aut_design varchar(20) NOT NULL default '', 
  aut_style varchar(20) NOT NULL default '',
  aut_group_name varchar(35) NOT NULL default '',
  aut_lang varchar(20) NOT NULL default '',
  PRIMARY KEY  (aut_id)
) 
");
# -------------------------------------------------------- 

#
# structure of table `uniletim_groups`
#
mysql_query("
CREATE TABLE uniletim_groups (
  grp_id varchar(50) NOT NULL default '',
  grp_name varchar(50) NOT NULL default '',
  grp_send int(2) NOT NULL default '0',
  grp_type varchar(8) NOT NULL default '0',
  grp_design varchar(20) NOT NULL default '',
  grp_style varchar(20) NOT NULL default '',
  grp_lang varchar(20) NOT NULL default '',
  PRIMARY KEY  (grp_id)
)
");

# --------------------------------------------------------

#
# structure of table `uniletim_members`
#

mysql_query("
CREATE TABLE uniletim_members (
  mbr_id varchar(32) NOT NULL default '',
  mbr_login varchar(32) NOT NULL default '',
  mbr_password varchar(32) NOT NULL default '',
  mbr_perms varchar(30) NOT NULL default '',
  mbr_surname varchar(30) default NULL,
  mbr_name varchar(20) default NULL,
  mbr_email varchar(50) default NULL,
  mbr_web varchar(40) default NULL,
  mbr_info text,
  mbr_send varchar(5) default NULL,
  mbr_phone varchar(40) NOT NULL default '',
  ul_group varchar(40) NOT NULL default '',
  mbr_state varchar(5) default 'y',
  mbr_design varchar(20) default NULL,
  mbr_style varchar(20)  default NULL,
  PRIMARY KEY  (mbr_id)
)
");
# --------------------------------------------------------

#
# structure of table `uniletim_perms`
#
mysql_query("CREATE TABLE uniletim_perms (
  perm_id int(3) unsigned NOT NULL auto_increment,
  perm_member varchar(40) NOT NULL default '',
  perm_group varchar(40) NOT NULL default '',
  perm_perms varchar(3) NOT NULL default '',
  perm_default varchar(1) default NULL,
  PRIMARY KEY  (perm_id)
)");
# --------------------------------------------------------

#
# structure of table `uniletim_sections`
#
mysql_query("
CREATE TABLE uniletim_sections (
  sec_id int(3) unsigned NOT NULL auto_increment, 
  sec_name varchar(50) NOT NULL default '',
  ul_group varchar(40) NOT NULL default '',
  sec_type varchar(10) NOT NULL default 'ann',
  PRIMARY KEY  (sec_id)
)
");

# --------------------------------------------------------

#
# structure of table `uniletim_services`
# 
mysql_query("
CREATE TABLE uniletim_services (
  ser_id int(11) NOT NULL auto_increment, 
  ser_recipient varchar(50) default NULL, 
  ser_provider varchar(50) default NULL, 
  ser_date date default NULL, 
  ser_service varchar(250) default NULL, 
  ser_amount decimal(6,2) NOT NULL default '0.00',
  ser_time int(10) NOT NULL default '0',
  ul_group varchar(40) NOT NULL default '', 
  PRIMARY KEY  (ser_id) 
) 
"); 
# -------------------------------------------------------- 
 
# 
# structure of table `uniletim_subsections`
# 
mysql_query(" 
CREATE TABLE uniletim_subsections (
  sub_id int(3) unsigned NOT NULL auto_increment, 
  sub_name varchar(50) NOT NULL default '', 
  sub_section int(3) NOT NULL default '0', 
  ul_group varchar(40) NOT NULL default '', 
  PRIMARY KEY  (sub_id) 
) 
"); 
# --------------------------------------------------------
 


?>
