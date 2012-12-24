<?php
class chatWindowModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		$chat = getObject('chat');
		$chatUserId = $params['chatUserId'];
		$chatUserName = $params['chatUserName'];
		$smarty->assign('chatUserId', $chatUserId);
		$smarty->assign('chatUserName', $chatUserName);
		//Get the Chat messages between two Users
		$chatMessage = $chat->getChatMessage($params['userId'], $chatUserId);
		$smarty->assign('chatMessage', $chatMessage);
		//Store the data in session indicating Chat window created for give user
		$chat->addChatUser($chatUserId);
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
		return $moduleContent;
	}
}
?>