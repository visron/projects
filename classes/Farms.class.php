<?php

include_once('DBConn.class.php');

class Farms extends DBConn {

    function createFarm($uid, $c_code, $cy_code, $name, $count) {
        return $this->lazyInsert('farms', array('US_ID', 'CY_CODE', 'C_CODE', 'F_NAME', 'F_LIVESTOCK_COUNT', 'F_INS_DATE'), 
		array($uid, $cy_code, $c_code, $name, $count, $this->DBdate));
    }

    function deleteFarm($f_id) {
        if ($this->lazyUpdate('farms', array('F_STATUS'), array(0), 'F_ID', $f_id)) {
            return true;
        } else {
            return false;
        }
    }

    function updateFarm($id, $name, $location) {
        if ($this->lazyUpdate('farms', array('F_NAME', 'F_LOCATION', 'F_INS_DATE'), array($name, $location, $this->DBdate), 'F_ID', $id)) {
            return true;
        } else {
            return false;
        }
    }

    function updateFarm_on_Register($us_id, $f_id) {
        if ($this->lazyUpdate('farms', array('us_id'), array($us_id), 'f_id', $f_id)) {
            return true;
        } else {
            return false;
        }
    }

    function createFarm_Livestock($fid, $uid, $name, $description, $price, $milk, $frequency) {
        return $this->lazyInsert('livestock',
                array('f_id', 'us_id', 'l_name', 'l_description', 'l_initial_price',
                    'l_expected_production', 'l_milking_frequency', 'l_ins_date'), 
                array($fid, $uid, $name, $description, $price, $milk, $frequency, $this->DBdate));
    }
    function createLivestock($fid, $uid, $name, $description, $price, $milk, $breed, $cow_gender, $cow_status, $cow_type, $dob) {
        return $this->lazyInsert('livestock', 
                array('F_ID', 'US_ID', 'L_NAME', 'L_DESCRIPTION', 'L_INITIAL_PRICE',
                    'L_EXPECTED_PRODUCTION', 'L_GENDER', 'L_BREED', 
                    'L_BIRTH_DAY', 'L_BORN_IN_FARM', 'L_STATUS', 'L_INS_DATE'), 
                array($fid, $uid, $name, $description, $price, 
                    $milk, $cow_gender, $breed, 
                    $dob, $cow_type, $cow_status, $this->DBdate));
    }
	
	function updateLivestock($fid, $uid, $l_id, $name, $description, $price, $milk, $breed, $cow_gender, $cow_status, $cow_type, $dob) {
        if ($this->lazyUpdate('livestock', array('F_ID', 'L_NAME', 'L_DESCRIPTION', 'L_INITIAL_PRICE', 'L_EXPECTED_PRODUCTION', 'L_GENDER', 'L_BREED', 
		'L_BIRTH_DAY', 'L_BORN_IN_FARM', 'L_STATUS', 'L_INS_DATE'), array($fid, $name, $description, $price, $milk, $cow_gender, $breed, $dob, $cow_type, 
		$cow_status, $this->DBdate), 'L_ID', $l_id)) {
            return true;
        } else {
            return false;
        }
    }

    function createProduction($uid, $lid, $f_id, $date, $morning, $afternoon, $evening) {
        $d = date('Y-m-d', strtotime($date));
        $total = $morning + $afternoon + $evening;
        return $this->lazyInsert('milk_production', array('l_id', 'us_id', 'f_id', 'mp_date', 'mp_morning', 'mp_mid_day', 'mp_evening', 'mp_total', 'mp_ins_date'), array($lid, $uid, $f_id, $d, $morning, $afternoon, $evening, $total, $this->DBdate));
    }

    function deleteLivestock($id) {
        if ($this->lazyUpdate('livestock', array('L_STATUS'), array(0), 'L_ID', $id)) {
            return true;
        } else {
            return false;
        }
    }

    function updateProduction($id, $morning, $afternoon, $evening) {
        $total = $morning + $afternoon + $evening;
        if ($this->lazyUpdate('milk_production', array('mp_morning', 'mp_mid_day', 'mp_evening', 'mp_total'), array($morning, $afternoon, $evening, $total), 'mp_id', $id)) {
            return true;
        } else {
            return false;
        }
    }
    
    function updateMilk_Production($mp_id, $f_id, $l_id, $mp_date, $mp_morning, $mp_mid_day, $mp_evening, $mp_total) {
        if ($this->lazyUpdate('milk_production', array('L_ID', 'F_ID', 'MP_DATE', 'MP_MORNING', 'MP_MID_DAY', 'MP_EVENING', 'MP_TOTAL', 'MP_INS_DATE'), array($l_id, $f_id, $mp_date, $mp_morning, $mp_mid_day, $mp_evening, $mp_total, $this->DBdate), 'MP_ID', $mp_id)) {
            return true;
        } else {
            return false;
        }
    }

    function updateMilk_Inventory($us_id, $f_id, $mp_date, $mp_total) {
        $val = $this->simpleLazySelect('milk_inventory', "where US_ID = '$us_id' AND MI_DATE = '$mp_date' AND MI_STATUS = 1");
        if ($val) {
            $mi_id = $val[0]['MI_ID'];
            $new_produced = $val[0]['MI_PRODUCED'] + $mp_total;
            $new_remaining = $val[0]['MI_REMAINING'] + $mp_total;
            if ($this->lazyUpdate('milk_inventory', array('MI_PRODUCED', 'MI_REMAINING', 'MI_INS_DATE'), array($new_produced,
                        $new_remaining, $this->DBdate), 'MI_ID', $mi_id)) {
                return true;
            } else {
                return false;
            }
        } else {
            return $this->lazyInsert('milk_inventory', array('us_id', 'f_id', 'mi_date', 'mi_produced', 'mi_sold', 'mi_remaining',
                        'mi_ins_date'), array($us_id, $f_id, $mp_date, $mp_total, "0", $mp_total, $this->DBdate));
        }
    }

