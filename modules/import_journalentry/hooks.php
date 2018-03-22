<?php
class hooks_tutorial1 extends hooks 
{
var $module_name = ‘tutorial1’;
/*
* Install additional menu options provided by module
*/
function install_options($app) 
{
global $path_to_root;
$module_root = $path_to_root . '/modules/tutorial1/’;
switch ($app->id) {
case 'proj': // proj is the Application Id for Dimensions
$app->add_rapp_function(0, _('Tutorial 1 One'), $module_root. 'create.php',
'SA_OPEN', MENU_MAINTENANCE);
$app->add_lapp_function(1, _('Tutorial 1 Two'), $module_root. 'config.php',
'SA_OPEN', MENU_INQUIRY);
$app->add_rapp_function(2, _('Tutorial 1 Three'), $module_root. 'cancel.php',
'SA_OPEN', MENU_TRANSACTION);
break;
}
}
}
?>