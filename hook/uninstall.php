<?php
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif(!defined('SMF'))
	die('<b>Error:</b> Cannot install - please verify that you put this file in the same place as SMF\'s index.php and SSI.php files.');

if ((SMF == 'SSI') && !$user_info['is_admin'])
	die('Admin privileges required.');
	
$hooks = array(
	'integrate_pre_include' => '$sourcedir/Subs-Forum-api.php', 
	'integrate_actions' => 'forum_api_actions', 
	'integrate_general_mod_settings' => 'forum_api_mod_settings'
);

foreach ($hooks as $hook => $function) {
	remove_integration_function($hook, $function);
}
if (SMF == 'SSI')
	echo 'Database changes are complete! Please wait...';