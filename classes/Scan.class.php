<?php
/**
 * Created by PhpStorm.
 * User: ELITEBOOK 840
 * Date: 11/25/2018
 * Time: 12:22 PM
 */
include_once 'DBConn.class.php';

class Scan extends DBConn
{

    function getScan($role, $stationId)
    {


        if ($role == 2) {
            $val = $this->simpleLazySelect('gate_scan', "WHERE  G_STATUS = 1 ORDER BY G_ID DESC LIMIT 200");
            return $val;
        } else if ($role == 29) {
            $val = $this->lazyBlank("SELECT * FROM gate_scan gs,users us WHERE gs.G_STATUS = 1 AND us.AR_ID = 29 ORDER BY gs.G_ID DESC");
            return $val;
        } else {
            $val = $this->simpleLazySelect('gate_scan', "WHERE  G_STATION = $stationId
         AND G_STATUS = 1 ORDER BY G_ID DESC LIMIT 200");
            return $val;
        }

    }

    function getqrscans($uid)
    {
        $val = $this->simpleLazySelect('gate_scan', "WHERE USER_ID = $uid AND G_STATUS = 1 ORDER BY G_ID DESC");
        return $val;

    }

    function getTown($uid){
        $val = $this->simpleLazySelect('users', "WHERE  USER_ID ='$uid' ");
        return @$val[0];
    }

    function getQR()
    {
        $val = $this->simpleLazySelect('gate_scan', 'WHERE QR_STATUS = 1');
        return $val;
    }

    function getqrCodes()
    {
        $val = $this->simpleLazySelect('qrcodes', 'WHERE QR_STATUS = 1');
        return $val;
    }

    function getName($id)
    {
        $val = $this->simpleLazySelect('users', "WHERE USER_ID = $id");
        return @$val[0];
    }

    function getTowns()
    {
        return $this->simpleLazySelect("town", "");
    }

    function getCronScan($townID)
    {
        $data = $this->lazyBlank("SELECT * FROM gate_scan gs, users us WHERE gs.G_TIMESTAMP > DATE_SUB(NOW(), INTERVAL 24 HOUR)
        AND gs.G_TIMESTAMP <= NOW()  AND gs.G_STATION = us.USER_TOWN AND us.USER_ID = gs.G_GUARD AND us.USER_TOWN = $townID ORDER BY G_ID DESC ");
        return $data;
    }
    function getScanItem(){
       $val = $this->simpleLazySelect('gate_scan', 'WHERE G_STATUS = 1 and G_ID > 8600');
        return $val; 
    }
     function get_Name($id)
    {
        $val = $this->simpleLazySelect('users', "WHERE USER_ID = $id");
        return @$val[0];
    }
    
    function getGateScan($townId,$start,$end) {
        $sql = $this->lazyBlank("SELECT * FROM `gate_scan` WHERE `G_STATION` = '$townId' BETWEEN '$start' AND '$end'");
        return $sql;
    }

}