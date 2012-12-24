<?php
class user extends table
{
	public $params;
	function __construct($db, $params = array())
	{
		parent::__construct($db, 'user');
		$this->params = $params;
	}
	function checkUserEmailExists($userEmail)
	{
		$qry = sprintf('SELECT user_id, user_first_name, user_last_name, user_email FROM user WHERE LOWER(user_email) = \'%s\'', mysql_real_escape_string(strtolower($userEmail)));
		$rslt = $this->db->getSingleRow($qry);
		if($rslt) {
			return $rslt;
		} else {
			return false;
		}
	}
	function addUser($params=array())
	{
		clearErrorMessage();
		$error = false;
		$params = ($params) ? $params : $this->params;
		/* Check for the given fields are entered */
		if(checkEmpty($params['userFullName'])){
			setErrorMessage('userFullName', 'Missing: User Name');
			$error = true;
		}
		if(checkEmpty($params['userFirstName'])){
			setErrorMessage('userFirstName', 'Missing: First Name');
			$error = true;
		} 
		if(checkEmpty($params['userEmail'])) { //Check email is empty
			setErrorMessage('userEmail', 'Missing: Email');
			$error = true;
		} else if( !validateEmail($params['userEmail'])){ //Check email is valid
			setErrorMessage('validEmail', 'Enter Valid Email');
			$error = true;
		} else if ($this->checkUserEmailExists($params['userEmail'])){ //Check the email exist in database
			setErrorMessage('emailExists', 'Email already exists');
			$error = true;
		}
		if(checkEmpty($params['userDOB'])) { //Check Date Of Birth is empty
			setErrorMessage('Date Of Birth', 'Missing: Date Of Birth');
			$error = true;
		}
		list($month, $day, $year) = explode('/', $params['userDOB']);
		if(!$dateErr && !checkdate($month, $day, $year)) {
			setErrorMessage('DOB', 'Enter Valid Date');
			$error = true;
		} else {
			$dobDate = mktime(0, 0, 0, $month, $day, $year);
			$rslt['user_dob'] = date('Y-m-d', $dobDate);
		}
		if( checkEmpty($params['userNewPassword'])){
			setErrorMessage('userNewPassword', 'Missing: Password');
			$error = true;
		}
		if($params['userNewPassword'] !== $params['userConfirmPassword']){
			setErrorMessage('passwordMismatch', 'Password and Confirm Password are not matching');
			$error = true;
		}
		if( checkEmpty($params['userGender'])){
			setErrorMessage('userGender', 'Missing: Gender');
			$error = true;
		}
		
		if(!$error){
			$rslt['user_name'] = $params['userFullName'];
			$rslt['user_first_name'] = $params['userFirstName'];
			$rslt['user_last_name'] = $params['userLastName'];
			$rslt['user_email'] = $params['userEmail'];
			$rslt['user_password'] = md5($params['userNewPassword']);
			$rslt['user_gender'] = $params['userGender'];
			$rslt['user_zip'] = $params['userZip'];
			$rslt['user_about_me'] = $params['userAboutMe'];
			$rslt['user_state'] = $params['userState'];
			$rslt['created_on'] = DB_DATE;
			$rslt['modified_on'] = DB_DATE;
			$rslt['is_deleted'] = 2;
			$authorization = getObject('authorization');
			$randId = $authorization->generateRandStr(16);
			$rslt['user_key']= $randId;
			//Insert the record into table
			$userId = $this->insertRecord($rslt);
			//Update the play list
			$userPlay = getObject('userPlay');
			$params['userId'] = $userId;
			$userPlay->addUserPlayList($params);
			//Update User Image
			$imgUpload = $this->uploadUserImage($userId);
			//Send out registeration mail
			global $emailTemplateArray;
			$mailInfo['firstName'] = $rslt['user_first_name'];
			$mailInfo['lastName'] = $rslt['user_last_name'];
			$mailInfo['userId'] = base64_encode($userId);
			$mailInfo['activationKey'] = md5($randId);
			$mailSubject = $emailTemplateArray['register']['subject'];
			$mailMessage = $emailTemplateArray['register']['message'];
			$subject = replaceContent($mailInfo, $mailSubject);
			$message = replaceContent($mailInfo, $mailMessage);
			
			
			sendMail(NOTIFICATION_EMAIL, $rslt['user_email'], $subject, $message);
			return $userId;
		}
		return false;
	}
	
