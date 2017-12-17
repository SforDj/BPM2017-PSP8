<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/15
 * Time: 0:24
 */

namespace app\controllers;


use function GuzzleHttp\Psr7\str;

use Yii;
use yii\web\Controller;
use yii\web\JsonParser;
//require "UserController.php";
include "../models/manager/UserManager.php";
include "../models/model/User.php";
use UserManager;
use User;
//use UserManager;

class UserController extends Controller
{
    public $base_url = "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/User/";
    public function actionGetUserInfoByMobile()
    {
        $request = Yii::$app->request;
        $mobile = null;
        if ($request->isGet)
            $mobile = $request->get("mobile");
        elseif ($request->isPost)
            $mobile = $request->post("mobile");
        else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        $user = UserManager::getUserByMobile($mobile);
        if ($user == null) {
            $user = UserManager::createUser($mobile);
        }

        $user_json = UserManager::encodeUser($user);
        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = $user_json;
        $response->send();



//        $url = $this->base_url . "?User.mobile=" . $mobile;
//        //check if user has been in our database
//        $ch_to_get = curl_init();
//        curl_setopt($ch_to_get, CURLOPT_URL, $url);
//        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);
//        $data_str = curl_exec($ch_to_get);
//        curl_close($ch_to_get);
//        //if $data_str == "{}", return $data; else to create user and return.
//
//        if ($data_str == "{}") {
//            $ch_to_create = curl_init();
//            $url = $this->base_url;
//
//            $post_data = json_encode(array(
//                'mobile'=>(string)$mobile,
//                'traffic'=>100.0,
//                'telefee'=>0.0,
//                'cash'=>0.0
//            ));
//            $header = array(
//                'Content-Type: application/json; charset=utf-8',
//                'Content-Length:' . strlen($post_data)
//            );
//
//
//            curl_setopt($ch_to_create, CURLOPT_URL, $this->base_url);
//            curl_setopt($ch_to_create, CURLOPT_POST, true);
//            curl_setopt($ch_to_create, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch_to_create, CURLOPT_HTTPHEADER, $header);
//            curl_setopt($ch_to_create, CURLOPT_POSTFIELDS, $post_data);
//            curl_setopt($ch_to_create, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($ch_to_create, CURLOPT_HEADER, 0);
//
//            $data_str = curl_exec($ch_to_create);
//            curl_close($ch_to_create);
//
//            $data = json_decode($data_str);
//            $data_str = json_encode(array(
//                "User"=>array(
//                    "id"=>$data->id,
//                    "mobile"=>$data->mobile,
//                    "traffic"=>$data->traffic,
//                    "telefee"=>$data->telefee,
//                    "cash"=>$data->cash
//                )
//            ));
//        }
//
//        else{
//            $data = json_decode($data_str);
//            $data_str = json_encode(array(
//                "User"=>array(
//                    "id"=>$data->User[0]->id,
//                    "mobile"=>$data->User[0]->mobile,
//                    "traffic"=>$data->User[0]->traffic,
//                    "telefee"=>$data->User[0]->telefee,
//                    "cash"=>$data->User[0]->cash
//                )
//            ));
//        }
//
//        $response = Yii::$app->response;
//        $response->setStatusCode(200);
//        $response->content = $data_str;
//        $response->send();

    }

    public function actionAddResource() {
        $request = Yii::$app->request;
        $mobile = null;
        $traffic = null;
        $telefee = null;
        $cash = null;
        if ($request->isGet) {
            $mobile = $request->get("mobile");
            $traffic = $request->get("traffic");
            $telefee = $request->get("telefee");
            $cash = $request->get("cash");
        }

        elseif ($request->isPost){
            $mobile = $request->post("mobile");
            $traffic = $request->post("traffic");
            $telefee = $request->post("telefee");
            $cash = $request->post("cash");
        }
        else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }







    }



}