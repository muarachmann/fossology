<?php
/***********************************************************
 Copyright (C) 2008-2011 Hewlett-Packard Development Company, L.P.

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 version 2 as published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
***********************************************************/

/***************************************************************
 $GlobalReady is only set here.
 This flag tells all other PHP code that it is running from this system.
 If other PHP code does not see this flag, then the code is not being
 executed correctly and should exit immediately (without taking further
 action).
 ***************************************************************/
$GlobalReady=1;
$SysConf = array();

//require("i18n.php"); DISABLED until i18n infrastructure is set-up.
require_once(dirname(__FILE__) . '/../php/pathinclude.php');
require_once("common/common.php");

/****************************************************
 This is the main guts of the UI: Find the plugin and run it.
 ****************************************************/
plugin_load("plugins/simpleUi");

$Mod = GetParm("mod",PARM_STRING);
if (!isset($Mod)) { $Mod = "Default"; }
$PluginId = plugin_find_id($Mod);
if ($PluginId >= 0)
  {
  /* Initialize global system configuration variables $SysConfig[] */
  InitSysConfig();

  /* Found a plugin, so call it! */
  //echo "<pre>Calling plugin {$Plugins[$PluginId]->Name}\n</pre>";
  $Plugins[$PluginId]->OutputOpen("HTML",1);
  // error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
  $Plugins[$PluginId]->Output();
  $Plugins[$PluginId]->OutputClose();
  }
else
  {
  $Uri = Traceback_uri() . "?mod=auth";
  $text = _("Module unavailable or your login session timed out.");
  print "$text <P />";
  $text01= _("Click here to continue.");
  print "<a href='$Uri'>" . $text01 . "</a>";
  print "<script language='JavaScript'>\n";
  print "function Redirect()\n";
  print "{\n";
  print "window.location.href = '$Uri';\n";
  print "}\n";
  /* Redirect in 5 seconds. */
  print "window.setTimeout('Redirect()',5000);\n";
  print "</script>\n";
  }
plugin_unload();
return(0);

/*  Initialize global system configuration variables $SysConfig[] */
function InitSysConfig()
{
  global $SysConf;
  global $PG_CONN;
  global $Plugins;

  $PluginId = plugin_find_id("foconfig");
  if ($PluginId >= 0)
  {
    /* make sure config table exists */
    $Plugins[$PluginId]->Install();
    $sql = "select variablename, conf_value from sysconfig";
    $result = pg_query($PG_CONN, $sql);
    DBCheckResult($result, $sql, __FILE__, __LINE__);

    while($row = pg_fetch_assoc($result))
    {
      $SysConf[$row['variablename']] = $row['conf_value'];
    }
    pg_free_result($result);
  }
  else
  {
    /* nothing, plugins will use default variables */
  }
}
?>
