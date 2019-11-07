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
require_once 'class.phpmailer.php';

class Admin extends DBConn {
    
    function getSevices($cid){
            $table = "automech_service";
            $condition = "WHERE AS_C_ID = $cid";
        $val = $this->simpleLazySelect($table, $condition);
        return @$val;
        
    }
    
    function create_user($roleid, $firstname, $surname, $username, $email, $phone, $password) {
        $checkUser = $this->countLazySelect('users', "WHERE USERNAME ='$username' ");
        if ($checkUser == 0) {

            $create = $this->lazyInsert('users',
                array('AR_ID', 'FIRSTNAME', 'SURNAME', 'USERNAME', 'USER_EMAIL', 'USER_PHONE', 'PASSWORD', 'USER_DATE'),
                array($roleid, $firstname, $surname, $username, $email, $phone, $this->create_hash($password), $this->DBdate), 'users_seq');
            if ($create) {
                return $create;
                $this->Log("Created user", $_SESSION['UID']);
            } else {
                return false;
            }
        } else {

            return 'username taken';
        }
    }

    function create_user_role($permission, $userid) {
        $role = $this->lazyInsert('user_permissions', array('ap_id', 'user_id'), array($permission, $userid), 'user_permissions_seq');
        if ($role) {
            $this->Log("Assigned Permission $permission to Role ID: $userid", $_SESSION['UID']);
            return $role;
        } else {
            return false;
        }
    }

    function removeUserPermission($permissionID) {
        $this->Log("Deactivated permission ID $permissionID", $_SESSION['UID']);
        return $this->lazyDelete('user_permissions', 'up_id', $permissionID);
    }

