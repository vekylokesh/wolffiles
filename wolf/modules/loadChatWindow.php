<?php
class loadChatWindowModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		global $authorization;
		$chat = getObject('chat');
		$userObj = getObject('user');
		$newChatWindow = array();
		$chatUsers = $chat->getChatUsers();
		if(!empty($chatUsers)){
			foreach($chatUsers as $chatUserId){
				$chatMessage = $chat->getChatMessage($params['userId'], $chatUserId);
				if($chatMessage){
					$chatUserInfo = $userObj->getUserBasicInfo($chatUserId);
					$chatUserName = $chatUserInfo['user_name'];
					$smarty->assign('chatUserId', $chatUserId);
					$smarty->assign('chatUserName', $chatUserName);
					//Get the Chat messages between two Users
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