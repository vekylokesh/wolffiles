<?php
class authorization extends table
{
	public $db;
	public $userId;
	public $sessionId;
	function __construct($db)
	{
		parent::__construct($db, 'user_session');
	}
	function login($userName, $userPassword, $remember = false)
	{
		if(trim($userName) == '' && trim($userPassword) == '') 
			return false;
		$password = md5($userPassword);
		$loggedIn = $this->getUserInfo($userName, md5($userPassword));
		
		if ($loggedIn) {
			if($remember){
				setcookie('cUserName', $userName, time()+ (7*24*60*60), '/');
				setcookie('cUserPassword', $password, time()+ (7*24*60*60), '/');
			} else {
				setcookie('cUserName', "", time() - 3600, '/');
				setcookie('cUserPassword', "", time() - 3600, '/');
			}
			return true;
		}
		return false;
	}
	function logout($isDelete = false)
	{
		$record['session_key'] = $_SESSION['userSessionId'];
		$record['modified_on'] = DB_DATE;
		$record['session_login_status'] = STATUS_LOGGED_OUT;
		$this->updateRecord($record, 'session_key');
		$this->resetSession();
		if($isDelete){
		   setMessage('Your account is deleted');
		   setRedirect('index.php');  
		} else {
		   setMessage('You are logged out successfully');
		   setRedirect('index.php');
		}
		return true;
	}
	function resetSession()
	{
		//Reset the user sessions
		unset($_SESSION['userId']);
		unset($_SESSION['userEmail']);
		unset($_SESSION['userName']);
		unset($_SESSION['userType']);
		unset($_SESSION['userSessionId']);
		unset($_SESSION['search']);
		unset($_SESSION['srchName']);
		unset($_SESSION['closeChatUser']);
		unset($_SESSION['chatUser']);
		//Reset the cookies
		setcookie('cUserName', "", time() - 3600, '/');
		setcookie('cUserPassword', "", time() - 3600, '/');
	}
	/* Check Site Administrator Login */
	function checkAdminLogin()
	{
		$loggedIn = $this->checkLogin();
		if($loggedIn) {
			return $_SESSION['userType'];
		}
		return false;
	}
	/* Check user login for public site */
	function checkLogin($fromWebService = false)
	{
		global $fileName;
		$loggedIn = true;
		if(!isset($_SESSION['userId'])){
			if(isset($_COOKIE['cUserName'])){
				return ($this->loginUsingCookie());
			}
		} else {
			// Update the access time
			$qry = "UPDATE user_session SET session_login_status = ".STATUS_LOGGED_TIME_OUT .
					" WHERE TIME_TO_SEC(TIMEDIFF( '".DB_DATE."', modified_on )) > ". (DFLT_LOGIN_TIME * 60).
					" AND session_login_status = ". STATUS_LOGGED_IN;
			$rslt = $this->db->query($qry);
			
			/* Check the user is currently logged in */
			$qry = "SELECT session_user_id, modified_on, session_login_status FROM user_session 
					WHERE session_user_id = {$_SESSION['userId']} 
				AND session_key = '{$_SESSION['userSessionId']}'";
			$rslt = $this->db->getSingleRow($qry);
			
			if($rslt && $rslt['session_login_status'] == STATUS_LOGGED_IN) {
				$record['session_key'] = $_SESSION['userSessionId'];
				$record['modified_on'] = DB_DATE;
				$this->updateRecord($record, 'session_key');
				return true;
			} else {
				$this->resetSession();
				if($rslt['session_login_status'] == STATUS_LOGGED_TIME_OUT){
					setErrorMessage('sessionOutError', 'Session Time out please login again');
				} else {
					setErrorMessage('sessionOutError', 'You are logged in another system');
				}
				$loggedIn = false;
			}
		}
		if($fromWebService) {
			return false;
		}
		
		return false;
	}
	
	function loginUsingCookie()
	{
		$loggedIn = $this->getUserInfo($_COOKIE['cUserName'], $_COOKIE['cUserPassword']);
		return $loggedIn;
	}
	function getUserInfo($userName, $password, $fromWebService = false)
	{
		$userName = mysql_real_escape_string($userName);
		$qry = "SELECT user_email, user_id, user_name, user_type FROM user WHERE user_email='{$userName}' AND user_password = '{$password}' AND is_deleted = 0";
		$rslt = $this->db->getSingleRow($qry);
		if ($rslt) {
			//Set the user user_name and id in the session
			return ($this->createSession($rslt));
		} else if ($fromWebService){
			return 0;
		} 
		return false;
	}
	function getUserChatStatus()
	{
		$qry = 'SELECT user_chat_status FROM user WHERE user_id = %d';
		$qry = $this->db->prepareQuery($qry, $this->params['userId']);
		$result = $this->db->getSingleRow($qry);
		return $result['user_chat_status'];
	}
	
	
	function loginUsingId($userId)
	 {
	  $loggedIn = $this->getUserInfoById($userId);
		 if($loggedIn)
		   return true;
		 else 
		   return false;
	 }
	 
