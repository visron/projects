<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mech
 *
 * @author ELITEBOOK 840
 */
include_once('DBConn.class.php');
class mech extends DBConn {
    //`REG_ID`, `US_ID`, `username`, `email`, `number`, `password`, `insertdate`, `status`, `type`, `date`,
    // `authentification`, `location`, `LatLong`, `TOKEN`, `IMAGE`, `registered`, `LONGITUDE`, `ADDRESS`, `SPECIALITY`, `MAKES`
    
    function newMechanic($us_id,$username,$email,$number,$location,$address,$spec) {
        return $this->lazyInsert('automech',array('US_ID','username','email','number','password','insertdate','status',
            'date','location','ADDRESS','SPECIALITY'), array($us_id,$username,$email,$number,"autocare1234", $this->DBdate,
                "1", $this->DBdate,$location,$address,$spec));
    }
    function deleteMechanic($status) {
        if ($this->lazyUpdate('automech',array('status'),array(0),'status',$status)){
            return true;
        } else {
            return false;
        }
    }
}
