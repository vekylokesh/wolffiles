<?php
require_once('../includes/includes.php');

define('ADMIN_PATH', realpath(dirname(__FILE__)));

require_once(SMARTY_PATH.'/libs/Smarty.class.php');
$smarty =  new Smarty();
$smarty->template_dir = ADMIN_PATH.'/templates/';
$smarty->compile_dir =  ADMIN_PATH.'/templates_c/';


//Check authorization for every page not for index page
if($fileName != 'index.php'){
	$auth = getObject('authorization');
	$authorized = $auth ->checkAdminLogin();
	if(!$authorized) {
	setRedirect('index.php');
	}
}

//Assign the UI Message
$messages = $module->loadModules(array('uiMessage'));

$smarty->assign('messages', $messages);
?>