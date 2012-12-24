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
				if (in_array($chatUser['user_id'], $chatUsers)) continue;
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
		//Get closed users chat
		
		$closeChatUsers = $chat->getClosedChatUsers();
		if(!empty($closeChatUsers)){
			$currentUserArray = array();
			foreach($closeChatUsers as $chatUserId){
				$chatMessage = $chat->getNewChatMessage($params['userId'], $chatUserId);
				if($chatMessage){
					$chatUserInfo = $userObj->getUserBasicInfo($chatUserId);
					$chatUserName = $chatUserInfo['user_name'];
					$smarty->assign('chatUserId', $chatUserId);
					$smarty->assign('chatUserName', $chatUserName);
					//Get the Chat messages between two Users
					$chatMessage = $chat->getChatMessage($params['userId'], $chatUserId);
					$smarty->assign('chatMessage', $chatMessage);
					$chat->addChatUser($chatUserId);
					//array_push($currentUserArray, $chatUserId);
					$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_chatWindow.tpl');
					array_push($newChatWindow, array('chatUserId' => $chatUserId,  'chatWindow' => $moduleContent));
				}
			}
		}
		return $newChatWindow;
	}
}
?>