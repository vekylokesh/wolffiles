<?php
require_once('includes.php');

$authorization = getObject('authorization');
$authorization->logout();

setRedirect(ROOT_HTTP_PATH.'/index.php');
?>