<?php

include_once('DBConn.class.php');

class Dashboard extends DBConn {

    function getProductCount($product) {
        //$value = $this->countLazySelect('temp_ussd',"WHERE TU_PR_TYPE ='".$product."' AND TU_ISVISIBLE=1");
        return $value;
    }

    function getSum($table, $column, $condition) {
        $value = $this->lazySum($table, $column, $condition);
        return $value;
    }

    function getCount($table, $condition) {
        return $this->countLazySelect($table, $condition);
    }

    function getProductionData() {
        return $this->lazyBlank("select MP_DATE ,(MP_MORNING+MP_MID_DAY+MP_EVENING) as production from milk_production where MP_STATUS = 1 GROUP BY MONTH(MP_DATE) ASC");
    }
    
    function getCustomer_County_Comparison() {
        $query = "SELECT counties.C_NAME, customers.C_CODE, COUNT(customers.C_CODE) AS PER_C_COUNT, "
                . "(SELECT COUNT(*) FROM customers) AS GRAND_TOTAL FROM counties, "
                . "customers WHERE counties.C_CODE = customers.C_CODE AND customers.CS_STATUS = 1 "
                . "GROUP BY counties.C_CODE LIMIT 5";
        return @$this->lazyBlank($query);
    }
    
    function getCustomer_Gender_Comparison() {
        $query = "SELECT PAT_SEX, COUNT(PAT_SEX) AS PAT_COUNT, (SELECT COUNT(*) FROM patients_table) AS GRAND_TOTAL "
                . "FROM patients_table WHERE PAT_STATUS = 1 GROUP BY PAT_SEX";
        return @$this->lazyBlank($query);
    }
    
    function getUser_Widgets($ar_id){
        $val = $this->simpleLazySelect('auth_dashboard_widgets', "WHERE AR_ID = '$ar_id' AND  ADW_STATUS = 1");
        return @$val;
    }
    
    function getLocked_Tests($pr_id) {
         $val = $this->complexSelect(array("requested_tests", "customers", "sub_tests"), 
                array("requested_tests.RT_ID", "requested_tests.RT_LOCK_DATE", "customers.CS_FIRST_NAME", 
                    "customers.CS_LAST_NAME", "sub_tests.ST_NAME"), 
                "WHERE requested_tests.PR_ID = '$pr_id' AND requested_tests.CS_ID = customers.CS_ID AND "
                 . "requested_tests.ST_ID = sub_tests.ST_ID AND requested_tests.RT_STATUS = 3");
        return @$val;
    }
    
    function getProvider_Bookings($pr_id) {
         $val = $this->complexSelect(array("requested_tests", "customers", "sub_tests"), 
                array("requested_tests.RT_ID", "requested_tests.RT_INS_DATE", "requested_tests.RT_PAY_STATUS", 
                    "customers.CS_FIRST_NAME", "customers.CS_LAST_NAME", "sub_tests.ST_NAME"), 
                "WHERE requested_tests.PR_ID = '$pr_id' AND requested_tests.CS_ID = customers.CS_ID AND "
                 . "requested_tests.ST_ID = sub_tests.ST_ID AND requested_tests.RT_STATUS = 1 ORDER BY "
                 . "requested_tests.RT_INS_DATE DESC LIMIT 10");
        return @$val;
    }
}

?>