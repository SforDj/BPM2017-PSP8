<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/20
 * Time: 2:03
 */

namespace app\controllers;


use function PHPSTORM_META\type;
use Yii;
use yii\db\TableSchema;
use yii\web\Controller;

include "../models/manager/UserManager.php";
include "../models/manager/TaskManager.php";
include "../models/manager/QuestionManager.php";
include "../models/manager/LabelManager.php";
include "../models/model/Task.php";
include "../models/model/Question.php";
include "../models/model/Quesques.php";
include "../models/model/Label.php";
include "../models/model/Labelques.php";
include "../models/model/User.php";
include "../models/model/Taskitem.php";
use TaskManager;
use QuestionManager;
use LabelManager;
use UserManager;
use Task;
use Taskitem;
use Question;
use Quesques;
use Label;
use Labelques;
use User;

class CenterController extends Controller
{
    public function actionGetUserInfoByMobile() {
        $request = Yii::$app->request;
        $mobile = null;
        if ($request->isGet) {
            $mobile = intval($request->get("mobile"));
        }
        elseif ($request->isPost) {
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $param = json_decode($body);
            $mobile = intval($param->mobile);
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

    public function actionGetMyTaskitemByMobileAndState() {
        $request = Yii::$app->request;
        $mobile = null;
        $state = null;
        if ($request->isGet) {
            $mobile = intval($request->get("mobile"));
            $state = intval($request->get("state"));
        }
        elseif ($request->isPost) {
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $param = json_decode($body);
            $mobile = intval($param->mobile);
            $state = intval($param->state);
        }
        else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        $user = UserManager::getUserByMobile($mobile);
        $taskitems = TaskManager::getTaskitemByUseridAndState($user->getId(), $state);
        $task_array = array();
        foreach ($taskitems as $taskitem) {
            $taskid = $taskitem->getTaskid();
            $task = TaskManager::getTaskById($taskid);
//            $task = TaskManager::task_to_array($task);
            array_push($task_array, $task);
        }
        $taskitems = TaskManager::taskitemAndTaskArray_to_array($taskitems, $task_array);
        $ret_data = json_encode(array(
            "taskitem"=>$taskitems
        ), JSON_UNESCAPED_UNICODE);

        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = $ret_data;
        $response->send();
        return;
    }

    public function actionGetMyTaskitemByState() {
        $request = Yii::$app->request;
        $state = null;
        if ($request->isGet) {
            $state = intval($request->get("state"));
        }
        elseif ($request->isPost) {
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $param = json_decode($body);
            $state = intval($param->state);
        }
        else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        $taskitems = TaskManager::getTaskitemByState($state);
        $task_array = array();
        foreach ($taskitems as $taskitem) {
            $taskid = $taskitem->getTaskid();
            $task = TaskManager::getTaskById($taskid);
//            $task = TaskManager::task_to_array($task);
            array_push($task_array, $task);
        }
        $taskitems = TaskManager::taskitemAndTaskArray_to_array($taskitems, $task_array);
        $ret_data = json_encode(array(
            "taskitem"=>$taskitems
        ), JSON_UNESCAPED_UNICODE);

        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = $ret_data;
        $response->send();
        return;
    }


    public function actionGetReward() {
        $request = Yii::$app->request;
        $taskitemid = null;
        if ($request->isGet) {
            $taskitemid = intval($request->get("taskitemid"));
        }
        elseif ($request->isPost) {
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $param = json_decode($body);
            $taskitemid = intval($param->taskitemid);
        }
        else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        $taskitem = TaskManager::getTaskitemById($taskitemid);
        $task = TaskManager::getTaskById($taskitem->getTaskid());
        $user = UserManager::getUserById($taskitem->getUserid());

        $reward_type = $task->getRewardtype();
        $type = $task->getType();

        switch ($type) {
            case 0:
                switch ($reward_type) {
                    case 0:
                        $reward = $task->getReward();
                        UserManager::addAsset($user, $reward, 0, 0);
                        TaskManager::rewardGotTaskitem($taskitem);
                        UserManager::updateUser($user);
                        TaskManager::updateTaskitem($taskitem);
                        TaskManager::updateTask($task);
                        $response = Yii::$app->response;
                        $response->setStatusCode(200);
                        $response->content = json_encode(array(
                            "state" => 1
                        ));
                        $response->send();
                        return;
                    case 1:
                        $reward = $task->getReward();
                        UserManager::addAsset($user, 0, $reward, 0);
                        TaskManager::rewardGotTaskitem($taskitem);
                        UserManager::updateUser($user);
                        TaskManager::updateTaskitem($taskitem);
                        TaskManager::updateTask($task);
                        $response = Yii::$app->response;
                        $response->setStatusCode(200);
                        $response->content = json_encode(array(
                            "state" => 1
                        ));
                        $response->send();
                        return;
                    case 2:
                        $reward = $task->getReward();
                        UserManager::addAsset($user, 0, 0, $reward);
                        TaskManager::rewardGotTaskitem($taskitem);
                        UserManager::updateUser($user);
                        TaskManager::updateTaskitem($taskitem);
                        TaskManager::updateTask($task);
                        $response = Yii::$app->response;
                        $response->setStatusCode(200);
                        $response->content = json_encode(array(
                            "state" => 1
                        ));
                        $response->send();
                        return;
                    case 3:
                        if ($request->isGet) {
                            $reward = $request->get("reward");
                        }
                        elseif ($request->isPost) {
                            $body = trim($request->getRawBody(), '"');
                            $body = stripslashes($body);
                            $param = json_decode($body);
                            $reward = doubleval($param->reward);
                        }
                        else
                            $reward = 0;

                        UserManager::addAsset($user, 0, 0, $reward);
                        TaskManager::rewardGotTaskitem($taskitem);
                        UserManager::updateUser($user);
                        TaskManager::updateTaskitem($taskitem);
                        TaskManager::updateTask($task);
                        $response = Yii::$app->response;
                        $response->setStatusCode(200);
                        $response->content = json_encode(array(
                            "state" => 1
                        ));
                        $response->send();
                        return;

                    default:
                        $response = Yii::$app->response;
                        $response->setStatusCode(200);
                        $response->content = "Unexpected Error in Task Reward Type.";
                        $response->send();
                        return;
                }
                break;
            case 1:
                switch ($reward_type) {
                    case 0:
                        $reward = $task->getReward();
                        $label_meta = LabelManager::getLabelMetaByTaskid($taskitem->getTaskid());
                        $rangestart = $taskitem->getRangestart();
                        $rangeend = $taskitem->getRangeend();
                        $total = $label_meta->getCount();
                        $ratio = ($rangeend - $rangestart) * 1.0 / $total;
                        $reward = $reward * $ratio;
                        UserManager::addAsset($user, $reward, 0, 0);
                        TaskManager::substractReward($task, $reward);
                        TaskManager::rewardGotTaskitem($taskitem);
                        UserManager::updateUser($user);
                        TaskManager::updateTaskitem($taskitem);
                        TaskManager::updateTask($task);
                        $response = Yii::$app->response;
                        $response->setStatusCode(200);
                        $response->content = json_encode(array(
                            "state" => 1
                        ));
                        $response->send();
                        return;
                    case 1:
                        $reward = $task->getReward();
                        $label_meta = LabelManager::getLabelMetaByTaskid($taskitem->getTaskid());
                        $rangestart = $taskitem->getRangestart();
                        $rangeend = $taskitem->getRangeend();
                        $total = $label_meta->getCount();
                        $ratio = ($rangeend - $rangestart) * 1.0 / $total;
                        $reward = $reward * $ratio;
                        UserManager::addAsset($user, 0, $reward, 0);
                        TaskManager::substractReward($task, $reward);
                        TaskManager::rewardGotTaskitem($taskitem);
                        UserManager::updateUser($user);
                        TaskManager::updateTaskitem($taskitem);
                        TaskManager::updateTask($task);
                        $response = Yii::$app->response;
                        $response->setStatusCode(200);
                        $response->content = json_encode(array(
                            "state" => 1
                        ));
                        $response->send();
                        return;
                    case 2:
                        $reward = $task->getReward();
                        $label_meta = LabelManager::getLabelMetaByTaskid($taskitem->getTaskid());
                        $rangestart = $taskitem->getRangestart();
                        $rangeend = $taskitem->getRangeend();
                        $total = $label_meta->getCount();
                        $ratio = ($rangeend - $rangestart) * 1.0 / $total;
                        $reward = $reward * $ratio;
                        UserManager::addAsset($user, 0, 0, $reward);
                        TaskManager::substractReward($task, $reward);
                        TaskManager::rewardGotTaskitem($taskitem);
                        UserManager::updateUser($user);
                        TaskManager::updateTaskitem($taskitem);
                        TaskManager::updateTask($task);
                        $response = Yii::$app->response;
                        $response->setStatusCode(200);
                        $response->content = json_encode(array(
                            "state" => 1
                        ));
                        $response->send();
                        return;
                    case 3:
                        if ($request->isGet) {
                            $reward = $request->get("reward");
                        }
                        elseif ($request->isPost) {
                            $body = trim($request->getRawBody(), '"');
                            $body = stripslashes($body);
                            $param = json_decode($body);
                            $reward = doubleval($param->reward);
                        }
                        else
                            $reward = 0;

                        UserManager::addAsset($user, 0, 0, $reward);
                        TaskManager::substractReward($task, $reward);
                        TaskManager::rewardGotTaskitem($taskitem);
                        UserManager::updateUser($user);
                        TaskManager::updateTaskitem($taskitem);
                        TaskManager::updateTask($task);
                        $response = Yii::$app->response;
                        $response->setStatusCode(200);
                        $response->content = json_encode(array(
                            "state" => 1
                        ));
                        $response->send();
                        return;
                    default:
                        $response = Yii::$app->response;
                        $response->setStatusCode(200);
                        $response->content = "Unexpected Error in Task Reward Type.";
                        $response->send();
                        return;
                }
                break;
            default:
                $response = Yii::$app->response;
                $response->setStatusCode(200);
                $response->content = "Unexpected Error in Task Type.";
                $response->send();
                return;
        }
    }

    public function actionAddTraffic() {
        $request = Yii::$app->request;
        $mobile = null;
        $traffic = 0;
        $telefee = 0;
        $cash = 0;
        if ($request->isGet) {
            $mobile = intval($request->get("mobile"));
            $traffic = doubleval($request->get("traffic"));

            $telefee = doubleval($request->get("telefee"));

            $cash = doubleval($request->get("cash"));
        }
        elseif ($request->isPost) {
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $param = json_decode($body);
            $mobile = intval($param->mobile);

            $traffic = doubleval($param->traffic);
            $telefee = doubleval($param->telefee);
            $cash = doubleval($param->cash);
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
            $response->content = "No mobile.";
            $response->send();
        }


        $user = UserManager::getUserByMobile($mobile);
        UserManager::addAsset($user, $traffic, $telefee, $cash);
        UserManager::updateUser($user);

        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = json_encode(array(
            "state" => 1
        ));
        $response->send();

    }


    public function actionApprove() {
        $request = Yii::$app->request;
        $taskitemid = null;
        if ($request->isGet) {
            $taskitemid = $request->get("taskitemid");
        }
        elseif ($request->isPost) {
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $param = json_decode($body);
            $taskitemid = $param->taskitemid;
        }
        else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        $taskitem = TaskManager::getTaskitemById($taskitemid);
        TaskManager::adminCheckTaskitem($taskitem);

        TaskManager::updateTaskitem($taskitem);
        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = json_encode(array(
            "state" => 1
        ));
        $response->send();
    }

}