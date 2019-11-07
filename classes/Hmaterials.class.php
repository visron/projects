<?php include_once('DBConn.class.php');
 
 class Materials extends DBConn{
	 function createHealth_Tip($uid, $topic, $description, $from, $to){
		$f_date = date('Y-m-d', strtotime($from));
		$t_date = date('Y-m-d', strtotime($to));
		 return $this -> lazyInsert('health_tips', array('US_ID', 'HT_TOPIC', 'HT_BODY', 'HT_FROM', 'HT_TO', 'HT_INS_DATE'),
		 array($uid, $topic, $description, $f_date, $t_date, $this -> DBdate));
	 }
	 
	 function createHealth_Material($uid, $name, $description){
		 return $this -> lazyInsert('health_materials', array('US_ID', 'HM_NAME', 'HM_DESCRIPTION', 'HM_INS_DATE'),
		 array($uid, $name, $description, $this -> DBdate));
	 }
	 
	 function deleteHealth_Tip($id){
		 if($this -> lazyUpdate('health_tips', array('HT_STATUS'), array(0), 'HT_ID', $id)){
			 return true;
		 }else{
			 return false;
		 }
	 }
	 
	 function updateHealth_Tip($id, $uid, $topic, $description, $from, $to){
		 if($this -> lazyUpdate('health_tips', array('HT_TOPIC', 'HT_BODY', 'HT_FROM', 'HT_TO', 'HT_INS_DATE'), 
			array($topic, $description, $from, $to, $this -> DBdate), 'HT_ID', $id)){
			return true;
		 }else{
			return false;
		 }
	 }
	 
	 function updateHealth_Material($id, $uid, $name, $description){
		 if($this -> lazyUpdate('health_materials', array('HM_NAME', 'HM_DESCRIPTION', 'HM_INS_DATE'), 
			array($name, $description, $this -> DBdate), 'HM_ID', $id)){
			return true;
		 }else{
			return false;
		 }
	 }
	
	function deleteHealth_Material($id){
		 if($this -> lazyUpdate('health_materials', array('HM_STATUS'), array(0), 'HM_ID', $id)){
			 return true;
		 }else{
			 return false;
		 }
	}
	
	function getAllHmaterials(){
		$val = $this -> simpleLazySelect('health_materials', "where HM_STATUS = 1");
		return @$val;
	}
	 
	function getHtipById($id){
    	$val = $this -> simpleLazySelect('health_tips', "where HT_ID = '$id' and HT_STATUS = 1");
		return @$val[0];
	}
	
	function getHMaterialById($id){
    	$val = $this -> simpleLazySelect('health_materials', "where HM_ID = '$id' and HM_STATUS = 1");
		return @$val[0];
	}
	
	function getHealth_Tip_Latest(){
		$val = $this -> simpleLazySelect('health_tips', "where HT_STATUS = 1 order by HT_INS_DATE desc limit 1");
		return @$val[0];
	}
	
	function getHealth_Tip_Week($date){
		$val = $this -> simpleLazySelect('health_tips', "where HT_FROM >= '$date' and HT_TO < '$date' and HT_STATUS = 1 order by HT_INS_DATE desc limit 1");
		return @$val[0];
	}
 }
?>