<?php
class friendModule {
	function display($db = '', $params = array())
	{
		global $smarty, $genderArray;
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$friend = getObject('friend');
		$userId = $params['userId'];
		$friendList = $friend->getFriendsForUser($userId);
		$smarty->assign('friendList', $friendList);
		$smarty->assign('genderArray', $genderArray);
		$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
		return $moduleContent;
	}
}
?>