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
    function seepassword(){}
   
    function login_admin($un, $pw) {
        $det = $this->simpleLazySelect('users', "WHERE U_NAME='$un' AND U_STATUS = 1");
        $rows = count($det);
        if ($rows == 1) {
            //$isMatch = $this->validate_password($pw, $det[0]['PASSWORD']);
//            if (!$isMatch) {
//                return false;
//            }
            //else {
                $_SESSION['UID'] = $det[0]['U_ID'];
                $_SESSION['FIRSTNAME'] = $det[0]['U_FNAME'];
                $_SESSION['LASTNAME'] = $det[0]['U_NAME'];
                $_SESSION['PHONE'] = $det[0]['U_PHONE'];
                $_SESSION['EMAIL'] = $det[0]['U_EMAIL'];
                $_SESSION["LAST_ACTIVITY"] = $this->DBdate;
                
                return $det[0];
          //  }
        } else {
            return false;
        }
    }

    function checkLogin() {
        if (isset($_SESSION['UID'])) {
            return true;
        } else {
            return false;
        }
    }

    function getAdminInfo($uid) {
        $det = $this->simpleLazySelect( 'users', "WHERE user_id='$uid'");
        if ($det) {

            return $det[0];
        } else {
            return false;
        }
    }
    
    function logOut() {
        return $this->lazyUpdate("auth_sessions", array("USER_LOGOFF"), array($this->DBdate), "AS_ID", $_SESSION["SESS_ID"]);
        unset($_SESSION['UID']);
        unset($_SESSION['FIRSTNAME']);
        unset($_SESSION['LASTNAME']);
        unset($_SESSION['TYPE']);
        unset($_SESSION['AUTH']);
        unset($_SESSION["SESS_ID"]);
        unset($_SESSION["LAST_ACTIVITY"]);
        session_destroy();
    }

    function create_hash($password) {
        // format: algorithm:iterations:salt:hash
          $salt = base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));
          return PBKDF2_HASH_ALGORITHM . ":" . PBKDF2_ITERATIONS . ":" . $salt . ":" .
                  base64_encode($this->pbkdf2(
                                  PBKDF2_HASH_ALGORITHM, $password, $salt, PBKDF2_ITERATIONS, PBKDF2_HASH_BYTE_SIZE, true
          ));
        return $password;
    }
function validate_password($password, $correct_hash) {
        $params = explode(":", $correct_hash);
        if (count($params) < HASH_SECTIONS)
            return false;
        $pbkdf2 = base64_decode($params[HASH_PBKDF2_INDEX]);
        return
                $this->slow_equals(
                        $pbkdf2, $this->pbkdf2(
                                $params[HASH_ALGORITHM_INDEX], $password, $params[HASH_SALT_INDEX], (int) $params[HASH_ITERATION_INDEX], strlen($pbkdf2), true
                        )
        );
    }
  
    function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false) {
        $algorithm = strtolower($algorithm);
        if (!in_array($algorithm, hash_algos(), true))
            die('PBKDF2 ERROR: Invalid hash algorithm.');
        if ($count <= 0 || $key_length <= 0)
            die('PBKDF2 ERROR: Invalid parameters.');

        $hash_length = strlen(hash($algorithm, "", true));
        $block_count = ceil($key_length / $hash_length);

        $output = "";
        for ($i = 1; $i <= $block_count; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt . pack("N", $i);
            // first iteration
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < $count; $j++) {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }

        if ($raw_output)
            return substr($output, 0, $key_length);
        else
            return bin2hex(substr($output, 0, $key_length));
    }

}?>