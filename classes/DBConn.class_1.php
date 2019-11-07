<?php
@session_start();
@error_reporting(E_ALL);
@ini_set('display_errors', TRUE);
@ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Africa/Nairobi');
@ini_set('xdebug.max_nesting_level', 200);

@define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

class DBConn{
	var $connection;
	var $DBdate;
	
	public function __construct() {
		$DB_SERVER = 'localhost';
        $DB_USERNAME = 'rot';
        $DB_PASSWORD = '';
        $DB_DATABASE = 'cash_cow';
		$this -> DBdate = date('Y-m-d H:i:s',strtotime('now'));
		@$connection = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD,$DB_DATABASE) or
        die('Oops connection error -> ' . mysqli_error());
		$this -> connection = $connection;
      }
	
	public function clean($str){
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return @mysqli_real_escape_string($this->connection,$str);
	}
	
	function Log($action, $user_ID){
		$ip = $_SERVER['REMOTE_ADDR'];
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		$log = $this->lazyInsert("audit_trail", array("AT_ACTION", "USER_ID", "AT_IP","AT_USERAGENT"),array($action,$user_ID,$ip,$useragent),"");
		return $log;
	}
	
	function lazyInsert($table, $column, $value){
		$table = $this -> clean($table);
		$out = array();
		$i = 0;
		if(count($column) != count($value)){
			 return false;
		}else{
			$strINS = "INSERT INTO ".strtolower($table);  
			$strINS .="(".strtoupper(implode(',',$column)).") "; 
			$strINS .="VALUES ";  
		 	for($i; $i < count($value);$i++) {
            	array_push($out, "'$value[$i]'");
			}
		$strINS .="(".(implode(',',$out)).")";
		$objParse = mysqli_query($this->connection,$strINS);
		$id = mysqli_insert_id();   
		if($objParse){  
			return $id;
		}else{  
			return FALSE; 
		} 
		}
	}
	
	function complexSelect($tables, $columns, $conditions){
		$strSEL = "SELECT ";
		//$strSEL .=strtoupper(implode(',',$columns));
		$strSEL .= implode(',',$columns);
		$strSEL .=" FROM ";
		$strSEL .=strtolower(implode(',',$tables));
		//$strSEL .=" ".strtoupper($conditions);
		$strSEL .=" ".$conditions;
		//echo "</br>".$strSEL."</br></br>";
		$objSC = mysqli_query($this->connection,$strSEL); 
		if($objSC){  
			$data = array();
			while($det = mysqli_fetch_assoc($objSC)){
				$data[] = $det;
			}		
			return $data;
		}else{  
			return false;
		} 
	}
	
	function lazySelect($start_row, $rows_per_page, $table, $condition){	
		$table = $this->clean($table);
                //echo "table name ".$table;
                //exit;
		if($condition == ''){
			$strSEL = "SELECT * FROM ".$table." ";
		}else{
			$strSEL = "SELECT * FROM ".$table." ".strtoupper($condition)."";
		}
                //echo $strSEL;
		$objSC = mysqli_query($this->connection,$strSEL); 
		if($objSC){  
			$data=array();
			while($det = mysqli_fetch_assoc($objSC)){
				$data[] = $det;
			}				
			return $data;
		}else{  
			return false;
		} 
	}
	
	function lazyUpdate($table, $columns, $values, $uniquecol, $uniqueval){
		$table = $this -> clean(strtolower($table));
		$out = array();
		$i = 0;
		$query = "UPDATE ".$table;
		$query .=" SET ";
		foreach ($columns as $col) {
        	array_push($out, "$col = '$values[$i]'");
	    	$i++;
        }
	    $query .= implode(',',$out);
	    $query .=" WHERE ";
	    $query .="".strtoupper($uniquecol)." = '".$uniqueval."'";
        $stmt = mysqli_query($this->connection,$query);
		if($stmt){
    		return true;
		}else{
			return false;
		}
	}
	
	function lazyUpdate2($table, $columns, $values, $uniquecol, $uniquecol2, $uniqueval, $uniqueval2){
		$table = $this -> clean(strtolower($table));
		$out = array();
		$i = 0;
		$query = "UPDATE ".$table;
		$query .=" SET ";
		foreach ($columns as $col) {
        	array_push($out, "$col = '$values[$i]'");
	    	$i++;
        }
	    $query .= implode(',', $out);
	    $query .=" WHERE ";
	    $query .="".strtoupper($uniquecol)." = '".$uniqueval."' AND ".strtoupper($uniquecol2)." = '".$uniqueval2."'";
        $stmt = mysqli_query($this->connection,$query);
		if($stmt){
    		return true;
		}else{
			return false;
		}
	}
	
	function lazyDelete($table, $column, $value){
		$table = $this -> clean(strtolower($table));
		$query = "DELETE FROM ".$table;
	    $query .=" WHERE ";
	    $query .="".$this -> clean(strtoupper($column))." = '".$value."'";
	    $stmt = mysqli_query($this->connection,$query);
		if($stmt){
    		return true;
		}else{
			return false;
		}
	}
	
	function simpleLazySelect($table, $condition){
                            //echo '<br> table name'.$table;
		$table = $this->clean($table);
                          //  echo '<br>table name'.$table.'<br>';
		$strSEL = "SELECT * FROM ".$table." ".(($condition))."";
                //echo $strSEL;
	    $objSC = mysqli_query($this->connection,$strSEL); 
        if($objSC){  
			$data=array();
			while($det = mysqli_fetch_assoc($objSC)){
				$data[] = $det;
			}			
			return $data;
		}else{  
			return false;
		} 
	}
	
	function countLazySelect($table, $condition){
		 $strSEL  = "SELECT COUNT(*) AS count FROM ".$this -> clean(strtolower($table))." ".$this -> clean(strtoupper($condition))."";
		 $objSC = mysqli_query($this->connection,$strSEL); 
		 if($objSC){
			 $det = mysqli_fetch_assoc($objSC);
             return $det['count'];
		 }
		 else{
			 return false;
		 }
	}
	
	function lazySum($table, $column, $condition){
		//$strSEL  = "SELECT SUM(".$this -> clean(strtoupper($column)).") AS count FROM ".$this -> clean(strtolower($table))." ".$this -> clean(strtoupper($condition))."";
		$strSEL  = "SELECT SUM(".$this -> clean(strtoupper($column)).") AS count FROM ".$this -> clean(strtolower($table))." ".(strtoupper($condition))."";
		$objSC = mysqli_query($this->connection,$strSEL); 
		if($objSC){
			$det = mysqli_fetch_assoc($objSC);
            return $det['count'];
		}else{
			return false;
		}
	}
        function batchInsert($query){
            $objSC = mysqli_query($this->connection,$query); 
            if($objSC){
                return true;
            }else{
                return false;
            }
        }
	function lazyBlank($query){
		//$strSEL  = "SELECT SUM(".$this -> clean(strtoupper($column)).") AS count FROM ".$this -> clean(strtolower($table))." ".$this -> clean(strtoupper($condition))."";
		$strSEL  = $this->clean($query);
		$objSC = mysqli_query($this->connection,$strSEL); 
        if($objSC){  
			$data=array();
			while($det = mysqli_fetch_assoc($objSC)){
				$data[] = $det;
			}
			return $data;
		}else{  
			return false;
		} 
	}
	function complexSum($sumcol, $tables, $condition){
			$strSEL = "SELECT SUM(".$this -> clean(strtoupper($sumcol)).") AS TOTAL FROM ";
			//$strSEL .=strtoupper(implode(',',$tables));
			$strSEL .=implode(',',$tables);
			//$strSEL .=" ".strtoupper($condition);
			$strSEL .=" ".$condition;
			$objSC = mysqli_query($this->connection,$strSEL); 
			if($objSC){  
				$data = array();
				while($det = mysqli_fetch_assoc($objSC)){
					$data[]=$det;
				}		
				//$det = mysqli_fetch_assoc($objSC);
				return $data;
			}else{  
				return false;
			} 
	}

	
	public function __destruct(){
		@mysqli_close($this -> connection);
	}
}
?>