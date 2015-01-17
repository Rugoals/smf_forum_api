<?php
if (!defined('SMF')) die('Hacking attempt...');

function forum_api_view() {
 	global $context;
 	
 	loadTemplate('Forum-api');

	if ($context['current_action'] == 'forum-api') {	
	 	$context = '';
	 	$context['sub_template'] = 'forum_api_main';
	} 
}

function forum_api_actions(&$actionArray) {
	$actionArray['forum-api'] = array('Subs-Forum-api.php','forum_api_view');
}

function forum_api_mod_settings(&$config_vars) {
	global $txt;

	loadLanguage('Forum-api');

    $config_vars[] = '';
	$config_vars[] = $txt['fa_title_admin'];
	$config_vars[] = array('check', 'fa_enable');
	$config_vars[] = array('text', 'fa_min_symbol'); 
	$config_vars[] = array('text', 'fa_max_symbol'); 
	$config_vars[] = array('text', 'fa_count_result'); 
	$config_vars[] = array('text', 'fa_disable_id'); 
 
}

?>