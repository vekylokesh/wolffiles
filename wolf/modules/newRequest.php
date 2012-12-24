<?php
class newRequestModule {
	function display($db = '', $params = array())
	{
		global $smarty, $genderArray;
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$invitation = getObject('invitation');
		$userId = $params['userId'];
		$newRequest = $invitation->getNewRequestForUser($userId);
		$smarty->assign('newRequest', $newRequest);
		$smarty->assign('genderArray', $genderArray);
		$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
		return $moduleContent;
	}
}
?>