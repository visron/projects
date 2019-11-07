<?php
include_once('DBConn.class.php');
class Tests extends DBConn {
    function createTest_Group($uid, $test_name, $test_description, $test_symptoms, $group, $gender) {
        return $this->lazyInsert('tests', array('US_ID', 'HM_ID', 'TS_NAME', 'TS_DESCRIPTION', 'TS_GENDER', 'TS_SYMPTOMS',
                    'TS_STATUS', 'TS_INS_DATE'), array($uid, $group, $test_name, $test_description, $gender, $test_symptoms, '1',
                    $this->DBdate));
    }

    function createSub_Tests($uid, $sub_test_name, $sub_test_description, $sub_test_price, $test_group, $sub_test_gender,
            $sub_test_preparation) {
        return $this->lazyInsert('sub_tests', 
                array('US_ID', 'TS_ID', 'ST_NAME', 'ST_DESCRIPTION', 'ST_PRICE', 'ST_GENDER', 'ST_PREPARATION', 'ST_STATUS',
                    'ST_INS_DATE'), 
                array($uid, $test_group, $sub_test_name, $sub_test_description, $sub_test_price, $sub_test_gender, 
                    $sub_test_preparation, '1', $this->DBdate));
    }

    function updateTest_Group($uid, $id, $group, $test_name, $test_description, $test_symptoms, $gender) {
        if ($this->lazyUpdate('tests', 
                array('US_ID', 'HM_ID', 'TS_NAME', 'TS_DESCRIPTION', 'TS_SYMPTOMS', 'TS_GENDER'), 
                array($uid, $group, $test_name, $test_description, $test_symptoms, $gender), 
                'TS_ID', $id)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteTest($id) {
        if ($this->lazyUpdate('tests', array('TS_STATUS'), array(0), 'TS_ID', $id)) {
            return true;
        } else {
            return false;
        }
    }

    function getAllTests() {
        $val = $this->simpleLazySelect('tests', "where TS_STATUS = 1");
        return @$val;
    }
    
    function getAll_Sub_Tests() {
        $val = $this->simpleLazySelect('sub_tests', "where ST_STATUS = 1");
        return @$val;
    }

    function getUnassigned_Sub_Tests($pr_id) {
        //$val = $this->simpleLazySelect('sub_tests', "where ST_STATUS = 1");
        $val = $this->lazyBlank("SELECT sub_tests.ST_ID, sub_tests.ST_NAME FROM sub_tests WHERE"
                . " ST_ID NOT IN(SELECT ST_ID FROM service_mapping WHERE service_mapping.PR_ID = $pr_id)");
        return @$val;
    }
    
    function getAll_Tests_Mobile() {
        $val = $this->complexSelect(array("health_materials", "tests", "sub_tests"), 
                array("health_materials.HM_ID", "tests.TS_ID", "sub_tests.ST_ID", "HM_NAME", "HM_DESCRIPTION", "TS_NAME", "TS_DESCRIPTION", "TS_GENDER", "TS_PRICE",
            "ST_NAME", "ST_DESCRIPTION", "ST_GENDER", "ST_PRICE"), 
                "WHERE health_materials.HM_ID = tests.HM_ID AND tests.TS_ID = sub_tests.TS_ID AND tests.TS_STATUS = 1 AND sub_tests.ST_STATUS = 1 
		ORDER BY sub_tests.ST_INS_DATE");
        return @$val;
    }

    function getTest($id) {
        $val = $this->simpleLazySelect('tests', "where ts_id = '$id' and ts_status = 1");
        return @$val[0];
    }
    
    function getSub_Test($id) {
        $val = $this->simpleLazySelect('sub_tests', "where st_id = '$id'");
        return @$val[0];
    }
    
    function createBlood_Pressure($cs_id, $date, $systolic, $diastolic) {
        return $this->lazyInsert('blood_pressure', array('CS_ID', 'BP_DATE', 'BP_SBP', 'BP_DBP', 'BP_INS_DATE'), 
        array($cs_id, $date, $systolic, $diastolic, $this->DBdate));
    }
    
    function getBlood_Pressure($cs_id){
        $val = $this->simpleLazySelect('blood_pressure', 
                "WHERE CS_ID = '$cs_id' AND BP_STATUS = 1 ORDER BY BP_DATE DESC");
        return @$val;
    }
    
    function getFPLP_Data($cs_id){
        $val = $this->simpleLazySelect('plp_records', 
                "WHERE CS_ID = '$cs_id' AND PLP_STATUS = 1 ORDER BY PLP_INS_DATE DESC");
        return @$val;
    }
    
    function deleteBlood_Pressure($bp_id){
        if ($this->lazyUpdate('blood_pressure', array('BP_STATUS'), array(0), 'BP_ID', $bp_id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function verify_Test($cs_id, $ts_id, $st_id) {
        $check_test = $this->countLazySelect('requested_tests', 
                "WHERE CS_ID = '$cs_id' AND TS_ID = '$ts_id' AND ST_ID = '$st_id' AND RT_STATUS = 1");
        if ($check_test == 1) {
            return true;
        }else{
            return false;
        }
    }
    
    function request_Test($cs_id, $ts_id, $st_id, $pr_id, $st_price){
        return $this->lazyInsert('requested_tests', 
                array('CS_ID', 'TS_ID', 'ST_ID', 'PR_ID', 'ST_PRICE', 'RT_INS_DATE'), 
                array($cs_id, $ts_id, $st_id, $pr_id, $st_price, $this->DBdate));
    }
    
    function request_Weight_Consultant($cs_id, $weight, $height, $bmi){
        return $this->lazyInsert('weight_inquiry', 
                array('CS_ID', 'WI_CURRENT_HEIGHT', 'WI_CURRENT_WEIGHT', 'WI_CURRENT_BMI', 'WI_INS_DATE'), 
                array($cs_id, $height, $weight, $bmi, $this->DBdate));
    }
    
    function getRequested_Tests($cs_id){
        $val = $this->complexSelect(array("requested_tests", "sub_tests", "tests"), 
                array("requested_tests.RT_ID", "requested_tests.CS_ID", "requested_tests.RT_DATE", "requested_tests.RT_STATUS", 
                    "requested_tests.ST_PRICE", "requested_tests.RT_PAY_STATUS", "requested_tests.RT_INS_DATE", 
                    "sub_tests.ST_NAME", "sub_tests.ST_ID", "tests.TS_NAME", "requested_tests.PR_ID"), 
                "WHERE requested_tests.CS_ID = '$cs_id' AND requested_tests.ST_ID = sub_tests.ST_ID AND "
                . " requested_tests.TS_ID = tests.TS_ID AND requested_tests.RT_STATUS != 0 "
                . "ORDER BY requested_tests.RT_INS_DATE");
        return @$val;
    }
    
    function getRequested_Test_Res($id){
        $val = $this->simpleLazySelect('requested_tests', 
                "WHERE RT_ID = '$id' ORDER BY RT_INS_DATE DESC");
        return @$val[0];
    }
    
    function deleteRequested_Test($rt_id){
        if ($this->lazyUpdate('requested_tests', array('RT_STATUS'), array(0), 'RT_ID', $rt_id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function simulatePay($rt_id){
        if ($this->lazyUpdate('requested_tests', array('RT_PAY_STATUS'), array(1), 'RT_ID', $rt_id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function createTest_Result($uid, $pr_id, $rt_id, $cs_id, $st_id, $lif, $lab_report, $after_review){
        return $this->lazyInsert('test_results', 
                array('CS_ID', 'US_ID', 'PR_ID', 'RT_ID', 'ST_ID', 'TR_LAB_INPUT_FIGURE', 'TR_LAB_REPORT', 
                    'TR_CUSTOMER_ACTION', 'TR_INS_DATE', 'TR_UPDATE_DATE'), 
                array($cs_id, $uid, $pr_id, $rt_id, $st_id, $lif, $lab_report, $after_review, $this->DBdate, 
                    $this->DBdate));
    }
    
    function createPLP_Result($rt_id, $tr_id, $pr_id, $us_id, $cs_id, $st_id, $total_chol, $triglycerides, $hdl_chol, 
            $ldl_chol, $lif){
        return $this->lazyInsert('plp_records', 
                array('RT_ID', 'TR_ID', 'PR_ID', 'US_ID', 'CS_ID', 'ST_ID', 'PLP_TOTAL_CHOLESTEROL', 
                    'PLP_TRIGLYCERIDES', 'PLP_HDL_CHOLESTEROL', 'PLP_LDL_CHOLESTEROL', 'PLP_PERCENTAGE', 'PLP_INS_DATE'), 
                array($rt_id, $tr_id, $pr_id, $us_id, $cs_id, $st_id, $total_chol, $triglycerides, $hdl_chol, $ldl_chol, 
                    $lif, $this->DBdate));
    }
    
    function updateRT_Status($rt_id, $pr_id){
        if ($this->lazyUpdate('requested_tests', array('PR_ID', 'RT_STATUS'), array($pr_id, 2), 'RT_ID', $rt_id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function lockTest($rt_id, $pr_id){
        if ($this->lazyUpdate('requested_tests', array('PR_ID', 'RT_STATUS', 'RT_LOCK_DATE'), 
                array($pr_id, 3, $this->DBdate), 'RT_ID', $rt_id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function validateLocked_ProviderlockTest($pr_id, $rt_id){
        $check_lock = $this->countLazySelect('requested_tests', 
                "WHERE RT_ID = '$rt_id' AND PR_ID = '$pr_id' AND RT_STATUS = 3");
        if ($check_lock == 1) {
            return true;
        }else{
            return false;
        }
    }
    
    function getCustomer_Results($cs_id){
        $val = $this->complexSelect(array("test_results", "requested_tests", "sub_tests", "providers"), 
                array("test_results.TR_ID", "test_results.RT_ID", "test_results.CS_ID", "test_results.TR_STATUS", 
                    "test_results.TR_LAB_INPUT_FIGURE", "test_results.TR_INS_DATE", 
                    "test_results.TR_LAB_REPORT", "test_results.TR_CUSTOMER_ACTION", "test_results.PR_ID", 
                     "sub_tests.ST_NAME", "providers.PR_NAME"), 
                "WHERE test_results.CS_ID = '$cs_id' AND test_results.RT_ID = requested_tests.RT_ID AND "
                . "sub_tests.ST_ID = test_results.ST_ID AND test_results.PR_ID = providers.PR_ID AND "
                . "test_results.TR_STATUS = 1 ORDER BY test_results.TR_INS_DATE");
        return @$val;
    }
    
    function updateTest_Price($pr_id, $sm_id, $uid, $sm_price){
        if ($this->lazyUpdate('service_mapping', 
                array('US_ID', 'SM_PRICE'), array($uid, $sm_price), 'SM_ID', $sm_id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function deleteTest_Price($sm_id){
        if ($this->lazyUpdate('service_mapping', 
                array('SM_PRICE'), array(0), 'SM_ID', $sm_id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function editTest_Price($sm_id, $sm_price){
        if ($this->lazyUpdate('service_mapping', 
                array('SM_PRICE'), array($sm_price), 'SM_ID', $sm_id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function createSelf_Test_Reminder($cs_id, $msg, $d_gcm_id){
        $check_reminder = $this->countLazySelect('self_test_reminders', 
                "WHERE CS_ID = '$cs_id' AND STR_STATUS = 1");
        if ($check_reminder > 0) {
            return $this->lazyUpdate('self_test_reminders', 
                    array('D_GCM_ID', 'STR_EXEC_DATE', 'STR_MESSAGE'), 
                    array($d_gcm_id, $this->DBdate, $msg), 'CS_ID', $cs_id);
        }else{
            return $this->lazyInsert('self_test_reminders', 
                    array('CS_ID', 'D_GCM_ID', 'STR_START_DATE', 'STR_EXEC_DATE', 'STR_MESSAGE', 'STR_INS_DATE'), 
            array($cs_id, $d_gcm_id, $this->DBdate, $this->DBdate, $msg, $this->DBdate));
        }
    }
    
    function createTest_Result_Alert($cs_id, $fn, $d_gcm_id){
        return $this->lazyInsert('test_results_alerts', 
                    array('CS_ID', 'D_GCM_ID', 'TRA_EXEC_DATE', 'TRA_MESSAGE', 'TRA_INS_DATE'), 
            array($cs_id, $d_gcm_id, $this->DBdate, $fn, $this->DBdate));
    }
    
    function updateBooking($rt_id, $cs_id, $pr_id, $st_price, $date){
        if ($this->lazyUpdate('requested_tests', 
                array('PR_ID', 'ST_PRICE', 'RT_DATE'), 
                array($pr_id, $st_price, $date), 'RT_ID', $rt_id)) {
            return true;
        } else {
            return false;
        }
    }
}
?>