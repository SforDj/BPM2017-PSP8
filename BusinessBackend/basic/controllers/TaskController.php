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
include "../models/model/Task.php";
include "../models/model/Question.php";
include "../models/model/Quesques.php";
include "../models/model/Label.php";
include "../models/model/Labelques.php";
use TaskManager;
use QuestionManager;
use LabelManager;
use Task;
use Question;
use Quesques;
use Label;
use Labelques;

use Yii;
use yii\web\Controller;

class TaskController extends Controller
{
    public function actionGetAllTasks() {
        $request = Yii::$app->request;
        if(!$request->isGet) {
            $response = Yii::$app->response;
            $response->setStatusCode(200);
            $response->content = "Wrong Request Type.";
            $response->send();
            return;
        }

        $tasks = TaskManager::getAllTasks();
        $tasks_encoded = TaskManager::encodeTasks($tasks);
        $response = Yii::$app->response;
        $response->setStatusCode(200);
        $response->content = $tasks_encoded;
        $response->send();
    }

    public function actionGetTaskContent() {
        $request = Yii::$app->request;
        $taskid = null;

        if($request->isGet) {
            $taskid = $request->get("id");
        }
        elseif ($request->isPost) {
            $body = trim($request->getRawBody(),'"');
            $body = stripslashes($body);
            $params = json_decode($body);
            $taskid = $params->taskid;
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

                $label_contents = LabelManager::getLabelContentsByTaskid($taskid);
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










}