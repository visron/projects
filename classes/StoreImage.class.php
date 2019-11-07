<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StoreImage
 *
 * @author ELITEBOOK 840
 */
include_once('DBConn.class.php');
class StoreImage extends DBConn  {
    //put your code here
    function uploadImage($imgId,$image) {
        return $this->lazyInsert('images', array('id', 'image'), array($imgId,$image));
    }
}