    function getAllFarms() {
        $val = $this->simpleLazySelect('farms', "where f_status = 1");
        return @$val;
    }

    function getFarm($id) {
        $val = $this->simpleLazySelect('farms', "where f_id = '$id' and f_status = 1");
        return @$val[0];
    }

    function getLivestock() {
        $val = $this->simpleLazySelect('livestock', "where l_status = 1");
        return @$val;
    }

    function getLivestock_id($id) {
        //removed l_status in select query
        $val = $this->simpleLazySelect('livestock', "where l_id = '$id'");
        //$val = $this -> simpleLazySelect('livestock',"where l_id = '$id' and l_status = 1");
        return @$val[0];
    }

    function getProduction_by_user($id) {
        //$val = $this->complexSelect(array("milk_production", "livestock"), array("*"), "where milk_production.L_ID = livestock.L_ID and milk_production.US_ID = '$id' and milk_production.MP_STATUS = 1 order by milk_production.MP_DATE desc limit 50");
        $val = $this->complexSelect(array("milk_production", "livestock"), 
		array("MP_ID", "milk_production.US_ID", "livestock.L_ID", "L_NAME", "MP_DATE", "MP_MORNING", "MP_MID_DAY", "MP_EVENING", "MP_TOTAL"), 
		"where milk_production.L_ID = livestock.L_ID and milk_production.US_ID = '$id' and milk_production.MP_STATUS = 1 order by milk_production.MP_DATE 
		desc limit 100");
		return @$val;
    }

    function getFarm_by_user($id) {
        $val = $this->simpleLazySelect('farms', "where us_id = '$id' and f_status = 1");
        return @$val;
    }

    function getLivestock_by_user($id) {
        //$val = $this->complexSelect(array("livestock", "farms"), array("*"), "where livestock.F_ID = farms.F_ID and livestock.US_ID = '$id' AND livestock.L_STATUS != 3 AND livestock.L_STATUS != 0 order by livestock.L_INS_DATE desc");
        $val = $this->complexSelect(array("livestock", "farms"), 
		array("L_ID", "livestock.F_ID", "F_NAME", "L_NAME", "L_DESCRIPTION", "L_EXPECTED_PRODUCTION", "L_MILKING_FREQUENCY", "L_GENDER", "L_BREED", 
		"L_BIRTH_DAY", "L_BORN_IN_FARM", "L_STATUS", "L_INITIAL_PRICE"), 
		"WHERE livestock.F_ID = farms.F_ID AND livestock.US_ID = '$id' AND livestock.L_STATUS != 3 AND livestock.L_STATUS != 0 ORDER BY livestock.L_INS_DATE DESC");
		return @$val;
    }
	
	function getLivestock_Serving_Data($l_id){
		$val = $this->simpleLazySelect('cow_service', "WHERE L_ID = '$l_id' AND CS_STATUS = 1");
        return @$val;
	}

	function getBreeding_Bulls(){
		$val = $this->simpleLazySelect('breeding_bulls', "WHERE BB_STATUS = 1");
        return @$val;
	}
	
    function getProduction_id($id) {
        $val = $this->simpleLazySelect('milk_production', "where mp_id = '$id' and mp_status = 1");
        return @$val[0];
    }

    function getProduction_date($cowid, $date) {
        $sql = $this->simpleLazySelect("milk_production", "where l_ID =$cowid and DATE(mp_date) = '$date' ");
        return @$sql[0];
    }

    function deleteMilkProduction($us_id, $mp_id) {
        if ($this->lazyUpdate('milk_production', array('MP_STATUS'), array(0), 'MP_ID', $mp_id)) {
            return true;
        } else {
            return false;
        }
    }
	
	function createServing($us_id, $l_id, $bb_id, $pg_group, $pg_test_status, $service_date) {
        return $this->lazyInsert('cow_service', array('US_ID', 'BB_ID', 'L_ID', 'CS_SERVICE_DATE', 'CS_PG_TEST', 'CS_PD', 'CS_STATUS', 'CS_INS_DATE'), 
		array($us_id, $bb_id, $l_id, $service_date, $pg_group, $pg_test_status, '1', $this->DBdate));
    }

	function getServing_Records_Per_Cow($us_id, $l_id) {
        $val = $this->complexSelect(array("livestock", "cow_service", "breeding_bulls"), array("CS_ID", "cow_service.L_ID", "L_NAME", "breeding_bulls.BB_ID",
		"BB_NAME", "CS_SERVICE_DATE", "CS_EXP_CALVE_DATE", "CS_PG_TEST", "CS_PD", "CS_STATUS"), 
		"where cow_service.L_ID = '$l_id' AND cow_service.L_ID = livestock.L_ID AND cow_service.US_ID = '$us_id' AND 
		cow_service.BB_ID =  breeding_bulls.BB_ID AND cow_service.CS_STATUS = 1 order by cow_service.CS_SERVICE_DATE DESC");
        return @$val;
    }
	
	function getAll_Counties_and_Constituencies(){
		$val = $this -> complexSelect(array("counties", "constituencies"),array("*"),"where constituencies.C_CODE = counties.C_CODE and counties.C_STATUS = 1 and constituencies.CY_STATUS = 1 order by counties.C_NAME ASC");
		return @$val;
	}
}

?>