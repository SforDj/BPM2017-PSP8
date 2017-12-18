<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/17
 * Time: 13:08
 */

class AdvertiseManager
{
    public static $basic_url = "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/Advertise/";

    public static function createAdvertise($name, $picurl) {

        $post_data = json_encode(array(
            "name"=>$name,
            "picurl"=>$picurl
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
        $advertise = new Advertise($ret_data->id, $ret_data->name, $ret_data->picurl);

        return $advertise;
    }

    public static function getAdvertiseByName($name) {
        $url = self::$basic_url . "?Advertise.name=" . $name;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);
        $data_entry = $ret_data->User[0];
        $advertise = new Advertise($data_entry->id, $data_entry->name, $data_entry->picurl);

        return $advertise;
    }

    public static function getAdvertiseById($id) {
        $url = self::$basic_url . "?Advertise.id=" . $id;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);
        $data_entry = $ret_data;
        $advertise = new Advertise($data_entry->id, $data_entry->name, $data_entry->picurl);

        return $advertise;
    }

    public static function encodeAdvertise(Advertise $advertise)
    {
        $advertise_array = self::object_to_array($advertise);
        $str_encoded = json_encode($advertise_array);
        return $str_encoded;
    }

    public static function object_to_array(Advertise $advertise){
        $ret = array(
            "id"=>$advertise->getId(),
            "name"=>$advertise->getName(),
            "picurl"=>$advertise->getPicurl()
        );
        return $ret;
    }


}