	function activateUser($userId, $key)
	{
		$qry = 'SELECT user_id, user_key FROM user WHERE user_id = %d';
		$qry = $this->db->prepareQuery($qry, $userId);
		$rslt = $this->db->getSingleRow($qry);
		if(!$rslt){
			return false;
		}
		if($key == md5($rslt['user_key'])){
			$record['user_id'] = $userId;
			$record['is_deleted'] = 0;
			$rslt['modified_on'] = DB_DATE;
			$this->updateRecord($record, 'user_id');
			return true;
		}
		return false;
	}
	function updateUserInfo($userId)
	{
		$params = $this->params;
		$rslt['user_id'] = $userId;
		$rslt['user_name'] = $params['userFullName'];
		$rslt['user_first_name'] = $params['userFirstName'];
		$rslt['user_last_name'] = $params['userLastName'];
		$rslt['user_gender'] = $params['userGender'];
		$rslt['user_state'] = $params['userState'];
		$rslt['user_about_me'] = $params['userAboutMe'];
		$rslt['user_zip'] = $params['userZip'];

		list($month, $day, $year) = explode('/', $params['userDOB']);
		$dobDate = mktime(0, 0, 0, $month, $day, $year);
		$rslt['user_dob'] = date('Y-m-d', $dobDate);
		$rslt['modified_on'] = DB_DATE;
		//Insert the record into table
		$recUpdate = $this->updateRecord($rslt, 'user_id');
		/* Update the user play list */
		$userPlay = getObject('userPlay');
		$params['userId'] = $userId;
		$userPlay->addUserPlayList($params);
		/* Upload the image */
		/*$imgUpload = $this->uploadUserImage($userId);*/
		
		return $userId;
	}
	
	function getUserInfo($userId)
	{
		$qry = "SELECT * FROM user WHERE user_id='{$userId}'";
		$rslt = $this->db->getSingleRow($qry);
		return $rslt;
	}
	function getUserBasicInfo($userId)
	{
		$qry = "SELECT user_id, user_gender, user_image, user_email, user_state, user_name FROM user WHERE user_id='{$userId}' and is_deleted = 0";
		$rslt = $this->db->getSingleRow($qry);
		if($rslt){
			$userPlay = getObject('userPlay');
			$playText = $userPlay->getUserPlayListAsText($rslt['user_id']);
			$rslt['play_list'] = $playText['playItems'];
		}
		return $rslt;
	}
	
	/* function to delete user profile */
	function updateIsDelete($userId)
	{
		$qry = "UPDATE user SET is_deleted='1' WHERE user_id= %d";
		$qry = $this->db->prepareQuery($qry, $userId);
		$rslt = $this->db->query($qry);
		return $rslt;	
	}
	
	/* Update the profile image */
	function udpateUserImage($userId, $userImage)
	{
		$qry = "SELECT user_image FROM user WHERE user_id='{$userId}'";
		$rslt = $this->db->getSingleRow($qry);
		//Update the new Image
		$record['user_image'] = $userImage;
		$record['user_id'] = $userId;
		$record['modified_on'] = DB_DATE;
		$updateRecord = $this->updateRecord($record, 'user_id');
		
		
		return $updateRecord;
	}
	/* Function to update the password */
	function updatePassword($userId, $userPassword)
	{
		$qry = "UPDATE user SET user_password = '%s' WHERE user_id= %d";
		$qry = $this->db->prepareQuery($qry, md5($userPassword), $userId);
		$rslt = $this->db->query($qry);
		return $rslt;
	}
	/* Function to check given password is valid for given user */
	function checkPassword($userId, $userPassword)
	{
		$qry = "SELECT user_id FROM user WHERE user_password = '%s' AND user_id= %d";
		$qry = $this->db->prepareQuery($qry, md5($userPassword), $userId);
		$rslt = $this->db->getSingleRow($qry);
		if($rslt) {
			return true;
		} else {
			return false;
		}
	}
	//Get the user id by given email address.
	function getUserByEmailId($emailId)
	{
		$qry = "SELECT user_id FROM user WHERE LOWER(user_email)='%s' AND is_deleted=0";
		$emailId = trim(strtolower($emailId));
		$qry = $this->db->prepareQuery($qry, $emailId);
		$rslt = $this->db->getSingleRow($qry);
		if($rslt){
			return $rslt['user_id'];
		} else {
			return false;
		}
	}
	/* Delete the user account */
	function deleteUserAccount($userId = 0)
	{
		if(!$userId) $userId = $_SESSION['userId'];
		if(!$userId){
			return false;
		}
		$record['user_id'] = $userId;
		$record['modified_on'] = DB_DATE;
		$record['is_deleted'] = 1;
		$updateRecord = $this->updateRecord($record, 'user_id');
		return true;
	}
	
	
	
