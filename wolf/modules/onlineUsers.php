<?php
class onlineUsersModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$authorization = getObject('authorization');
		$users = $authorization->getOnlineUsers($params['userId']);
		$smarty->assign('users', $users);
		$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
		return $moduleContent;
	}
}
?>