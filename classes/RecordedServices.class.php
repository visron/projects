<?php
/**
 * Created by PhpStorm.
 * User: ELITEBOOK 840
 * Date: 12/24/2018
 * Time: 12:12 AM
 */
include_once 'DBConn.class.php';
class RecordedServices extends DBConn{

    function getAllRepairs(){
        $val = $this->simpleLazySelect('repairs',"WHERE R_STATUS = 1");
        return $val;
    }
    function getAllServices(){
        $val = $this->simpleLazySelect('automech_service',"WHERE AS_STATUS = 1");
        return $val;
    }
    function updaterepair($re_id,$items,$cost,$date){
        if ($this->lazyUpdate('repairs', array('R_ITEMS','R_COST','R_DATE'), array($items,$cost,$date), 'R_ID', $re_id)) {
            return true;
        } else {
            return false;
        }
    }
    function deleterepair($re_id){
        if ($this->lazyUpdate('repairs', array('R_STATUS'), array(0), 'R_ID', $re_id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function addrepair($us_id, $services, $date, $time, $cost, $description,$service_id) {
        $val = $this->lazyInsert('repairs', array('USER_ID', 'R_ITEMS', 'R_DATE', 'R_TIME', 'R_COST', 'R_NOTES', 'R_INPUTDATE','R_S_ID'), array($us_id, $services, $date, $time, $cost, $description, $this->DBdate,$service_id));
        return $val;
    }
    function Fetch_report($us_id) {
        $val = $this->simpleLazySelect('repairs', "where USER_ID = '$us_id' AND R_STATUS = 1");
        return @$val;
    }
    
    
    //'USER_ID', 'R_ITEMS', 'R_DATE', 'R_TIME', 'R_COST', 'R_NOTES', 'R_INPUTDATE', 'R_STATUS'
}