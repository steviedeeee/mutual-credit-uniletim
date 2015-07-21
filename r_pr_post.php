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



// vkladanie rubrik
if ($prz =="i")
{
    $sqk = mysql_query("select * from uniletim_subsections where sub_name='$prni' AND sub_section='$rub' AND ul_group='$sess[4]'");
    if (mysql_num_rows($sqk) > 0)
         {
      $error = _SUBSECTION .  " \"$prni\" " . _ALREADY_EXISTS . "\n";
     }
   else   {


      mysql_query("insert into uniletim_subsections values('','$prni','$rub', '$sess[4]')");
      if (mysql_affected_rows() == 0) {
         $error = "<b>" . _ERROR . ":</b> \"$query\"\n";
         }
      else   {     
             $result = _SUBSECTION . " \"$prni\" " . _WAS_CREATED_MALE . "\n";
         }
      }
}
// editovanie rubrik
 if ($prz == "e")
{

    $sqk = mysql_query("select * from uniletim_subsections where sub_name='$prne' AND sub_section='$rub' AND ul_group = '$sess[4]'");
    if (mysql_num_rows($sqk) > 0)
         {
      $error = _SUBSECTION .  " \"$prne\" " . _ALREADY_EXISTS . "\n";
     }
   else   {
      mysql_query("update uniletim_subsections SET sub_name = '$prne' where sub_id = '$prie'");

      if (mysql_affected_rows() == 0) {
         $error = "<b>" . _ERROR . ":</b> \"$query\"</font></DIV>\n";
         }
      else   {
             $result = _SUBSECTION .  " \"$prne\" " . _WAS_CHANGED_MALE . "\n";
         }
      }

}

// zmazanie rubrik
if ($prz =="d")
{

      $sql = mysql_query("delete from uniletim_subsections where sub_id='$prid'");
             $result = _SUBSECTION . " \"$prnd\" " . _WAS_DELETED_MALE . "\n";

}
?>
