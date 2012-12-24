<?php
class newChatWindowModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		global $authorization;
		$chat = getObject('chat');
		//Get new chat messages
		$chkNewUser = $params['getAllWindow'] ? 1 : 0;
		$newUsers = $chat->getNewChatUser($chkNewUser);
		/*
		$closedUsers = $chat->getClosedUserMessage();
		
		if(!empty($closedUsers)){
			$newUsers = array_merge($newUsers, $closedUsers);
		}
		*/
		$newChatWindow = array();
		if($newUsers){
			$userObj = getObject('user');
			foreach($newUsers as $user)
			{
				$chatUserId = $user;
				$chatUserInfo = $userObj->getUserBasicInfo($user);
				$chatUserName = $chatUserInfo['user_name'];
				$smarty->assign('chatUserId', $chatUserId);
				$smarty->assign('chatUserName', $chatUserName);
				//Get the Chat messages between two Users
				$chatMessage = $chat->getChatMessage($params['userId'], $user);
				$smarty->assign('chatMessage', $chatMessage);
				//Store the data in session indicating Chat window created for give user
				if(!isset($_SESSION['chatUser'])){
					$_SESSION['chatUser'] = array();
				}
				if(!in_array($chatUserId, $_SESSION['chatUser'])){
					//Push in session when only there is no current user in session
					$_SESSION['chatUser'][] = $chatUserId;
				}
				//Get the Chat Window
				//$moduleContent .= $smarty->fetch(TEMPLATE_PATH.'/module/mod_chatWindow.tpl');
				$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_chatWindow.tpl');
				array_push($newChatWindow, array('chatUserId' => $chatUserId,  'chatWindow' => $moduleContent));
			}
		}
		return $newChatWindow;
	}
}
?>