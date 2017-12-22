<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/19
 * Time: 14:57
 */

namespace app\controllers;

include "../models/manager/TaskManager.php";
include "../models/manager/QuestionManager.php";
include "../models/manager/LabelManager.php";
include "../models/manager/UserManager.php";
include "../models/model/Task.php";
include "../models/model/User.php";
include "../models/model/Taskitem.php";
include "../models/model/Question.php";
include "../models/model/Quesques.php";
include "../models/model/Label.php";
include "../models/model/Labelques.php";
use TaskManager;
use QuestionManager;
use LabelManager;
use UserManager;
use Task;
use Question;
use Quesques;
use Label;
use Labelques;
use Taskitem;

use Yii;
use yii\web\Controller;

class TaskController extends Controller
{
    public function actionGetAllTasks() {
        $request = Yii::$app->request;
        $mobile = null;

        if(!$request->isGet) {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }
        else {
            $mobile =intval($request->get("mobile"));
        }
        if($mobile == null) {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "CZHSB.";
            $response->send();
        }


        $tasks = TaskManager::getAllTasks();

        $count_remain = array();
        foreach ($tasks as $task) {
            $taskid = $task->getId();
            $type = $task->getType();
            switch ($type) {
                case 0:
                    $r = QuestionManager::getQuestionMetaByTaskid($taskid)->getRemain();
                    array_push($count_remain, $r);
                    break;
                case 1:
                    $r = LabelManager::getLabelMetaByTaskid($taskid)->getCount() - LabelManager::getLabelMetaByTaskid($taskid)->getRemain();
                    array_push($count_remain, $r);
                    break;
                default:
                    break;
            }
        }


        $tasks_encoded = json_encode(array(
            "Task"=>TaskManager::taskArray_to_array($tasks, $count_remain
            )
        ));
        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = $tasks_encoded;
        $response->send();
    }


    public function actionGetTaskContent() {
        $request = Yii::$app->request;
        $taskid = null;
        $mobile = null;

        if($request->isGet) {
            $taskid = intval($request->get("id"));
            $mobile = intval($request->get("mobile"));
        }
        elseif ($request->isPost) {
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $params = json_decode($body);
            $taskid = intval($params->taskid);
            $mobile = intval($params->mobile);
        }
        else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        $task = TaskManager::getTaskById($taskid);
        $type = $task->getType();
        $userid = UserManager::getUserByMobile($mobile)->getId();

        switch ($type) {
            case 0:
                $question_meta = QuestionManager::getQuestionMetaByTaskid($taskid);
                $question_meta = QuestionManager::quesques_to_array($question_meta);

                $question_contents = QuestionManager::getQuestionContentsByTaskid($taskid);
                $question_contents = QuestionManager::questionArray_to_array($question_contents);
                $ret_data = json_encode(array(
                    "meta"=>$question_meta,
                    "contents"=>$question_contents
                ), JSON_UNESCAPED_UNICODE);
                $response = Yii::$app->response;
                $response->setStatusCode(200);
                $response->content = $ret_data;
                $response->send();
                return;
            case 1:
                $label_meta = LabelManager::getLabelMetaByTaskid($taskid);
                $label_meta = LabelManager::labelques_to_array($label_meta);

                $label_contents = LabelManager::getLabelContentsByTaskidAndUserid($taskid, $userid);
                $label_contents = LabelManager::labeLArray_to_array($label_contents);
                $ret_data = json_encode(array(
                    "meta"=>$label_meta,
                    "contents"=>$label_contents
                ), JSON_UNESCAPED_UNICODE);



                $response = Yii::$app->response;
                $response->setStatusCode(200);
                $response->content = $ret_data;
                $response->send();
                return;
            default:
                $response = Yii::$app->response;
                $response->setStatusCode(200);
                $response->content = "Wrong task type.";
                $response->send();
                return;
        }

    }

    public function actionSubmitQuestion()
    {
        $request = Yii::$app->request;
        $taskid = null;
        $userid = null;
        $answers = null;
        $mobile = null;
//        Yii::warning("~~~~~~~~~~~~~~~~~~~~~~~");
//        Yii::warning($request->getRawBody());

        if ($request->isPost) {
            $body = trim($request->getRawBody(), '"');
            $body = stripslashes($body);
            $params = json_decode($body);
            $taskid = intval($params->taskid);
            $mobile = intval($params->mobile);
//            $userid = $params->userid;
            $answers = $params->answers;
        } else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        if($mobile == null || $taskid == null) {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "CZHDSB.";
            $response->send();
            return;
        }



        $userid = UserManager::getUserByMobile($mobile)->getId();


//        $task = TaskManager::getTaskById($taskid);
//        $question_meta = QuestionManager::getQuestionMetaByTaskid($taskid);
        $taskitem_array = TaskManager::getTaskitemByTaskidAndUserid($taskid, $userid);
        $taskitem = $taskitem_array[0];

        if ($answers == null) {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "No Answers Received.";
            $response->send();
            return;
        }

//        Yii::warning($answers);
//        Yii::warning("wwwwwwww\n");
//        Yii::warning($answers[0]);
//        Yii::warning("wwwwwwww\n");
//        Yii::warning($answers[1]);
//        Yii::warning("wwwwwwww\n");
//        Yii::warning($answers[2]);
////        $answers = json_decode($answers, true);
        if ($answers == null || $answers == "[]") {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Json Format.";
            $response->send();
            return;
        }

        $question_entrys = QuestionManager::receiveAnswer($taskid, $answers);
        TaskManager::userFinishTaskitem($taskitem);
        QuestionManager::updateQuesContent($question_entrys);
        TaskManager::updateTaskitem($taskitem);

        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = json_encode(array(
            "state" => 1
        ));
        $response->send();
        return;
    }


