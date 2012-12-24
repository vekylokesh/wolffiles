<?php
class messageModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$message = getObject('message');
		$userId = $params['id'] ? $params['id'] : $params['userId'];
		$msgId = $params['msgId'] ? (int)$params['msgId'] : 0;
		$mailList = $message->getMessageList($userId, $msgId);
		$smarty->assign('mailList', $mailList);
		$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
		return $moduleContent;
	}
}
?>