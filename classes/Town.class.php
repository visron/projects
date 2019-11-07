<?php
/**
 * Created by PhpStorm.
 * User: ELITEBOOK 840
 * Date: 11/30/2018
 * Time: 11:16 PM
 */
include_once 'DBConn.class.php';

class Town extends DBConn
{

    function createTown($town, $location)
    {
        $val = $this->lazyInsert('town', array('T_TOWN', 'T_LOCATION'), array($town, $location));
        return $val;
    }

    function station($town, $location)
    {
        $val = $this->lazyInsert('town', array('T_TOWN', 'T_LOCATION'), array($town, $location));
        return $val;
    }

    function getTownById()
    {
        $val = $this->simpleLazySelect('town', "WHERE T_STATUS = 1");
        return $val;
    }
    
    function getAllTowns()
    {
        $val = $this->simpleLazySelect('town', "WHERE T_STATUS = 1");
        return $val;
    }
    
    function getGateReports($town,$start,$end){
        $query = "SELECT * FROM `gate_scan` WHERE G_STATION = '$town' AND DATE(G_TIMESTAMP) BETWEEN '$start' AND '$end' ORDER BY G_ID DESC";
        return $this->lazyBlank($query);
    }
}