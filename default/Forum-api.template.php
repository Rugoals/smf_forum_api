<?php

function template_forum_api_main(){
	global $scripturl, $modSettings, $txt, $smcFunc;
	header('Content-Type: text/html; charset=utf-8'); 
	 
	mb_internal_encoding('UTF-8');
	setlocale(LC_ALL, 'ru_RU.UTF-8');
 
	$modSettings['fa_max_symbol'] = !empty($modSettings['fa_max_symbol']) ? $modSettings['fa_max_symbol'] : 30;
	$modSettings['fa_min_symbol'] = !empty($modSettings['fa_min_symbol']) ? $modSettings['fa_min_symbol'] : 2;
	$modSettings['fa_count_result'] = !empty($modSettings['fa_count_result']) ? $modSettings['fa_count_result'] : 12;

	$content = array();	

	if($modSettings['fa_enable']) {

		$search = isset($_REQUEST['search']) ? urldecode(trim($_REQUEST['search'])) : '';
 
		if(!empty($search)) { 
			$search = preg_replace('/[^ a-zA-Z0-9А-Яа-яЁё]/iu', '', html_entity_decode($search,ENT_QUOTES,UTF-8));
			$search = mb_substr($search, 0, $modSettings['fa_max_symbol']);

			if(mb_strlen($search) > $modSettings['fa_min_symbol']) {

				$w = array_unique(explode(' ',$search));
				$i = 0;
				$param_search = array(); 
				foreach($w as $word) {
					$i++;
					if(mb_strlen($word) > $modSettings['fa_min_symbol']){
						$param_search['search_'.$i] = '%'.$word.'%';
					}
				}
 	 
				$query_search = "
					SELECT 
					id_msg, id_board, poster_time, subject 
					FROM {db_prefix}messages 
					WHERE";

				$subject_search = array();
				foreach( array_keys ($param_search) as $subject) {
					$subject_search[] = " subject LIKE {string:".$subject."} ";
				}			
				$query_search .= implode('AND', $subject_search);
		
				if(!empty($modSettings['fa_disable_id'])) {
					$query_search .= " AND id_board NOT IN (".$modSettings['fa_disable_id'].") ";
				}

				$query_search .= "ORDER BY poster_time DESC LIMIT 0, ".$modSettings['fa_count_result'];
	  	 
 				$query = $smcFunc['db_query']('', $query_search, $param_search );
				while($row = $smcFunc['db_fetch_assoc']($query)) { 
				$content[] = array(
						'title' =>  $row['subject'] ,
						'id_msg' => $row['id_msg'],
						'date' => $row['poster_time'],
						'url' => 'http://'.$_SERVER['SERVER_NAME'].'/index.php?topic='.$row['id_msg'].'.0'
						);
					 
				}  
			}
		}
	} 
	echo json_encode($content); 
}
 
?>