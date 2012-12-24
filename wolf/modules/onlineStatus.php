<?php
class onlineStatusModule {
	function display($db = '', $params = array())
	{
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$authorization = getObject('authorization');
		$userArray = $authorization->getOnlineUserStatus($params['userId']);
		return $userArray;
	}
}
?>