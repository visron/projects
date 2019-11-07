<?php
include_once('DBConn.class.php');
 
 class Vets extends DBConn{
	 function createVet($uid, $name, $number, $location){
		 if(substr($number, 0, 2) == "07"){
			   $number = str_replace("07", "2547", $number);
		 }
		 return $this -> lazyInsert('vets', array('us_id', 'v_name', 'v_number', 'v_location', 'v_ins_date'),array($uid, $name, $number, $location, $this -> DBdate));
	 }
	 
	 function deleteVet($id){
		  if($this -> lazyUpdate('vets', array('V_STATUS'), array(0), 'V_ID', $id)){
			 return true;
		 }else{
			 return false;
		 }
	 }
	 
	 function updateVet($id, $name, $number, $location){
		 if($this -> lazyUpdate('vets', array('v_name', 'v_number', 'v_location'), array($name, $number, $location), 'v_id', $id)){
			 return true;
		 }else{
			 return false;
		 }
	 }
	 
	 function getVet($id){
     	$val = $this -> simpleLazySelect('vets',"where v_id = '$id' and v_status = 1");
		return @$val[0];
	 }
 }
 
?>