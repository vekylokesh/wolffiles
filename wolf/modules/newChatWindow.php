<?php
class newChatWindowModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		global $authorization;
		$chat = getObject('chat');
		$userObj = getObject('user');
		$newChatWindow = array();
		$chatUsers = $chat->getChatUsers();
		$onlineUsers = $authorization->getOnlineUsers($params['userId'], true);
		//Get new user Chats
		if($onlineUsers){
			foreach($onlineUsers as $chatUser){
				if (is_array($chatUsers) && in_array($chatUser['user_id'], $chatUsers)) continue;
				$chatMessage = $chat->getNewChatMessage($params['userId'], $chatUser['user_id']);
				if($chatMessage){
					$chatUserName = $chatUser['user_name'];
					$smarty->assign('chatUserId', $chatUser['user_id']);
					$smarty->assign('chatUserName', $chatUserName);
					//Get the Chat messages between two Users
					$chatMessage = $chat->getChatMessage($params['userId'], $chatUser['user_id']);
					$smarty->assign('chatMessage', $chatMessage);
					$chat->addChatUser($chatUser['user_id']);
					//array_push($currentUserArray, $chatUserId);
					$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_chatWindow.tpl');
					array_push($newChatWindow, array('chatUserId' => $chatUser['user_id'],  'chatWindow' => $moduleContent));
				}
			}
		}
		return $newChatWindow;
	}
}
?>