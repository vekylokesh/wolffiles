<?php
require_once('includes.php');


$auth = getObject('authorization');
$authorized = $auth ->checkAdminLogin();

$job = getObject('jobs');
$latestjobs = $job ->getLatestJobList();

$smarty->assign('latestjobs', $latestjobs);
$smarty->display('dashboard.tpl');
?>