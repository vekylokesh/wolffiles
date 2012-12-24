<?php
class jobs extends table
{
	public $params;
	function __construct($db, $params = array())
	{
		parent::__construct($db, 'jobs');
		$this->params = $params;
	}


	/*function Add user Image*/
		function addNewJobs($userId)
		{
				$params = $this->params;
					$rslt['jb_title'] = $params["jobTitle"];
					$rslt['jb_description'] = $params['jobDescription'];
					$rslt['jb_Specialization'] = $params['specialization'];
					$rslt['jb_subSpeacialization'] = $params['subSpecialization'];
					$rslt['jb_location'] = $params['location'];
					$rslt['jb_salary'] = $params['salary'];
					$rslt['createdBy'] = $userId;
					$rslt['createdOn']= DB_DATE;
					$rslt['modifiedBy'] = $userId;
					$rslt['modifiedOn']= DB_DATE;
				//Insert the record into table
			    $id = $this->insertRecord($rslt);
				return true;
		}
				
		function getLatestJobList($start=0, $limit=5)
		{
			
			$qry = 'SELECT  *  FROM ' .$this-> table . ' WHERE is_deleted = 0  AND  jb_status = 1 ORDER BY createdOn DESC ';
			$qry = $this->db->prepareQuery($qry);
			
			if($limit){
				$qry .= " LIMIT $start, $limit";
			}
			$rslt = $this->db->getResultSet($qry);
			return $rslt;
		}

}

?>