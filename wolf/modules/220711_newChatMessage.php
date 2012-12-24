<?php
class newChatMessageModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		global $authorization;
		$userObj = getObject('user');
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
					//$chat->removeChatUser($chatUserId);
					/*
					$key = array_search($chatUserId, $_SESSION['chatUser']);
					if($key !== false) {
						unset($_SESSION['chatUser'][$key]);
					}
					*/
				}
				$smarty->assign('chatMessage', $chatMessage);
				$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
				$message[$chatUserId] = $moduleContent;
				array_push($newChatMessage, array('chatUserId' => $chatUserId,  'chatMessage' => $moduleContent, 'status' => $status));
			}
		}
		
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
					array_push($newChatMessage, array('chatUserId' => $chatUserId,  'chatMessage' => $moduleContent));
				}
			}
			/*
			$_SESSION['closeChatUser'] = array_unique(array_diff($_SESSION['closeChatUser'], $currentUserArray));
			$_SESSION['chatUser'] = array_unique(array_merge($_SESSION['chatUser'], $currentUserArray));
			*/
		}
		return $newChatMessage;
	}
}
?>