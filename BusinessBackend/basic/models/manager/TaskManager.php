<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/17
 * Time: 13:29
 */

class TaskManager
{
    public static $basic_url = "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/Task/";

    public static function createTask($name, $description, $type, $reward_type, $reward) {

        $post_data = json_encode(array(
            "name"=>$name,
            "description"=>$description,
            "progress"=>0.0,
            "type"=>$type,
            "rewardtype"=>$reward_type,
            "reward"=>$reward,
            "state"=>0,
            "remain"=>$reward
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
        $task = new Task($ret_data->id, $ret_data->name, $ret_data->description, $ret_data->progress, $ret_data->type,
            $ret_data->rewardtype, $ret_data->reward, $ret_data->state, $ret_data->remain);

        return $task;
    }

    public static function getTaskById($id) {
        $url = self::$basic_url . $id;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);
        $task = new Task($ret_data->id, $ret_data->name, $ret_data->description, $ret_data->progress, $ret_data->type,
            $ret_data->rewardtype, $ret_data->reward, $ret_data->state, $ret_data->remain);

        return $task;
    }

    public static function getAllTasks() {
        $url = self::$basic_url;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);

        $tasks = array();
        foreach ($ret_data as $d ) {
            $task = new Task($d->id, $d->name, $d->description, $d->progress, $d->type,
                $d->rewardtype, $d->reward, $d->state, $d->remain);
            array_push($tasks, $task);
        }

        return $tasks;
    }

    public static function getTasksByType($type){
        $url = self::$basic_url . "?type=" . $type;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);

        $tasks = array();
        foreach ($ret_data as $d ) {
            $task = new Task($d->id, $d->name, $d->description, $d->progress, $d->type,
                $d->rewardtype, $d->reward, $d->state, $d->remain);
            array_push($tasks, $task);
        }

        return $tasks;
    }

    public static function substractReward(Task &$task, $sub_reward){
        $remain = $task->getRemain();
        $remain -= $sub_reward;
        $task->setRemain($remain);
    }

    public static function setProgress(Task &$task, $progress) {
        $task->setProgress($progress);
    }

    public static function FinishTask(Task &$task) {
        $task->setState(1);
    }

    public static function updateTask(Task $task){
        $id = $task->getId();
        $url = self::$basic_url . $id;

        $post_data = self::encodeTask($task);

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
        $task = new Task($ret_data->id, $ret_data->name, $ret_data->description, $ret_data->progress, $ret_data->type,
            $ret_data->rewardtype, $ret_data->reward, $ret_data->state, $ret_data->remain);

        return $task;
    }

    public static function encodeTask(Task $task)
    {
        $task_array = self::object_to_array($task);
        $str_encoded = json_encode($task_array);
        return $str_encoded;
    }

    public static function encodeTasks(array $tasks)
    {
        $tasks_array = array();
        foreach ($tasks as $task) {
            $task_array = self::object_to_array($task);
            array_push($tasks_array, $task_array);
        }
        $str_encoded = json_encode($tasks_array);
        return $str_encoded;
    }


    public static function object_to_array(Task $task){
        $ret = array(
            "id"=>$task->getId(),
            "name"=>$task->getName(),
            "description"=>$task->getDescription(),
            "progress"=>$task->getProgress(),
            "type"=>$task->getType(),
            "rewardtype"=>$task->getRewardtype(),
            "reward"=>$task->getReward(),
            "state"=>$task->getState(),
            "remain"=>$task->getRemain()
        );
        return $ret;
    }






}