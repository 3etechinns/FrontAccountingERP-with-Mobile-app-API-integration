<?php if (!defined('PmWiki')) exit();
/*
+-------------------------------------------------------------------+
| Copyright © 2005 Hagan Fox
| * Original view.php Copyright © 2005 Hans Bracker, who
|   did all of the actual heavy lifting by writing view.php.
|   See http://www.pmwiki.org/wiki/Cookbook/ViewModes
| You can redistribute this file and/or modify it under the terms
| of the GNU General Public License as published by the Free
| Software Foundation; either version 2 of the License, or (at your
| option) any later version. See http://www.gnu.org/licenses/gpl.txt
| 
| This script adds the following to PmWiki:
| $View variable from a list $ViewList, 
| ?setview=... cookie switcher and ?view=... switcher,
| (:if view ... :) conditional markup, 
| {$View} variable replacement.
+-------------------------------------------------------------------+
*/

global $View, $EnableViewSwitching, $ViewList, $ViewCookieExpires,
  $Conditions, $condparm, $Now; // TODO: Need them all?

## Default view
if (empty($View)) { SDV($View, 'wiki'); }

## enable view switching
SDV($EnableViewSwitching, 1);

## defining $ViewList array:
SDVA($ViewList, array(
  '' => '',
  'site'  => 'site',
  'wiki'  => 'wiki', 
  'hybrid'  => 'hybrid', 
  'admin' => 'admin',
  'demo1' => 'demo1',
  'demo2' => 'demo2',
  'demo3' => 'demo3',
  ));

## If enabled $View can be set with a cookie by ?setview=....
## and without a cookie by ?view=....
## Setview cookie routine:
SDV($LightViewCookie, $CookiePrefix.'lightview');
if($EnableViewSwitching == 1) {
  SDV($ViewCookieExpires, $Now+60*60*24*365);
  if (isset($_COOKIE[$LightViewCookie])) { $sv = $_COOKIE[$LightViewCookie]; }
  if (isset($_GET['setview']) && in_array($_GET['setview'], $ViewList)) {
    $sv = $_GET['setview'];
    setcookie($LightViewCookie, $sv, $ViewCookieExpires, '/');
  }
  if (isset($_GET['view'])) { $sv = $_GET['view']; }
  if (@$ViewList[$sv]) { $View = $ViewList[$sv]; }
}

## (:if view viewname:) conditional markup:
$Conditions['view'] = "\$GLOBALS['View']==\$condparm";

## {$View} markup 'variable' replacement
Markup('{$View}', '>{$fmt}', '/{\\$View}/e', "\$GLOBALS['View']");
