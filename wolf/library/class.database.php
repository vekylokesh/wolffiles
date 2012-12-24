<?php
class database
{
	public $_db;
	public $_total_rows;
	public $_affected_rows;
	public $host;
	public $user;
	public $pass;
	public $_dbname;
	function __construct($host, $user, $pass, $name){
		$this->user = $user;
		$this->pass = $pass;
		$this->host = $host;
		$this->_dbname = $name;
		$this->connect();
	}

	function connect()
  	{
		$this->_db = mysql_connect($this->host, $this->user, $this->pass);
		if(!$this->_db) {
			trigger_error('Can\'t Connect to Mysql Database Server: '. $this->host .' With User Name: '. $this->user, E_USER_ERROR);
		}
		$selDb = mysql_select_db($this->_dbname, $this->_db);
		if(!$selDb) {
			trigger_error('Can\'t Select Database: '. $this->_dbname . ' With Host '.$this->host .' With User Name: '. $this->user, E_USER_ERROR);
		}
  	}
	
	function query($qry)
	{
		if(!$this->_db) {
			$this->connect();
		}
		$result = @mysql_query($qry, $this->_db);
		if(!$result) {
			trigger_error('Error in the Query: <b>'. $qry.'</b> with <br />Error: '. mysql_error() , E_USER_ERROR);
		}		
		$this->_affected_rows = @mysql_affected_rows($this->_db);
		$this->_total_rows = @mysql_num_rows($result);
		return $result;
	}
	
	function getResultSet($queryString, $returnType = MYSQL_ASSOC)
	{
		$result = $this->query($queryString);	
		$rsltSet = array();
		$xx = 0 ;
		while ( $row = mysql_fetch_array($result, $returnType) ) {
			$rsltSet[$xx] = $row;
			$xx++ ;
		}
		mysql_free_result($result) or die('Error');
		array_walk_recursive($rsltSet, array('database','avoidSlashes'));
		return $rsltSet;
	}
	
	/* Get table fields */
	function getTableFields($table)
	{
		$qry = 'SHOW FIELDS FROM '.$table;
		$rslt = $this->getResultSet($qry);
		$fields = array();
		if(!$rslt) return false;
		//$expTypeSize = '/([a-z]+)\((\d+)\)/';
		$expTypeSize = '/([a-z]+)(\((\d*\)))?/';
		foreach($rslt as $row){
			//$fields[$row['COLUMN_NAME']] = array('dataType'=>$row['TYPE_NAME'], 'length'=>$row['DATA_TYPE']);
			$matches = array();
			preg_match($expTypeSize, $row['Type'], $matches);
			$fields[$row['Field']] = array('dataType'=>$matches[1], 'length'=>(int) $matches[3]);
		}
		return $fields;
	}
	
	function avoidSlashes(&$item, $key)
	{
			$item = stripslashes($item);
	}
	function getTotalRows($qry)
	{
		//Replace select clause with count function
		$qry = substr($qry, stripos($qry, 'FROM '));
		$qry = 'SELECT COUNT(1) as total '. $qry;
		//Remove the order by and Limit clauses
		$qry = preg_replace('/ORDER BY (.)*/', '', $qry);
		$qry = preg_replace('/LIMIT (.)*/', '', $qry);
		$result = $this->getSingleRow($qry);
      	return $result['total'];
	}
	
	function getSingleRow($queryString, $returnType = MYSQL_ASSOC)
  	{
		$result = $this->query($queryString);
		$row = mysql_fetch_array($result, $returnType);
   		mysql_free_result($result) or die('Error');
		if($row){
			array_walk_recursive($row, array('database','avoidSlashes'));
		}
   		return $row;
  	}
	
	function insertDataId($queryString = '')
 	{
		if($queryString) {
			$result = $this->query($queryString);
		}
 		$rslt = mysql_insert_id($this->_db);
  		return $rslt;
	}
	
	function getAffectedRows()
	{
		return $this->_affected_rows;
	}
	
	function get_total_rows()
	{
		return $this->_total_rows;
	}
	
	function prepareQuery()
	{
		if(!$this->_db) {
			$this->connect();
		}
		$args = func_get_args();
		
		//Arguments are passed from another function
		if(is_array($args[0])) {
			$args = $args[0];
		}
		if( count($args) == 0 ) {
			trigger_error('Query Must not empty to execute', E_USER_WARNING);
		}
		$qry = $args[0];
		//Shift the queue
		array_shift($args);
		//If query arguments passed an array then make the array to sql safe.
		if(is_array($args[0])){
			$args = $args[0];
		}
		//Make the arguments to be sql safe.
		$args = array_map(array($this, 'sqlSafe'), $args);
		
		array_unshift($args, $qry);
		//Make the Query using sprintf function.
		$qry = call_user_func_array('sprintf', $args);
		return $qry;
	}
	function sqlSafe($value, $quote="") 
	{
		if(is_array($value)) {
			$value = array_map(array($this, 'sqlSafe'), $value);
			return $value;
		}
		//$value = str_replace(array("\'","'"),"&#39;",$value);
		// Stripslashes
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		// Quote value
		if(version_compare(phpversion(),"4.3.0")=="-1") {
			$value = mysql_escape_string($value);
		} else {
			$value = mysql_real_escape_string($value, $this->_db);
		}
		$value = $quote . $value . $quote;
		return $value;
	}
	
	/* Make the fields to safe*/
	function fieldQuote($value)
	{
		return ('`'.$value.'`');
	}
	
	function __destruct()
	{
		if($this->_db)
			mysql_close($this->_db);
		$this->_db = null;		
	}
}  //end of class database
?>