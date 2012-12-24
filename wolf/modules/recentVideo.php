<?php
class recentVideoModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$message = '';
		$video = getObject('video');
		$recentVideoList = $video->getRecentVideo();
		$smarty->assign('recentVideoList', $recentVideoList);
		$smarty->assign('video', $video);
		$moduleContent = $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
		return $moduleContent;
	}
}
?>