<?php
require_once('includes.php');

$auth = getObject('authorization');
$authorized = $auth ->checkAdminLogin();


if(!$authorized){
	setRedirect('index.php');
}

if($params['submit']){
	
	//Check the form is submitted from valid url
	if(!strstr($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])){
		setMessage('It is a spam request');
		setRedirect('index.php');
	} else {
		$job = getObject('jobs');
		$authorized = $job ->addNewJobs($_SESSION['userId']);
		$message = 'Your job Has Been added.';
		echo array2json(array('message' => $message, 'success' => true));
		exit;
	}
}


$smarty->display('addJobs.tpl');
?>