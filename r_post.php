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
if ($rz =="i")
{
    $sql = mysql_query("select * from uniletim_sections where sec_name='$rni' AND ul_group = '$sess[4]'");
    if (mysql_num_rows($sql) > 0) 
         {
      $error = _SECTION . " \"$rni\" " . _ALREADY_EXISTS;
     }
   else   {


      mysql_query("insert into uniletim_sections values('','$rni', '$sess[4]', '')");
      if (mysql_affected_rows() == 0) {
         $error = "<b>" . _ERROR . ":</b> \"$query\" \n";
         }
      else   {
             $result = _SECTION . " \"$rni\" " . _WAS_CREATED_MALE;
         }
      }
}
// editovanie rubrik
 if ($rz == "e")
{

    $sql = mysql_query("select * from uniletim_sections where sec_name = '$rne' AND ul_group = '$sess[4]'");
    if (mysql_num_rows($sql) > 0)
         {
      $error = _SECTION . " \"$rne\" " . _ALREADY_EXISTS . "\n";
     }
   else   {
      mysql_query("update uniletim_sections SET sec_name = '$rne' where sec_id = '$rie'");

      if (mysql_affected_rows() == 0) {
         $error = " <b>". _ERROR . ":</b> \"$query\" \n";
         }
      else   {
             $result = _SECTION . " \"$rne\" " . _WAS_CHANGED_MALE . "\n";
         }
      }

}

// zmazanie rubrik
if ($rz =="d")
{

      $sql = mysql_query("delete from uniletim_sections where sec_id='$rid'");
             $result = _SECTION . " \"$rnd\" " . _WAS_DELETED_MALE . "\n";

}
?>

