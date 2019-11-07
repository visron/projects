<?php


class Subscribers extends DBConn{
    //put your code here
    function getAllSubscribers() {
        $val = $this->simpleLazySelect('usersuscriptions', 'where SUS_STATUS=1');
        return @$val[0];
    }
}
