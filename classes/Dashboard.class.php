<?php

include_once('DBConn.class.php');

class Dashboard extends DBConn {
    function getSum($table, $column, $condition) {
        $value = $this->lazySum($table, $column, $condition);
        return $value;
    }

    function getCount($table, $condition) {
        return $this->countLazySelect($table, $condition);
    }

    
    
}

?>