	 function getUserInfoById($userId)
	 {
		  $qry = "SELECT user_email, user_id, user_fb_id, user_name FROM user WHERE  user_id = $userId AND is_deleted = 0";
		  $rslt = $this->db->getSingleRow($qry);
		  if($rslt) {
			  $_SESSION['userFbId'] = $rslt['user_fb_id'];
			  return ($this->createSession($rslt));
		  }
		  return false;
	 }
	 
	 
	 function createSession($rslt)
	 {
		  //Cancel the existing logins if any by indicating that the user logged in another system.
		  $logoutQry = "UPDATE {$this->table} SET modified_on='".DB_DATE."', 
		   session_login_status = ".STATUS_LOGGED_IN_ANOTHER_SYSTEM.
		   " WHERE session_user_id = {$rslt['user_id']} AND session_login_status = ".STATUS_LOGGED_IN;
		  $logoutRslt = $this->db->query($logoutQry);
		  //Set the user user_name and id in the session
		 $this->userId = $_SESSION['userId']= $rslt['user_id'];
			$_SESSION['userEmail'] = $rslt['user_email'];
			$_SESSION['userName'] = $rslt['user_name'];
			$this->sessionId = $_SESSION['userSessionId'] =  $this->generateRandID();//$_COOKIE['PHPSESSID'];
			$_SESSION['loginTime'] = DB_DATE;
			$_SESSION['userType'] = $rslt['user_type'];
			$this->insertSession();
			return ($this->userId);
	 }
	 
	/* Get the status of each user */
	function getOnlineUserStatus($userId=0)
	{
		if(!$userId) $userId = $_SESSION['userId'];
		$qry = "SELECT user_id, IF(session_login_status, user_chat_status, 0) AS online
				FROM user 
				INNER JOIN friend ON friend.is_deleted = 0 AND (frnd_user_id=$userId OR frnd_member_id=$userId) AND 			
				(frnd_user_id=user_id OR frnd_member_id=user_id) AND user_id != $userId
				LEFT JOIN user_session ON user_id = session_user_id AND session_login_status = ".STATUS_LOGGED_IN."
				WHERE user.is_deleted = 0";
		$rslt = $this->db->getResultSet($qry);
		return $rslt;
	}
	/*Get online users */
	function getOnlineUsers($userId = 0, $showOnline = false)
	{
		if($userId){
			$friendJoin = "INNER JOIN friend ON friend.is_deleted = 0 AND (frnd_user_id=$userId OR frnd_member_id=$userId) AND (frnd_user_id=user_id OR frnd_member_id=user_id) AND user_id != $userId";
		}
		if($showOnline){
			$joinType = 'INNER';
		} else {
			$joinType = 'LEFT';
		}
		$qry = "SELECT user_id, user_name, user_image,
				IF(session_login_status, user_chat_status, 0) AS online
				FROM user 
				{$friendJoin}
				{$joinType} JOIN user_session ON user_id = session_user_id AND session_login_status = ".STATUS_LOGGED_IN."
				WHERE user.is_deleted = 0";
		//$qry = $this->db->prepareQuery($qry, $userId);
		$rslt = $this->db->getResultSet($qry);
		return $rslt;
	}
	/*Get user chat status */
	function checkUserOnline($userId)
	{
		$qry = "SELECT session_user_id, modified_on as lastModified, session_login_status FROM user_session WHERE HOUR(TIMEDIFF('".DB_DATE."', user_session.modified_on))<=1 AND session_user_id = {$userId} ORDER BY modified_on DESC LIMIT 0, 1";
		$rslt = $this->db->getSingleRow($qry);
		return $rslt;
	}
	function insertSession()
	{
		$record['session_key'] = $_SESSION['userSessionId'];
		$record['session_user_id'] = $_SESSION['userId'];
		$record['session_login_ip'] = getRealIpAddr();
		$record['created_on'] = DB_DATE;
		$record['modified_on'] = DB_DATE;
		$sessionId = $this->insertRecord($record);
	}
	/*****************************************************************************************
    * generateRandID - Generates a string made up of randomized
    * letters (lower and upper case) and digits and returns
    * the md5 hash of it to be used as a userid.
    ****************************************************************************************/
    function generateRandID()
    {
        return md5($this->generateRandStr(16));
    }

    /****************************************************************************************
    * generateRandStr - Generates a string made up of randomized
    * letters (lower and upper case) and digits, the length
    * is a specified parameter.
    ***************************************************************************************/
    function generateRandStr($length)
    {
        $randstr = "";
        for($i=0; $i<$length; $i++){
            $randnum = mt_rand(0,61);
            if($randnum < 10){
                $randstr .= chr($randnum+48);
            }else if($randnum < 36){
                $randstr .= chr($randnum+55);
            }else{
                $randstr .= chr($randnum+61);
            }
        }
        return $randstr;
    }
}
?>