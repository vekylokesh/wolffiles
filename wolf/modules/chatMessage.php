<?php
class chatMessageModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		$chat = getObject('chat');
		$chat->addChatMessage();
		$smarty->assign('params', $params);
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
		return $moduleContent;
	}
}
?>