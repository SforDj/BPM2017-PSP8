<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/15
 * Time: 0:24
 */

namespace app\controllers;


use function GuzzleHttp\Psr7\str;

use function PHPSTORM_META\type;
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
    public function actionGetUserInfoByMobile()
    {
        $request = Yii::$app->request;
        $mobile = null;
        if ($request->isGet) {
            $mobile = $request->get("mobile");
        }
        else if ($request->isPost) {
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $param = json_decode($body);
            $mobile = $param->mobile;
        }
        else {
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
        $user = UserManager::updateUser($user);
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
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $params = json_decode($body);
            $mobile = $params->mobile;
            $traffic = $params->traffic;
        }
        else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        if ($mobile == null || $traffic == null) {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "No param value.";
            $response->send();
            return;
        }

        $user = UserManager::getUserByMobile($mobile);
        UserManager::resetTraffic($user, $traffic);
        UserManager::flushTraffic($user);
        UserManager::activeUser($user);
        $user = UserManager::updateUser($user);

        $user_json = UserManager::encodeUser($user);
        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = $user_json;
        $response->send();
    }

    public function actionUpdateAndGetUserInfo() {
        $request = Yii::$app->request;
        $mobile = null;
        $traffic = null;
        if ($request->isPost) {
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $params = json_decode($body);
            $mobile = $params->mobile;
            $traffic = $params->traffic;
        }
        else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        if ($mobile == null || $traffic == null) {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "No param value.";
            $response->send();
            return;
        }

        $user = UserManager::getUserByMobile($mobile);
        UserManager::resetTraffic($user, $traffic);
        UserManager::flushTraffic($user);
        $user = UserManager::updateUser($user);

        $user_json = UserManager::encodeUser($user);
        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = $user_json;
        $response->send();
    }



    public function actionSendReward() {
        $request = Yii::$app->request;
        $mobile = null;
        $rewardtype = null;
        $reward = null;
        if ($request->isPost) {
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $params = json_decode($body);
            $rewardtype = $params->rewardtype;
            $reward = $params->reward;
            $mobile = $params->mobile;
        }
        $user = UserManager::getUserByMobile($mobile);

        switch ($rewardtype){
            case 0:
                UserManager::addAsset($user, $reward, 0, 0);
                break;
            case 1:
                UserManager::addAsset($user, 0, $reward, 0);
                break;
            case 2:
                UserManager::addAsset($user, 0, 0, $reward);
                break;
            case 3:
                UserManager::addAsset($user, 0, 0, $reward);
                break;
            default:
                break;
        }

        $user = UserManager::updateUser($user);
        $user_json = UserManager::encodeUser($user);
        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = $user_json;
        $response->send();
    }




}