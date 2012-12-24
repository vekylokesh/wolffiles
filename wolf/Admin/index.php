<?php
require_once('includes.php');

$auth = getObject('authorization');
$authorized = $auth ->checkAdminLogin();

if($authorized) {
	setRedirect('dashboard.php');
}

if($auth->checkLogin()) {
	setRedirect(ROOT_HTTP_PATH.'/index.php');
}

if($_REQUEST['login']){
	$loginSuccess = $auth->login($params['userName'], $params['userPassword']);
	
	if($loginSuccess){
		if($auth->checkAdminLogin()){
			setRedirect('dashboard.php');
		} else {
			setMessage('You are not authorised to access admin panel');
			setRedirect(ROOT_HTTP_PATH.'/index.php');
		}
	} else {
		setMessage('Invalid User Name / Password');
		setRedirect('index.php');
	}
}
$smarty->assign('loginSuccess', $loginSuccess);

$smarty->display('index.tpl');
?>