<?php
class newChatMessageModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		global $authorization;
		$chat = getObject('chat');
		$newChatMessage = array();
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$chatUsers = $chat->getChatUsers();
		if(!empty($chatUsers)){
			foreach($chatUsers as $chatUserId){
				if(!$chatUserId) continue;
				$chatMessage = $chat->getNewChatMessage($params['userId'], $chatUserId);
				$chatUserStatus = $authorization->checkUserOnline($chatUserId);
				$status = 1;
				if($chatUserStatus && $chatUserStatus['session_login_status'] != STATUS_LOGGED_IN){
					$status = 0;
					$smarty->assign('userOfLine', $chatUserStatus);
					$chat->closeChatUser($chatUserId);
				}
				$smarty->assign('chatMessage', $chatMessage);
				$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
				$message[$chatUserId] = $moduleContent;
				array_push($newChatMessage, array('chatUserId' => $chatUserId,  'chatMessage' => $moduleContent, 'status' => $status));
			}
		}
		return $newChatMessage;
	}
}
?>