	/*Function to change user Chat status*/
	function changeUserChatStatus($newStatus)
	{
		//Update the status
		$qry = 'UPDATE user SET user_chat_status = %d WHERE user_id = %d';
		$qry = $this->db->prepareQuery($qry, $newStatus, $this->params['userId']);
		$this->db->query($qry);
		//Return the status
		$qry = 'SELECT user_chat_status FROM user WHERE user_id = %d';
		$qry = $this->db->prepareQuery($qry, $this->params['userId']);
		$result = $this->db->getSingleRow($qry);
		return $result['user_chat_status'];
	}
	function searchUserByNameOrEmail($params=array(),$start=0, $limit=0)
	{
		$params = $params ? $params : $this->params;
		$loginUserId = $params['userId'] ? $params['userId'] : 0;
		
		$where = array();
		if($loginUserId) {
			$inviteJoin = " LEFT JOIN (SELECT 1 as invite_sent, inv_inviter,  inv_invitee FROM invitation WHERE is_deleted = 0 AND 
						   (inv_invitee = {$loginUserId} OR inv_inviter = {$loginUserId}) AND inv_status != 2) AS invitation 
						   ON ((user_id=inv_inviter OR user_id = inv_invitee) AND user_id != {$loginUserId})";
			$inviteSent = 'IFNULL(invite_sent, 0) as invite_sent,';
		}
					   
		$qry = 'SELECT user_id,user_state,user_name, user_image,'.$inviteSent.'				
				user_gender, user_state FROM user '. $inviteJoin .'WHERE user.is_deleted = 0';
		
		if($params['srchUserEmail']){
			$userEmail = "  user_email LIKE '%%%s%%'";
			$userEmail = $this->db->prepareQuery($userEmail, $params['srchUserEmail']);
		}
		
		if($params['srchUserName']){
			//$whereUser = " AND (user_first_name LIKE '%%%s%%' OR user_last_name LIKE '%%%s%%' OR user_name LIKE '%%%s%%' ";
			$whereUser = " AND (user_name LIKE '%%%s%%' ";
			if($userEmail){
				$whereUser .= "OR {$userEmail}";
			}
			$whereUser .= ')';
		}
		if($whereUser){
			$qry .= $whereUser;
			$args = preg_match_all('/%s/', $qry, $matches);
			if($args > 0){
				$argsArray = array_fill(1, $args, $params['srchUserName']);
			}
			$qry = $this->db->prepareQuery($qry, $argsArray);
		} elseif($userEmail) {
			$qry .= ' AND '. $userEmail;
		}
		
