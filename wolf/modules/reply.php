<?php
class replyModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		$message = getObject('message');
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$reply = $message->getMessageDetails($params['replyId']);
		$smarty->assign('reply', $reply);
		$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
		return $moduleContent;
	}
}
?>