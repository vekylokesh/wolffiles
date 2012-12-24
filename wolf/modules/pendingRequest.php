<?php
class pendingRequestModule {
	function display($db = '', $params = array())
	{
		global $smarty, $genderArray;
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$invitation = getObject('invitation');
		$userId = $params['userId'];
		$pendingRequest = $invitation->getPendingRequestForUser($userId);
		$smarty->assign('pendingRequest', $pendingRequest);
		$smarty->assign('genderArray', $genderArray);
		$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
		return $moduleContent;
	}
}
?>