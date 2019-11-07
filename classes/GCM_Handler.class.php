<?php
include_once('DBConn.class.php');
class GCM_Handler extends DBConn {
    function fetchReminders() {
        $time = date('Y-m-d', strtotime('now'));
        $val = $this->simpleLazySelect('self_test_reminders', 
                "WHERE STR_EXEC_DATE = '$time' AND STR_STATUS = 1");
        return @$val;
    }
    
    function fetchTest_Results_Alert(){
        $time = date('Y-m-d', strtotime('now'));
        //echo $time."</br>";
        $val = $this->simpleLazySelect('test_results_alerts', 
                "WHERE DATE(TRA_EXEC_DATE) = '$time' AND TRA_STATUS = 1");
        return @$val;
    }
    
    function updateSelf_Test_Status_Cron($str_id){
        $next_exec = date('Y-m-d H:i:s', strtotime('+1 month'));
        return $this->lazyUpdate('self_test_reminders', 
                array('STR_STATUS', 'STR_EXEC_DATE'), array(1, $next_exec), 'STR_ID', $str_id);
    }
    
    function createCron_Job_Response($name, $count, $remarks){
        return $this->lazyInsert('cron_jobs_response', 
                array('CJR_NAME', 'CJR_COUNT', 'CJR_REMARKS', 'CJR_INS_DATE'), 
        array($name, $count, $remarks, $this->DBdate));
    }
    
    function updateTest_Result_Status($tra_id){
        return $this->lazyUpdate('test_results_alerts', 
                array('TRA_STATUS'), array(2), 'TRA_ID', $tra_id);
    }
}
?>