    function login_admin($un, $pw) {
        $det = $this->simpleLazySelect('users', "WHERE USERNAME='$un' AND user_isvisible = 1");
        $rows = count($det);
        if ($rows == 1) {
            $isMatch = $this->validate_password($pw, $det[0]['PASSWORD']);
            if (!$isMatch) {
                return false;
            } else {
                $_SESSION['UID'] = $det[0]['USER_ID'];
                $_SESSION['FIRSTNAME'] = $det[0]['FIRSTNAME'];
                $_SESSION['LASTNAME'] = $det[0]['SURNAME'];
                $_SESSION['TYPE'] = $det[0]['AR_ID'];
                $_SESSION['AUTH'] = $det[0]['AD_ID'];
                $_SESSION['PHONE'] = $det[0]['USER_PHONE'];
                $_SESSION['EMAIL'] = $det[0]['USER_EMAIL'];
                $_SESSION["SESS_ID"] = $this->loginLog();
                $_SESSION["LAST_ACTIVITY"] = $this->DBdate;
                
                return $det[0];
            }
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

    function getAdminPic($uid) {
        $det = $this->simpleLazySelect( 'uploads', "WHERE up_uniqueid='$uid' AND up_isdeleted=0");
        if ($det) {
            return $det[0];
        } else {
            return false;
        }
    }

    function getAdminByEmail($email) {
        $data = $this->complexSelect(array("users"), array("user_id", "user_email"), "WHERE user_email='$email'");
        return $data[0];
    }

    function updateAdmin($id, $fname, $sname, $email, $phone) {
        $this->Log("Updated user ID: $id", $_SESSION['UID']);
        return $this->lazyUpdate('users', array('firstname', 'surname', 'user_email', 'user_phone'), array($fname, $sname, $email, $phone), 'user_id', $id);
    }

    function updateAdminPassword($id, $current_pass, $newpassword) {
        $det = $this->simpleLazySelect( 'users', "WHERE USER_ID='$id' AND user_isvisible = 1");
        $rows = count($det);
        if ($rows == 1) {
            $isMatch = $this->validate_password($current_pass, $det[0]['PASSWORD']);
            if (!$isMatch) {
                return false;
            } else {
                return $this->lazyUpdate('users', array('password'), array($this->create_hash($newpassword)), 'user_id', $id);
                $this->Log("Changed Password for user ID: $id", $_SESSION['UID']);
            }
        }
    }

    function verifyEmail($email) {
        $user_emails = $this->complexSelect(array("users"), array("user_email"), "WHERE user_isvisible=1");
        $exist = array();
        foreach ($user_emails as $em) {
            array_push($exist, $em['user_email']);
        }
        if (in_array($_POST['email'], $exist)) {
            return true;
        } else {
            return false;
        }
    }

    function verifyResetHash($hash) {
        $data = $this->simpleLazySelect("acc_recovery", "WHERE ar_hash='$hash'");
        if ($data) {
            //check if hash is expired
            $oldtime = $data[0]['ar_instime'];
            $now = time();
            $timepassed = $now - $oldtime;
            $hrspassed = $timepassed / 3600;
            // print_r($hrspassed);exit;
            if ($hrspassed >= 24) {
                $data_ret = ["status" => 'expired', "user" => $data[0]['ar_uid']];
                return $data_ret;
            } else {
                $data_ret = ["status" => "active", "user" => $data[0]['ar_uid']];
                return $data_ret;
            }
        } else {
            return false;
        }
    }

    function resetPassword($email, $password, $user, $action) {

        switch ($action) {
            case 'send':
                $user = $this->getAdminByEmail($email);
                $userId = $user['user_id'];
                $time = time();
                $hash = md5($time);
                $insert_code = $this->lazyInsert("acc_recovery", array("ar_uid", "ar_hash", "ar_instime"), array($userId, $hash, $time), "");
                if ($insert_code) {
                    try {
                        $mail = new PHPMailer(true); //New instance, with exceptions enabled

                        $body = 'It seems you requested a password reset, If you didn\'t, no problem! Just ignore this email and everything will be fine. 
								If you did, click the following link to change your password.<br><br>';
                        $body .= '<a href="' . $_SERVER['SERVER_NAME'] . '/reset.php?h=' . $hash . '">' . $_SERVER['SERVER_NAME'] . '/reset.php?h=' . $hash . '</a>';

                        $body = preg_replace('/\\\\/', '', $body); //Strip backslashes

                        $mail->IsSendmail();  // tell the class to use Sendmail

                        $mail->AddReplyTo("bkbrainstorm@gmail.com", "Brainstorm");

                        $mail->From = "bkbrainstorm@gmail.com";
                        $mail->FromName = "Brainstorm";

                        $to = $email;

                        $mail->AddAddress($to);

                        $mail->Subject = "Password Reset";

                        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                        $mail->WordWrap = 80; // set word wrap

                        $mail->MsgHTML($body);

                        $mail->IsHTML(true); // send as HTML

                        $mail->Send();
                        $success = ["status" => "success", "message" => "Reset link has been sent to your email."];
                        echo json_encode($success);
                        return true;
                    } catch (phpmailerException $e) {
                        $errors = ["status" => "fail", "message" => $e->errorMessage()];
                        echo json_encode($errors);
                    }
                } else {
                    $error = ["status" => "fail", "msg" => "Something broke down. Please try again"];
                    echo json_encode($error);
                    exit;
                }
                break;
            case 'reset':
                $reset = $this->lazyUpdate('users', array('password'), array($this->create_hash($password)), 'user_id', $user);
                if ($reset) {
                    $this->Log("Changed Password for user ID: $user", $_SESSION['UID']);
                    $this->lazyDelete("acc_recovery", "ar_uid", $user);
                    $success = ["status" => "success", "message" => "Password changed!"];
                    echo json_encode($success);
                    return $reset;
                } else {
                    $error = ["status" => "fail", "msg" => "Could not change password. Please try again"];
                    echo json_encode($error);
                    return false;
                    exit;
                }
                break;
        }
    }

    function deleteAdmin($id) {
        return $this->lazyUpdate('users', array('user_isvisible'), array(0), 'user_id', $id);
    }
    //Change made by Brian on 22/05/2016
    function getAdminByRole($roleID){
        return $this->simpleLazySelect("users", "where AR_ID = $roleID and USER_ISVISIBLE = 1");
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
    //Added by Brian 14/07/2016
    function loginLog(){
        return $this->lazyInsert("auth_sessions", array("USER_ID","USER_IP","USER_LOGINTIME","AS_STATUS"), array($_SESSION['UID'],$_SERVER['REMOTE_ADDR'],  $this->DBdate,1));
    }
    

    function getAllRoles() {
        //deprecated
        return $this->simpleLazySelect('group_permissions', null);
    }

    function getPageLink() {
        //   http://localhost/cicorangewtool/newpermission.php
        $string = explode("/", $_SERVER['REQUEST_URI']);
        $count = count($string);
        $desired = $count - 1;
        $final = explode('&', $string[$desired]);
        return $final[0];
    }

    function getScriptname($link) {
        $string = explode("/", $link);
        $count = count($string);
        $desired = $count - 1;
        $final = explode('?', $string[$desired]);
        return $final[0];
    }

    function wtf($file) {
        return $this->simpleLazySelect("auth_permissions", "where ap_link = '$file'");
    }

    function checkPage($filename) {
        $alternate = $this->getScriptname($filename);
        $count = $this->simpleLazySelect("auth_permissions", "where ap_link = '$filename'");
        $page = @$count[0]['AP_LINK'];
        if ($page == $filename) {
            return @$count[0]['AP_ID'];
        } else {
            return @$this->checkPageUsingName($alternate);
        }
    }

    function checkPageUsingName($alternate) {
        $count = $this->simpleLazySelect("auth_permissions", "where ap_link = '$alternate'");
        $page = $count[0]['AP_LINK'];
        if ($page == $alternate) {
            return $count[0]['AP_ID'];
        } else {
            return 0;
        }
    }

    function checkUserPermission($permID, $userid) {
        $perm = $this->simpleLazySelect("user_permissions", "where AP_ID = $permID and USER_ID = $userid");
        if (@$perm[0]['AP_ID'] == $permID) {
            return true;
        } else {
            return 0;
        }
    }

    function getMenuModules($roleID) {
        /* SELECT * 
          FROM auth_modules
          LEFT JOIN auth_menu ON auth_menu.am_id = auth_modules.am_id
          WHERE auth_menu.menu_name IS NOT NULL
          GROUP BY auth_modules.am_name */
        return @$this->simpleLazySelect("auth_modules m", "LEFT JOIN auth_menu ON auth_menu.am_id = m.am_id LEFT JOIN auth_permissions on m.am_id = auth_permissions.am_id LEFT JOIN user_permissions ON auth_permissions.ap_id = user_permissions.ap_id
WHERE user_permissions.user_id = $roleID and auth_menu.menu_name IS NOT NULL and m.am_isvisible = 1
GROUP BY m.am_name ORDER BY m.am_priority ASC");
    }

    function getMenuItems($moduleID) {
        return $this->simpleLazySelect("auth_permissions ap", "INNER JOIN auth_menu am ON ap.AP_ID = am.AP_ID WHERE am.AM_ID = $moduleID and am.menu_isvisible = 1 ORDER BY am.MENU_ORDER ASC");

        // return @$this->complexSelect(array("auth_menu", "auth_permissions"),array("*"),"where auth_menu.am_id = $moduleID and auth_permissions.ap_id = auth_menu.ap_id");
    }

    function getMenu() {
        $menu = '<ul class="navigation">';
        $menu .='<li>
					<a href="index.php"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text">Dashboard</span></a>
				</li>';
        $modes = array();
        $count = array();
        $modes = @$this->getMenuModules($_SESSION['TYPE']);
        if (!empty($modes)) {
            @$roleID = $this->getRoleById($_SESSION['TYPE']);
            foreach (@$modes as $modules) {
                if ($roleID['AG_ID'] == $modules['AG_ID']) {
                    $menu .= "<li class='mm-dropdown'><a href='#'><i class='menu-icon fa " . $modules['AM_ICON'] . "'></i> <span class='mm-text'>" . $modules['AM_NAME'] . "</span></a>";
                    @$count = $this->getMenuItems($modules['AM_ID']);
                    if ($count) {
                        $menu .= "<ul>";
                        foreach ($count as $items) {
                            if ($this->checkUserPermission($items['AP_ID'], $_SESSION['TYPE'])) {
                                $menu .= "<li><a href='" . $items['AP_LINK'] . "'><span class='mm-text'>" . $items['MENU_NAME'] . "</span></a></li>";
                            }
                        }
                        $menu .= "</ul>";
                    }
                }
                $menu .= "</li>";
            }
            $menu .= "</ul>";
        }
        return $menu;
    }
    function getMenuSort() {
        $menu = '<ul class="reorder-menu">';
        $menu .='<div id="ui-accordion">';
        $modes = array();
        $count = array();
        $modes = @$this->getMenuModules($_SESSION['TYPE']);
        if (!empty($modes)) {
            @$roleID = $this->getRoleById($_SESSION['TYPE']);
            foreach (@$modes as $modules) {
                if ($roleID['AG_ID'] == $modules['AG_ID']) {
                    
                    $menu .= "<div class='group top-level' ><li class='mm-dropdown top-level' id='".$modules['AM_ID']."'><a href='#'><h3><i class='menu-icon fa " . $modules['AM_ICON'] . "'></i> <span class='mm-text'>" . $modules['AM_NAME'] . "</span></h3></a>";
                    $menu .="<div>";
                    @$count = $this->getMenuItems($modules['AM_ID']);
                    if ($count) {
                        $menu .= "<ul class='inner-group'>";
                        foreach ($count as $items) {
                            if ($this->checkUserPermission($items['AP_ID'], $_SESSION['TYPE'])) {
                                $menu .= "<li class='low-level' id='" . $items['MENU_ID'] . "'><a href=''><span class='mm-text'>" . $items['MENU_NAME'] . "</span></a></li>";
                            }
                        }
                        $menu .= "</ul>";
                    }
                }
                $menu .= "</div></li><hr/></div>";
            }
            $menu .= "</div></ul>";
        }
        return $menu;
    }
    function updateModuleOrder($order,$id){
        return $this->lazyUpdate("auth_modules", array("AM_PRIORITY"), array($order), "AM_ID", $id);
    }
    function updateMenuOrder($order,$id){
        return $this->lazyUpdate("auth_menu", array("MENU_ORDER"), array($order), "MENU_ID", $id);
    }
    
    function getAllMenusAndModules(){
        return $this->simpleLazySelect('auth_menu, auth_modules', 
                "where auth_menu.MENU_ISVISIBLE = 1 "
                . "and auth_modules.AM_ID = auth_menu.AM_ID "
                . "and auth_modules.AM_ISVISIBLE = 1");
    }
    
    function getSystemPermissions(){
        return $this->simpleLazySelect('auth_permissions, auth_modules', 'WHERE auth_permissions.AP_ISVISIBLE = 1 and auth_modules.AM_ISVISIBLE = 1 and auth_permissions.AM_ID= auth_modules.AM_ID');
    }
    ########################################### ##Password Generation####################################

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
    function validate(){
        
    }

// Compares two strings $a and $b in length-constant time.
    function slow_equals($a, $b) {
        $diff = strlen($a) ^ strlen($b);
        for ($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $diff === 0;
    }

    /*
     * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
     * $algorithm - The hash algorithm to use. Recommended: SHA256
     * $password - The password.
     * $salt - A salt that is unique to the password.
     * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
     * $key_length - The length of the derived key in bytes.
     * $raw_output - If true, the key is returned in raw binary format. Hex encoded otherwise.
     * Returns: A $key_length-byte key derived from the password and salt.
     *
     * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
     *
     * This implementation of PBKDF2 was originally created by https://defuse.ca
     * With improvements by http://www.variations-of-shadow.com
     */

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

############################################End of Password Generation#############################################################
###############Authentication starts here 13/01/2014########################
//Auth groups

    function setGroup($groupName, $groupDesc) {
        $insert = $this->lazyInsert("auth_groups", array("AG_NAME", "AG_DESCRIPTION", "AG_DATE"), array($groupName, $groupDesc, $this->DBdate), "auth_groups_seq");
        if ($insert) {
            return $insert;
        } else {
            return false;
        }
    }

    function editGroup($groupID, $groupName, $groupDesc) {
        if ($this->lazyUpdate("auth_groups", array("AG_NAME", "AG_DESCRIPTION"), array($groupName, $groupDesc), "AG_ID", $groupID)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteGroup($groupID) {
        if ($this->lazyUpdate("auth_groups", array("AG_ISVISIBLE"), array(0), "AG_ID", $groupID)) {
            return true;
        } else {
            return false;
        }
    }

    function getGroups() {
        return $this->simpleLazySelect("auth_groups", "where ag_isvisible = 1");
    }
    function getDepartments() {
        return $this->simpleLazySelect("tb_hur_department", "where active = 1");
    }


    function getGroupByID($id) {
        $group = $this->simpleLazySelect("auth_groups", "where ag_id = $id");
        return @$group[0];
    }

    //Auth Modules
    function setModule($groupID, $modName, $modIcon) {
        $insert = $this->lazyInsert('auth_modules', array("AG_ID", "AM_NAME", "AM_ICON", "AM_DATE"), array($groupID, $modName, $modIcon, $this->DBdate), "auth_modules_seq");
        if ($insert) {
            $this->Log("Created module ID $insert Name: $modName", $_SESSION['UID']);
            return $insert;
        } else {
            return false;
        }
    }

    function editModule($moduleID, $groupID, $modName, $modIcon) {
        if ($this->lazyUpdate("auth_modules", array("AG_ID", "AM_NAME", "AM_ICON"), array($groupID, $modName, $modIcon), "AM_ID", $moduleID)) {
            $this->Log("Updated $moduleID. ", $_SESSION['UID']);
            return true;
        } else {
            return false;
        }
    }

    function deleteModule($moduleID) {
        if ($this->lazyUpdate("auth_modules", array("AM_ISVISIBLE"), array(0), "AM_ID", $moduleID)) {
            $this->Log("Deleted module ID $moduleID", $_SESSION['UID']);
            return true;
        } else {
            return false;
        }
    }

    function getModules() {
        return $this->simpleLazySelect("auth_modules", "where am_isvisible = 1");
    }

    function getModuleById($id) {
        $mod = $this->simpleLazySelect("auth_modules", "where am_id = $id");
        return @$mod[0];
    }

    //permissions
    function setPermissions($permName, $moduleId, $page) {
        $insert = $this->lazyInsert('auth_permissions', array('AM_ID', 'AP_NAME', 'AP_LINK', 'AP_DATE'), array($moduleId, $permName, $page, $this->DBdate), 'auth_permissions_seq');
        if ($insert)
            return $insert;
        else
            return false;
    }

    function editPermission($permID, $permName, $moduleId, $page) {
        if ($this->lazyUpdate("auth_permissions", array('AM_ID', 'AP_NAME', 'AP_LINK'), array($moduleId, $permName, $page), "ap_id", $permID)) {
            return true;
        } else {
            return false;
        }
    }

    function deletePermission($id) {
        if ($this->lazyUpdate("auth_permissions", array("AP_ISVISIBLE"), array(0), "AP_ID", $id)) {
            return true;
        } else {
            return false;
        }
    }

    function getPermissions() {
        return $this->simpleLazySelect("auth_permissions", "where ap_isvisible = 1");
    }

    function getPermissionById($id) {
        $perm = $this->simpleLazySelect("auth_permissions", "where AP_ID = $id");
        return @$perm[0];
    }

    function getUserRoles($Groupid) {
        /* SELECT * 
          FROM  `auth_modules` ,  `auth_permissions`
          WHERE auth_modules.AM_ID = auth_permissions.AM_ID
          AND auth_modules.AG_ID =2 */
        return $this->complexSelect(array('auth_modules', 'auth_permissions'), array("*"), "where auth_modules.AM_ID = auth_permissions.AM_ID
AND auth_modules.AG_ID = $Groupid and auth_modules.AM_ISVISIBLE = 1");
    }

    function getAllUserpermissions() {
        return $this->complexSelect(array('auth_modules', 'auth_permissions'), array("*"), "where auth_modules.AM_ID = auth_permissions.AM_ID and auth_modules.AM_ISVISIBLE = 1");
    }

    function getUserAssignedPermissions($id) {
        return @$this->simpleLazySelect('user_permissions', "where user_id = $id");
    }

    ##############Menus##################

    function setMenu($moduleID, $permID, $menuName) {
        $insert = $this->lazyInsert("auth_menu", array("AM_ID", "AP_ID", "MENU_NAME", "MENU_DATE"), array($moduleID, $permID, $menuName, $this->DBdate), "auth_menu_seq");
        if ($insert)
            return $insert;
        else
            return false;
    }

    function editMenu($menuID, $moduleID, $permID, $menuName) {
        if ($this->lazyUpdate("auth_menu", array("AM_ID", "AP_ID", "MENU_NAME"), array($moduleID, $permID, $menuName), "MENU_ID", $menuID)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteMenu($id) {
        if ($this->lazyUpdate("auth_menu", array("MENU_ISVISIBLE"), array(0), "MENU_ID", $id)) {
            return true;
        } else {
            return false;
        }
    }

    function showMenu() {
        return $this->simpleLazySelect("auth_menu", "where menu_isvisible = 1");
    }

    function showMenuById($id) {
        $menu = $this->simpleLazySelect("auth_menu", "where menu_id = $id");
        return @$menu[0];
    }

    function showModulePage($moduleID) {
        return @$this->simpleLazySelect("auth_permissions", "where am_id = $moduleID");
    }

    #######################Roles################

    function set_role_ID($groupId, $rolename, $roleDesc) {
        $insert = $this->lazyInsert("auth_roles", array("AG_ID", "AR_NAME", "AR_DESC", "AR_DATE"), array($groupId, $rolename, $roleDesc, $this->DBdate), 'auth_roles_seq');
        if ($insert) {
            $this->Log("created role ID $insert", $_SESSION['UID']);
            return $insert;
        } else {
            return false;
        }
    }

    function edit_role_ID($roleId, $rolename, $roleDesc) {
        return $this->lazyUpdate("auth_roles", array("AR_NAME", "AR_DESC"), array($rolename, $roleDesc), "AR_ID", $roleId);
    }

    function delete_role_ID($roleId) {
        return $this->lazyUpdate("auth_roles", array("AG_ISVISIBLE"), array(0), "AR_ID", $roleId);
    }

    function getRoleIDs() {
        return $this->simpleLazySelect("auth_roles", "where ar_isvisible = 1");
    }

    function getRoleById($id) {
        $data = $this->simpleLazySelect("auth_roles", "where ar_id = '$id'");
        return @$data[0];
    }

    function getRolesByGroup($id) {
        return $this->simpleLazySelect("auth_roles", "where ar_isvisible = 1 and ag_id = $id");
    }

    function deleteRole($roleID) {
        if ($this->lazyUpdate("auth_roles", array("AR_ISVISIBLE"), array(0), "AR_ID", $roleID)) {
            return true;
        } else {
            return false;
        }
    }
    

}

?>