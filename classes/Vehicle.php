<?php
/**
 * Created by PhpStorm.
 * User: ELITEBOOK 840
 * Date: 12/24/2018
 * Time: 3:13 AM
 */
include_once 'DBConn.class.php';
class Vehicle extends  DBConn{
    //READ ALL VEHICLES
    function getAllVehicle(){
        $val = $this->simpleLazySelect("mobo_car","WHER CAR_VISIBLE = 1");
        return $val;
    }
    
    function editcar($carid, $carmodel, $cartype, $carman, $carfuel, $caryom) {
        if ($this->lazyUpdate('mobo_car',
            array('CAR_MODEL', 'CAR_YOM', 'CAR_MANUFACTURE', 'CAR_TYPE', 'CAR_FUEL'),
            array($carmodel, $caryom, $carman, $cartype, $carfuel), 'CAR_ID', $carid)) {
                return true;
            } else {
                return false;
            }
    }
    
    function hidecar($carid) {
        if ($this->lazyUpdate('mobo_car', array('CAR_STATUS'), array(0), 'CAR_ID', $carid)) {
            return true;
        } else {
            return false;
        }
    }
    function add_car($user_id, $model, $yom, $manufacture, $type, $fuel) {
        $val = $this->lazyInsert('mobo_car', array('USER_ID', 'CAR_MODEL', 'CAR_YOM', 'CAR_MANUFACTURE', 'CAR_TYPE', 'CAR_FUEL'), array($user_id, $model, $yom, $manufacture, $type, $fuel));
        return $val;
    }
    function Fetch_customer_Vehicles($us_id) {
        $val = $this->simpleLazySelect('mobo_car', "where USER_ID = '$us_id'");
        return @$val;
    }
    function Fetch_car($us_id) {
        $val = $this->simpleLazySelect('mobo_car', "where USER_ID = '$us_id' AND CAR_STATUS = 1");
        return @$val;
    }
    
}