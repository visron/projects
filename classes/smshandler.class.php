<?php

include_once('DBConn.class.php');


class smshandler extends DBConn {
	function recordsms($number,$status,$message,$cost,$messageId)
	{
		$val = $this->lazyInsert('smsrecords',
		 array('SMS_PHONENUMBER', 'API_STATUS', 'SMS_BODY','SMS_COST', 'SMS_SENDERID','SMS_DATE'),
		 array($number,$status,$message,$cost,$messageId, $this->DBdate));
        return $val;
	}

}
