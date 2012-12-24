<?php
class photoCommentModule {
	function display($db = '', $params = array())
	{
		global $smarty;
		$tplName = str_replace('.php', '.tpl', basename(__FILE__));
		$photoComment = getObject('photoComment');
		$photoId = $params['id'] ? $params['id'] : $params['photoId'];
		$comments =$photoComment->getPhotoCommentList($photoId);
		$smarty->assign('comments', $comments);
		$photoModuleContent =  $smarty->fetch(TEMPLATE_PATH.'/module/mod_'.$tplName);
		return $photoModuleContent;
		
	}
	
}
?>