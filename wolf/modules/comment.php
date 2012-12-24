<?php
class commentModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$comment = getObject('comment');
		$videoId = $params['id'] ? $params['id'] : $params['videoId'];
		$comments = $comment->getCommentList($videoId);
		$smarty->assign('comments', $comments);
		$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
		return $moduleContent;
	}
}
?>