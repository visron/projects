<?php

include_once('DBConn.class.php');

class Dashboard extends DBConn {

    function getProductCount($product) {
        $value = $this->countLazySelect('temp_ussd', "WHERE TU_PR_TYPE ='" . $product . "' AND TU_ISVISIBLE=1");
        return $value;
    }

    function getSum($table, $column, $condition) {
        $value = $this->lazySum($table, $column, $condition);
        return $value;
    }

    function getCount($table, $condition) {
        return $this->countLazySelect($table, $condition);
    }

    function getProductionData($uid) {
        return $this->lazyBlank("select MP_DATE ,(MP_MORNING+MP_MID_DAY+MP_EVENING) as production from milk_production where US_ID = $uid AND MP_STATUS = 1 GROUP BY MONTH(MP_DATE) ASC");
    }
    
    function getMilk_Production_Data_Weekly($uid){
        return $this->lazyBlank("select MP_DATE, SUM((MP_MORNING+MP_MID_DAY+MP_EVENING)) as production from milk_production where US_ID = $uid AND MP_STATUS = 1 GROUP BY MP_DATE ORDER BY MP_DATE DESC LIMIT 14");
    }
	
	function getMilk_Production_Data_Weekly_Mobile($uid){
        return $this->lazyBlank("SELECT MP_DATE, SUM((MP_MORNING+MP_MID_DAY+MP_EVENING)) as production from milk_production where US_ID = $uid AND MP_STATUS = 1 GROUP BY MP_DATE ORDER BY MP_DATE DESC LIMIT 14");
    }
    
    function getProductSaleComparison($uid){
        $query = "SELECT (SELECT SUM(DS_TOTAL) FROM dairy_sales) AS GRAND_TOTAL, PR_NAME, SUM(DS_TOTAL) as DS_TOTAL, "
                . "DS_TOTAL*100 AS PC FROM products, dairy_sales WHERE dairy_sales.US_ID = $uid AND "
                . "dairy_sales.PR_ID = products.PR_ID AND dairy_sales.DS_STATUS = 1 GROUP BY products.PR_NAME ORDER BY DS_TOTAL DESC";
        return @$this -> lazyBlank($query);
    }

    function getCategorySaleComparison($uid){
        $query = "SELECT (SELECT SUM(DS_TOTAL) FROM dairy_sales) AS GRAND_TOTAL, CC_NAME, SUM(DS_TOTAL) as DS_TOTAL "
                . "FROM customer_categories, dairy_sales WHERE dairy_sales.US_ID = $uid AND "
                . "dairy_sales.CC_ID = customer_categories.CC_ID AND dairy_sales.DS_STATUS = 1 GROUP BY customer_categories.CC_NAME ORDER BY DS_TOTAL DESC";
        return @$this -> lazyBlank($query);
    }
    
    function getOutstandingBalances($uid){
        $query = "SELECT C_NAME, SUM(CS_BALANCE) AS TOTAL_BALANCE FROM customers, customer_statement WHERE customer_statement."
                . "US_ID = $uid AND customer_statement.CS_BALANCE > 0 AND customer_statement.C_ID = customers.C_ID AND "
                . "customer_statement.CS_STATUS = 1 GROUP BY customer_statement.C_ID ORDER BY TOTAL_BALANCE DESC LIMIT 8";
        return @$this -> lazyBlank($query);
    }
}

?>