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

class UserController extends Controller
{
    public $base_url = "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/User/";
    public function actionGetUserInfoByMobile()
    {
        $request = Yii::$app->request;
        $mobile = null;
        if ($request->isGet) {
            echo "get" . $mobile;
            $mobile = $request->get("mobile");
        }
        else if ($request->isPost) {
            $post = $_POST;
            echo json_encode($post);
//            $response = Yii::$app->response;
//            $response->setStatusCode(200);
//            $response->content = json_encode($post);
//            $response->send();
//            return;
            $mobile = $request->post("mobile");
//            echo "post" . $mobile;
//            echo "post" . $mobile;
        }
        else {
            echo "others";
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        if ($mobile == null) {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "No mobile value.";
            $response->send();
            return;
        }


        $user = UserManager::getUserByMobile($mobile);
        if ($user == null) {
            $user = UserManager::createUser($mobile);
        }
        UserManager::inactiveUser($user);
        $user_json = UserManager::encodeUser($user);
        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = $user_json;
        $response->send();

    }

    public function actionUpdateUserInfo() {
        $request = Yii::$app->request;
        $mobile = null;
        $traffic = null;
        if ($request->isPost) {
            $mobile = $request->post("mobile");
            $traffic = $request->post("traffic");
        }
        else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        $user = UserManager::getUserByMobile($mobile);
        UserManager::resetTraffic($user, $traffic);
        UserManager::flushTraffic($user);
        UserManager::activeUser($user);

        $user_json = UserManager::encodeUser($user);
        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = $user_json;
        $response->send();
    }



}