    public function actionSumbitLabel() {
        $request = Yii::$app->request;
        $taskid = null;
        $userid = null;
        $answers = null;
        $mobile = null;

        Yii::warning("***********************************************************************************8\n");
        Yii::warning($request->getRawBody());

        if ($request->isPost) {
            $body = trim($request->getRawBody(), '"');
            $body = stripslashes($body);
            $params = json_decode($body);
            $taskid = intval($params->taskid);
            $mobile = intval($params->mobile);
            $answers = $params->answers;
        } else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        $userid = UserManager::getUserByMobile($mobile)->getId();

//        $task = TaskManager::getTaskById($taskid);
//        $label_meta = LabelManager::getLabelMetaByTaskid($taskid);
        $taskitem_array = TaskManager::getTaskitemByTaskidAndUserid($taskid, $userid);

        if ($answers == null) {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "No Answers Received.";
            $response->send();
            return;
        }

        $answers = json_decode($answers, true);
        if ($answers == null || $answers == "[]") {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Json Format.";
            $response->send();
            return;
        }

        $label_entrys = LabelManager::receiveAnswer($taskid, $userid, $answers);
        LabelManager::updateLabelContent($label_entrys);

        foreach ($taskitem_array as $taskitem) {
            TaskManager::userFinishTaskitem($taskitem);
            TaskManager::updateTaskitem($taskitem);
        }

        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = json_encode(array(
            "state" => 1
        ));
        $response->send();
        return;
    }

    public function actionReceiveTask() {
        $request = Yii::$app->request;
        $taskid = null;
        $userid = null;
        $mobile = null;
        $type = null;
        $assign_count = null;

        if($request->isGet) {
            $taskid = intval($request->get("taskid"));
            $mobile = intval($request->get("mobile"));
            $assign_count = intval($request->get("assign_count"));
        }
        elseif ($request->isPost) {
            $body = trim($request->getRawBody(), '"');
            $body = stripslashes($body);
            $params = json_decode($body);
            $taskid = intval($params->taskid);
            $mobile = intval($params->mobile);
            $assign_count = intval($params->assign_count);
        } else {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        if($mobile == null || $taskid == null || $assign_count == null) {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "CZHDSB.";
            $response->send();
            return;
        }


        $userid = UserManager::getUserByMobile($mobile)->getId();

        $type = TaskManager::getTaskById($taskid)->getType();

        $task = TaskManager::getTaskById($taskid);
        switch ($type) {
            case 0:
                $question_meta = QuestionManager::getQuestionMetaByTaskid($taskid);
                $question_index = $question_meta->getCount() - $question_meta->getRemain();
                TaskManager::createTaskItem($taskid, $userid, $question_index, $question_index + $assign_count);
                QuestionManager::remainDesc($question_meta);
                $progress = 1.0 - doubleval($question_meta->getRemain() / $question_meta->getCount());
                TaskManager::setProgress($task, $progress);
                QuestionManager::updateQuesMeta($question_meta);


                TaskManager::updateTask($task);
                $response = Yii::$app->response;
                $response->setStatusCode(200);
                $response->content = json_encode(array(
                    "state" => 1
                ));
                $response->send();
                return;
            case 1:
                $label_meta = LabelManager::getLabelMetaByTaskid($taskid);

                $label_index = $label_meta->getRemain();
                TaskManager::createTaskItem($taskid, $userid, $label_index, $label_index + $assign_count);
                $label_inform = LabelManager::assignLabel($taskid, $userid, $assign_count);


                $progress = doubleval(($label_meta->getRemain() + $assign_count) / $label_meta->getCount());
                TaskManager::setProgress($task, $progress);
                LabelManager::updateLabelMeta($label_inform[1]);
                LabelManager::updateLabelContent($label_inform[0]);
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
                $response->content = "Task Type Error.";
                $response->send();
                return;
        }
    }







}