		if($limit){
			$qry .= " LIMIT $start, $limit";
		}
		$rslt = $this->db->getResultSet($qry);
		if($rslt){
			if($limit)
				$rslt[0]['totalRows'] = $this->db->getTotalRows($qry);
			$userPlay = getObject('userPlay');
			foreach($rslt as $key => $value)
			{
				$playText = $userPlay->getUserPlayListAsText($value['user_id']);
				$rslt[$key]['play_list'] = $playText['playItems'];
			}
		}
		return $rslt;
	}
	
	/* Function to search with given details */
	function searchUserDetail($params=array(), $start=0, $limit=0)
	{
		
		$params = $params ? $params : $this->params;
		$params = array_map(array($this->db, 'sqlSafe'),$params);
		$where = array();
		$join = '';
		$firstName = $params['userFirstNameSrch'];
		
		$loginUserId = $params['userId'] ? $params['userId'] : 0;
		
		if($firstName){
			$where[] = "(user_first_name LIKE '%{$firstName}%')";
		}
		$lastName = $params['userLastNameSrch'];
		if($lastName){
			$where[] = "(user_last_name LIKE '%{$lastName}%')";
		}
		$gender = $params['userGenderSrch'];
		if($gender) {
			$where[] = "(user_gender = '{$gender}')";
		}
		$minAge = (int) $params['minAgeSrch'];
		$maxAge = (int) $params['maxAgeSrch'];
		if($minAge && $maxAge){
			$where[] = "(YEAR('".DB_DATE_ONLY."') - YEAR (user_dob) BETWEEN {$minAge} AND {$maxAge})";
		} elseif($minAge) {
			$where[] = "(YEAR('".DB_DATE_ONLY."') - YEAR (user_dob) >= {$minAge})";
		} elseif($maxAge) {
			$where[] = "(YEAR('".DB_DATE_ONLY."') - YEAR (user_dob) <= {$maxAge})";
		}
		$state = $params['userStateSrch'];
		if($state){
			$where[] = "(user_state = '{$state}')";
		}
		$zip = $params['userZipSrch'];
		if($zip){
			$where[] = "user_zip LIKE '%%{$zip}%%'";
		}
		$playListArr = $params['playListSrch'];
		if($playListArr){
			$playList = implode(',', $playListArr);
			$playJoin = "INNER JOIN (SELECT DISTINCT play_user_id FROM user_play WHERE play_cat_id IN ($playList)) 
					as play_cat ON play_user_id = user_id";
		}
		
		//Check Invitation send status
		if($loginUserId) {
			$inviteJoin = " LEFT JOIN (SELECT 1 as invite_sent, inv_inviter,  inv_invitee FROM invitation WHERE is_deleted = 0 AND 
						   (inv_invitee = {$loginUserId} OR inv_inviter = {$loginUserId}) AND inv_status != 2) AS invitation 
						   ON ((user_id=inv_inviter OR user_id = inv_invitee) AND user_id != {$loginUserId})";
			$inviteSent = 'IFNULL(invite_sent, 0) as invite_sent,';
		}
		$qry = 'SELECT user_id, user_name, user_state, invite_sent, user_image, user_gender, 
				user_state, user_zip, YEAR("'.DB_DATE_ONLY.'") - YEAR (user_dob) AS user_age, '.$inviteSent.' user_dob
				FROM user '. $playJoin .$inviteJoin.' WHERE user.is_deleted = 0';
		if($where) {
			$whereCond = implode (' AND ', $where);
			$qry .= ' AND ('.$whereCond .')';
		}
		if($limit){
			$qry .= " LIMIT $start, $limit";
		}
		$rslt = $this->db->getResultSet($qry);
		if($rslt){
			if($limit)
				$rslt[0]['totalRows'] = $this->db->getTotalRows($qry);
			$userPlay = getObject('userPlay');
			foreach($rslt as $key => $value)
			{
				$playText = $userPlay->getUserPlayListAsText($value['user_id']);
				$rslt[$key]['play_list'] = $playText['playItems'];
			}
		}
		return $rslt;
	}
	/* Function upload user file */
	function uploadUserImage($userId = 0)
	{
		$error = false;
		$uploaddir = USER_IMAGE_PATH.'/';
		if(isset($_FILES['userImage']) && $_FILES['userImage']['tmp_name']) {
			$file_size = @filesize($_FILES['userImage']["tmp_name"]);
			//$max_file_size_in_bytes = 1024 * 1024; //1 MB Size
			//if (!$file_size || $file_size > $max_file_size_in_bytes)
			//Check the file size
			if ($_FILES['userImage']["error"] > 0) {
				setErrorMessage('userImage', fileUploadErrorMessage($_FILES['userImage']["error"]));
				$error = true;
			}
			$filename = time().'_'.safeFile(basename($_FILES['userImage']['name']));
			$file = $uploaddir . $filename;
			//Get the image size
			list($imgWidth, $imgHeight) = getimagesize($_FILES['userImage']['tmp_name']);
			if (!$error && ($imgWidth == 0 || $imgHeight == 0)) {
				setErrorMessage('userImage', 'Invalid Image');
				$error = true;
			}
			if (!$error && move_uploaded_file($_FILES['userImage']['tmp_name'], $file)) {
			    //return success status, image http path and new file name<br />
				$userId = ($userId) ? $userId : $_SESSION['userId'];
				$uploadImg = $this->udpateUserImage($userId, $filename);
				$userPhoto = getObject('userPhoto');
				$rslt = $userPhoto->insertRegisterData($userId, $filename, $this->params['userFullName']);
			} else {
				//setErrorMessage('userImage', 'No Permission to upload the image');
				//$error = true;
			}
		}
		
		 return (!$error);
		
	}
}
?>