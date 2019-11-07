<?php

@session_start();
@error_reporting(E_ALL);
@ini_set('display_errors', TRUE);
@ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Africa/Nairobi');
@ini_set('xdebug.max_nesting_level', 200);

@define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

class DBConn {

    var $connection;
    var $DBdate;

    public function __construct() {
        //tables

        $DB_SERVER = 'localhost';
        $DB_USERNAME = 'rot';
        $DB_PASSWORD = '';
        $DB_DATABASE = 'students';
        $this->refDate = date('Y-m-d');
        $this->DBdate = date('Y-m-d H:i:s', strtotime('now'));
        $connection = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD,$DB_DATABASE) or
                die('Oops connection error -> ' . mysqli_connect_error());
        $this->connection = $connection;
    }

    public function clean($str) {
        $str = @trim($str);
        if (get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return @mysqli_real_escape_string($this->connection, $str);
    }

    function myInsertStatement($table, $column, $value) {
        $out = array();
        $i = 0;
        if (count($column) != count($value)) {
            return false;
        } else {
            $strINS = "INSERT INTO " . $table;
            $strINS .= "(" . implode(',', $column) . ") ";
            $strINS .= "VALUES ";
            for ($i; $i < count($value); $i++) {
                array_push($out, "'$value[$i]'");
            }
            $strINS .= "(" . (implode(',', $out)) . ")";
            $objParse = mysqli_query($this->connection, $strINS);
            $id = mysqli_insert_id($this->connection);
            if ($objParse) {
                return $id;
            } else {
                return FALSE;
            }
        }
    }

    function simpleSelectStatement($table, $condition) {
        $strSEL = "SELECT * FROM " . $table . " " . ($condition) . "";
        //echo $strSEL."<br>";
        //$objSC = mysqli_query($this->connection, mysqli_real_escape_string($this->connection, $strSEL));
        $objSC = mysqli_query($this->connection, $strSEL);
        if ($objSC) {
            $data = array();
            while ($det = mysqli_fetch_assoc($objSC)) {
                $data[] = $det;
            }
            return $data;
        } else {
            //echo "NO >> ";
            return false;
        }
    }

  

    public function __destruct() {
        @mysqli_close($this->connection);
    }

}

?>
