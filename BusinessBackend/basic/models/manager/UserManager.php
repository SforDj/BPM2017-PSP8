<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/16
 * Time: 22:58
 */

class UserManager
{
    public static $basic_url = "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/User/";

    public static function createUser($mobile) {

        $post_data = json_encode(array(
            "mobile"=>$mobile,
            "traffic"=>100.0,
            "telefee"=>0.0,
            "cash"=>0.0,
            "active"=>1,
            "tradelay"=>0.0
        ));

        $ch_to_create = curl_init();
        $header = array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length:' . strlen($post_data)
        );

        curl_setopt($ch_to_create, CURLOPT_URL, UserManager::$basic_url);
        curl_setopt($ch_to_create, CURLOPT_POST, true);
        curl_setopt($ch_to_create, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_create, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_to_create, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch_to_create, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_create);
        curl_close($ch_to_create);

        $ret_data = json_decode($ret_str);
        $user = new User($ret_data->id, $ret_data->mobile, $ret_data->traffic, $ret_data->telefee, $ret_data->cash,
            $ret_data->active, $ret_data->tradelay);

        return $user;
    }

    public static function getUserByMobile($mobile) {
        $url = self::$basic_url . "?User.mobile=" . $mobile;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);
        if ($ret_str == "{}")
            return null;

        $ret_data = json_decode($ret_str);
        $data_entry = $ret_data->User[0];
        $user = new User($data_entry->id, $data_entry->mobile, $data_entry->traffic, $data_entry->telefee,
            $data_entry->cash, $data_entry->active, $data_entry->tradelay);

        return $user;
    }

    public static function getUserById($id) {
        $url = self::$basic_url . $id;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);
        $data_entry = $ret_data;
        $user = new User($data_entry->id, $data_entry->mobile, $data_entry->traffic, $data_entry->telefee,
            $data_entry->cash, $data_entry->active, $data_entry->tradelay);

        return $user;
    }

    public static function addAsset(User &$user, $traffic_delay = 0.0, $telefee = 0.0, $cash = 0.0) {
        $traffic_delay_now = $user->getTradelay();
        $telefee_now = $user->getTelefee();
        $cash_now = $user->getCash();
        $traffic_delay_now += $traffic_delay;
        $telefee_now += $telefee;
        $cash_now += $cash;
        $user->setTradelay($traffic_delay_now);
        $user->setTelefee($telefee_now);
        $user->setCash($cash_now);
    }

    public static function flushTraffic(User &$user) {
        $traffic_delay = $user->getTradelay();
        $traffic = $user->getTraffic();
        $traffic += $traffic_delay;
        $traffic_delay = 0.0;
        $user->setTraffic($traffic);
        $user->setTradelay($traffic_delay);
    }

    public static function resetTraffic(User &$user, $traffic) {
        $user->setTraffic($traffic);
    }


    public static function activeUser(User &$user) {
        $user->setActive(1);
    }

    public static function inactiveUser(user &$user) {
        $user->setActive(0);
    }

    public static function updateUser(User $user){
        $id = $user->getId();
        $url = self::$basic_url . $id;

        $post_data = self::encodeUser($user);

        $ch_update = curl_init();
        $header = array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length:' . strlen($post_data)
        );

        curl_setopt($ch_update, CURLOPT_URL, $url);
        curl_setopt($ch_update, CURLOPT_CUSTOMREQUEST, "put");
        curl_setopt($ch_update, CURLOPT_HEADER,false);
        curl_setopt($ch_update, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_update, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch_update, CURLOPT_POSTFIELDS, $post_data);
        $ret_str = curl_exec($ch_update);
        curl_close($ch_update);

        $ret_data = json_decode($ret_str);
        $user = new User($ret_data->id, $ret_data->mobile, $ret_data->traffic, $ret_data->telefee, $ret_data->cash,
            $ret_data->active, $ret_data->tradelay);

        return $user;
    }


    public static function encodeUser(User $user)
    {
        $user_array = self::object_to_array($user);
        $str_encoded = json_encode($user_array);
        return $str_encoded;
    }

    public static function object_to_array(User $user){

        $ret = array(
            "id"=>$user->getId(),
            "mobile"=>$user->getMobile(),
            "traffic"=>$user->getTraffic(),
            "telefee"=>$user->getTelefee(),
            "cash"=>$user->getCash(),
            "active"=>$user->getActive(),
            "tradelay"=>$user->getTradelay()
        );
        return $ret;
    }




}