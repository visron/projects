<?php

define("PBKDF2_HASH_ALGORITHM", "sha256");
define("PBKDF2_ITERATIONS", 1000);
define("PBKDF2_SALT_BYTE_SIZE", 24);
define("PBKDF2_HASH_BYTE_SIZE", 24);

define("HASH_SECTIONS", 4);
define("HASH_ALGORITHM_INDEX", 0);
define("HASH_ITERATION_INDEX", 1);
define("HASH_SALT_INDEX", 2);
define("HASH_PBKDF2_INDEX", 3);

include_once('DBConn.class.php');

class Admin extends DBConn {
    
 
    function getAllUsers(){
        $users = $this->simpleLazySelect('users', "WHERE U_STATUS = 1");
        return @$users;
    }
    function getUsername($id){
         $username = $this->simpleLazySelect('users', "WHERE U_ID = '$id'");
        return @$username;
    }
    function create_user($firstname, $surname, $username, $email, $phone) {
//        $checkUser = $this->countLazySelect('users', "WHERE USERNAME ='$username' ");
//        if ($checkUser == 0) {

            $create = $this->lazyInsert('users',
                array( 'U_NAME', 'U_FNAME', 'U_EMAIL', 'U_PHONE'),
                array($firstname, $surname, $email, $phone));
            if ($create) {
                return $create;
                $this->Log("Created user", $_SESSION['UID']);
            } else {
                return false;
            }
    }
    function signup($firstname, $username, $email, $phone,$password,$usertype) {
//        $checkUser = $this->countLazySelect('users', "WHERE USERNAME ='$username' ");
//        if ($checkUser == 0) {

            $create = $this->lazyInsert('users',
                array( 'U_FNAME', 'U_NAME', 'U_EMAIL', 'U_PHONE','U_PASSWORD','U_TYPE'),
                array($firstname, $username, $email, $phone,$password,$usertype));
            if ($create) {
                return $create;
                $this->Log("Created user", '0');
            } else {
                return false;
            }
    }
   
    function login_admin($un, $pw,$usertype) {
        $det = $this->simpleLazySelect('users', "WHERE U_NAME='$un' AND U_STATUS = 1 AND U_PASSWORD = '$pw' AND U_TYPE='$usertype'");
        $rows = count($det);
        if ($rows == 1) {
            //$isMatch = $this->validate_password($pw, $det[0]['PASSWORD']);
//            if (!$isMatch) {
//                return false;
//            }
            //else {
                $_SESSION['UID'] = $det[0]['U_ID'];
                $_SESSION['NAME'] = $det[0]['U_NAME'];
                $_SESSION['PHONE'] = $det[0]['U_PHONE'];
                $_SESSION["LAST_ACTIVITY"] = $this->DBdate;
                
                return $det[0];
          //  }
        } else {
            return false;
        }
    }



    

}?>