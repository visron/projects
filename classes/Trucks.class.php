<?php
/**
 *
 * Created by PhpStorm.
 * User: ELITEBOOK 840
 * Date: 9/4/2018
 * Time: 6:12 AM
 *
 */

class Trucks extends DBConn
{

    //CREATE
    function getAllTrucks()
    {
        $val = $this->simpleLazySelect('trucks', 'WHERE TRUCK_STATUS=1 ORDER BY T_NUMBER');
        return $val;
    }

    //QR CODE
    function getQR()
    {
        $val = $this->simpleLazySelect('rongai_qr', 'WHERE QR_STATUS = 1 ORDER BY QR_ID DESC LIMIT 200');
        return $val;
    }

    function getQRDet()
    {
        $val = $this->simpleLazySelect('qrcodes', 'WHERE QR_STATUS = 1 ORDER BY QR_ID DESC LIMIT 200');
        return $val;
    }
    
    

    function get_Name($id)
    {
        $val = $this->simpleLazySelect('users', "WHERE USER_ID = $id");
        return @$val[0];
    }

}