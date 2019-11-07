<?php include_once('DBConn.class.php');
 
 class Procedures extends DBConn{
	 
	 
	 function createProcedures($uid, $name, $type){
		 return $this -> lazyInsert('procedures_table', array('PROC_ID', 'PROC_NAME', 'PROC_TYPE', 'PROC_INS_DATE'),
		 array($uid, $name, $type, $this -> DBdate));
	 }
	 
	
	 
	 
	 
	 function updateProcedures($id, $uid, $name, $type){
		 if($this -> lazyUpdate('procedures_table', array('PROC_NAME', 'PROC_TYPE', 'PROC_INS_DATE'), 
			array($name, $type, $this -> DBdate), 'PROC_ID', $id)){
			return true;
		 }else{
			return false;
		 }
	 }
	
	function deleteProcedures($id){
		 if($this -> lazyUpdate('procedures_table', array('PROC_STATUS'), array(0), 'PROC_ID', $id)){
			 return true;
		 }else{
			 return false;
		 }
	}
    
	
	function getProceduresList(){
		$val = $this -> simpleLazySelect('procedures_list', "where PROC_STATUS = 1");
		return @$val;
	}
        
         function getProcedures_Type($id) {
        $val = $this->simpleLazySelect('procedures_list', "where PROC_ID = '$id' and PROC_STATUS = 1");
        return @$val[0];
    }
	   function getPatient_Procedure($id) {
        $val = $this->simpleLazySelect('procedures_table', "where proc_id = '$id'");
        return @$val[0];
    }
    function getcombineddata($pat_id){
        $val = $this->complexSelect2("procedures_table.PROC_ID,procedures_table.PAT_ID,procedures_list.PROC_NAME,"
                . "procedures_table.PROC_DATE,procedures_table.PROC_PAID,doctors_table.DOC_NAME,", "procedures_table,procedures_list,doctors_table","WHERE procedures_table.PROC_ID = procedures_list.PROC_ID AND procedures_table.PAT_ID = '$pat_id'"
               . "AND procedures_table.PROC_STATUS = 1");
       return $val;
        
    }
        
//    function getcombineddata($pat_id){
//        $val = $this->complexSelect2("procedures_table.PROC_ID,procedures_table.PAT_ID,procedures_list.PROC_NAME,"
//                . "procedures_table.PROC_DATE,procedures_table.PROC_PAID,doctors_table.DOC_NAME,"
//                . 
//            "procedures_table,procedures_list,doctors_table",
//            "WHERE procedures_table.PROC_ID = procedures_list.PROC_ID AND procedures_table.PAT_ID = '$pat_id'"
//               . "AND procedures_table.PROC_STATUS = 1" );
//        return $val;
//  }

//  function getcombineddata($user_id){
//        $val = $this->complexSelect2("mobo.USER_ID,mobo.USER_NAMES,"
//                . "bookservice.BS_DATE,bookservice.BS_TIME,bookservice.BS_NOTES,bookservice.BS_ID,"
//                . "bookservice.BS_TYPE",
//            "mobo,bookservice,automech",
//            "WHERE mobo.USER_ID = bookservice.US_ID AND automech.US_ID = '$user_id'  "
//                . "AND automech.REG_ID = bookservice.BS_ASS_MECH AND bookservice.BS_REQUEST = 0");
//        return $val;
//  }
	
	
	function getProceduresId($id){
    	$val = $this -> simpleLazySelect('procedures_table', "where PROC_ID = '$id' and PROC_STATUS = 1");
		return @$val[0];
	}
	
	
 }
?>