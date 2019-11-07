<?php
include_once('DBConn.class.php');

class Drivers extends DBConn
{

    function createDriver($name, $phone, $staffno, $natid)
    {
        $val = $this->lazyInsert('drivers', array('D_NAMES', 'D_PHONE', 'D_STAFFNO', 'D_NATID', 'D_STATUS', 'D_TIMESTAMP'),
            array($name, $phone, $staffno, $natid, "1", $this->DBdate));
        return $val;
    }

    function getDrivers()
    {
        $val = $this->simpleLazySelect('drivers', 'WHERE D_STATUS= 1 ORDER BY D_NAMES');
        return $val;
    }

    function createTruck($model, $number)
    {
        $val = $this->lazyInsert('rongai_trucks',
            array('T_MODEL', 'T_NUMBER', 'T_STATUS', 'T_TIMESTUMP'),
            array($model, $number, "1", $this->DBdate));
        return $val;
    }

    function getTrucks()
    {
        $val = $this->simpleLazySelect('rongai_trucks', 'WHERE T_STATUS = 1 ORDER BY T_NUMBER');
        return $val;
    }

    public function getQRInfo($uid)
    {
        $det = $this->lazySelect(1, 1, 'rongai_qr', "WHERE QR_ID='$uid'");
        if ($det) {
            return $det[0];
        } else {
            return false;
        }
    }

    public function getQRDet($uid)
    {
        $det = $this->lazySelect(1, 1, 'qrcodes', "WHERE QR_ID='$uid'");
        if ($det) {
            return $det[0];
        } else {
            return false;
        }
    }

    public function updateQr($id)
    {
        return $this->lazyUpdate('rongai_qr', array('QR_UPDATESTATUS'), array("0"), 'QR_ID', $id);
    }

    public function updatedQR($id, $truck, $trailer, $driver, $container)
    {

    }

    function deleteDriver($id)
    {
        $val = $this->lazyUpdate('drivers', array('D_STATUS'), array(0), 'D_ID', "$id");
        return $val;
    }

    function deleteTruck($id)
    {
        $val = $this->lazyUpdate('rongai_trucks', array('T_STATUS'), array(0), 'T_ID', "$id");
        return $val;
    }

    public function editDriver($did, $dname, $phone, $staffnum, $natid)
    {
        if ($this->lazyUpdate('drivers', array('D_ID', 'D_NAMES', 'D_PHONE', 'D_STAFFNO', 'D_NATID'), array($did, $dname, $phone, $staffnum, $natid), 'D_ID', $did)) {
            return true;
        } else {
            return false;
        }
    }

    public function getDriverInfo($uid)
    {
        $det = $this->lazySelect(1, 1, 'drivers', "WHERE D_ID='$uid'");
        if ($det) {
            return $det[0];
        } else {
            return false;
        }
    }

    public function editqrcode($qid, $truck, $trailer, $driver, $container, $client, $from, $destination, $eirnumber, $seala, $sealb)
    {
        if ($this->lazyUpdate('qrcodes',
            array('QR_TRUCK', 'QR_TRAILER',
                'QR_DRIVER', 'QR_CONTAINER', 'QR_CLIENT',
                'QR_FROM', 'QR_DESTINATION', 'QR_EIRNUMBER',
                'QR_SEALA', 'QR_SEALB', 'QR_STATUS', 'QR_TIMESTAMP'),
            array($truck, $trailer,
                $driver, $container, $client,
                $from, $destination, $eirnumber,
                $seala, $sealb, "1", $this->DBdate), 'QR_ID', $qid)) {
            return true;
        } else {
            return false;
        }
    }

}