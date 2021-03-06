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
    public static $item_basic_url = "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/Taskitem/";
    public static $secret_basic_url = "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/Secret/";

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

    public static function getSecretFromTaskitems(array $taskitems) {
        $url = self::$secret_basic_url;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str)->Secret;

//        Yii::warning("1213333333333333333333333333333333333333333333333333333333333333333");
//        Yii::warning($taskitems);
//        Yii::warning(sizeof($taskitems));


        $keys = array();
        for ($i = 0; $i < sizeof($ret_data); $i ++) {
            array_push($keys, $ret_data[$i]->key);
        }


        $has = array();
        foreach ($taskitems as $taskitem) {
            $name = self::getTaskById($taskitem->getTaskid())->getName();

//            Yii::warning("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
//            Yii::warning($name);
//            Yii::warning("cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc");
//            Yii::warning(strpos($name, "豆") !== false);


            if(strpos($name, "豆") !== false && in_array("纳豆", $has) == false) {
                array_push($has, "纳豆");
            }
            elseif (strpos($name, "主播") !== false && in_array("纳豆", $has) == false) {
                array_push($has, "纳豆");
            }
            elseif (strpos($name, "球") !== false && in_array("球类", $has) == false) {
                array_push($has, "球类");
            }
            elseif ((strpos($name, "歌") !== false || strpos($name, "电影") !== false) && in_array("音乐", $has) == false) {
                array_push($has, "音乐");
            }
            elseif(sizeof($ret_data) >= 5 && in_array($keys[4], $has)) {
                array_push($has, $keys[4]);
            }
        }




        $taskids = array();

        for ($i = 0; $i < sizeof($ret_data); $i ++) {
            for ($j = 0; $j < sizeof($has); $j ++) {
                if ($has[$j] == $ret_data[$i]->key) {
                    $id_array = explode(',', $ret_data[$i]->value);
                    foreach ($id_array as $id) {
                        array_push($taskids, intval($id));
                    }
                }
            }
        }


        return $taskids;

    }

    public static function resort(array $tasks, array $recommand_ids) {
        $ret_array = array();

        foreach ($tasks as $task) {
            if (in_array($task->getId(), $recommand_ids)) {
                array_unshift($ret_array, $task);
            }
            else {
                array_push($ret_array, $task);
            }
        }

        return $ret_array;
    }

    public static function createTaskItem($taskid, $userid, $rangestart, $rangeend) {

        $post_data = json_encode(array(
            "taskid"=>$taskid,
            "userid"=>$userid,
            "rangestart"=>$rangestart,
            "rangeend"=>$rangeend,
            "state"=>0
        ));

        $ch_to_create = curl_init();
        $header = array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length:' . strlen($post_data)
        );

        curl_setopt($ch_to_create, CURLOPT_URL, self::$item_basic_url);
        curl_setopt($ch_to_create, CURLOPT_POST, true);
        curl_setopt($ch_to_create, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_create, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_to_create, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch_to_create, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_create);
        curl_close($ch_to_create);

        $ret_data = json_decode($ret_str);
        $taskitem = new Taskitem($ret_data->id, $ret_data->taskid, $ret_data->userid, $ret_data->rangestart, $ret_data->rangeend,
            $ret_data->state);

        return $taskitem;
    }

    public static function userFinishTaskitem(Taskitem &$taskitem) {
        $taskitem->setState(1);
    }

    public static function adminCheckTaskitem(Taskitem &$taskitem) {
        $taskitem->setState(2);
    }

    public static function rewardGotTaskitem(Taskitem &$taskitem) {
        $taskitem->setState(3);
    }

    public static function getTaskitemByUseridAndState($userid, $state) {
        $taskitems = array();
        $url = self::$item_basic_url . "?Taskitem.state=" . $state . "&Taskitem.userid=" . $userid;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        if($ret_str == "{}")
            return $taskitems;

        $ret_data = json_decode($ret_str);

        $ret_data = $ret_data->Taskitem;

        for ($i = 0; $i < sizeof($ret_data); $i ++) {
            $data = $ret_data[$i];
            $taskitem = new Taskitem($data->id, $data->taskid, $data->userid, $data->rangestart, $data->rangeend,
                $data->state);
            array_push($taskitems, $taskitem);
        }

        return $taskitems;
    }

    public static function getTaskitemByUserid($userid) {
        $taskitems = array();
        $url = self::$item_basic_url . "?Taskitem.userid=" . $userid;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        if($ret_str == "{}")
            return $taskitems;

        $ret_data = json_decode($ret_str);

        $ret_data = $ret_data->Taskitem;


        for ($i = 0; $i < sizeof($ret_data); $i ++) {
            $data = $ret_data[$i];


            $taskitem = new Taskitem($data->id, $data->taskid, $data->userid, $data->rangestart, $data->rangeend,
                $data->state);
            array_push($taskitems, $taskitem);

        }

        return $taskitems;
    }



    public static function getTaskitemByTaskidAndState($taskid, $state) {
        $taskitems = array();
        $url = self::$item_basic_url . "?Taskitem.state=" . $state . "&Taskitem.taskid=" . $taskid;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);
        if($ret_str == "{}")
            return $taskitems;

        $ret_data = json_decode($ret_str);

        for ($i = 0; $i < sizeof($ret_data); $i ++) {
            $data = $ret_data[$i];
            $taskitem = new Taskitem($data->id, $data->taskid, $data->userid, $data->rangestart, $data->rangeend,
                $data->state);
            array_push($taskitems, $taskitem);
        }

        return $taskitems;
    }


    public static function getTaskitemByState($state) {
        $taskitems = array();
        $url = self::$item_basic_url . "?Taskitem.state=" . $state;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        if($ret_str == "{}")
            return $taskitems;

        $ret_data = json_decode($ret_str);

        $ret_data = $ret_data->Taskitem;

        for ($i = 0; $i < sizeof($ret_data); $i ++) {
            $data = $ret_data[$i];
            $taskitem = new Taskitem($data->id, $data->taskid, $data->userid, $data->rangestart, $data->rangeend,
                $data->state);
            array_push($taskitems, $taskitem);
        }

        return $taskitems;
    }


    public static function getTaskitemByTaskidAndUserid($taskid, $userid) {
        $taskitems = array();
        $url = self::$item_basic_url . "?Taskitem.taskid=" . $taskid . "&Taskitem.userid=" . $userid;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        if($ret_str == "{}")
            return $taskitems;

        $ret_data = json_decode($ret_str);
        $ret_data = $ret_data->Taskitem;

        for ($i = 0; $i < sizeof($ret_data); $i ++) {
            $data = $ret_data[$i];
            $taskitem = new Taskitem($data->id, $data->taskid, $data->userid, $data->rangestart, $data->rangeend,
                $data->state);
            array_push($taskitems, $taskitem);
        }

        return $taskitems;

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

    public static function getTaskitemById($id) {
        $url = self::$item_basic_url . $id;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $data = json_decode($ret_str);
        $taskitem = new Taskitem($data->id, $data->taskid, $data->userid, $data->rangestart, $data->rangeend,
            $data->state);

        return $taskitem;
    }




    public static function getAllTasks() {
        $url = self::$basic_url;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $tasks = array();
        if($ret_str == "{}")
            return $tasks;

        $ret_data = json_decode($ret_str);





        for ($i = 0; $i < sizeof($ret_data->Task);$i ++) {
            $d = $ret_data->Task[$i];
            $task = new Task($d->id, $d->name, $d->description, $d->progress, $d->type,
                $d->rewardtype, $d->reward, $d->state, $d->remain);
            array_push($tasks, $task);
        }

        return $tasks;
    }

    public static function getTasksByType($type){
        $url = self::$basic_url . "?Task.type=" . $type;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);

        $tasks = array();
        for ($i = 0; $i < sizeof($ret_data->Task);$i ++) {
            $d = $ret_data->Task[$i];
            $task = new Task($d->id, $d->name, $d->description, $d->progress, $d->type,
                $d->rewardtype, $d->reward, $d->state, $d->remain);
            array_push($tasks, $task);
        }

        return $tasks;
    }

    public static function getTasksByState($state){
        $url = self::$basic_url . "?Task.state=" . $state;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);

        $tasks = array();
        for ($i = 0; $i < sizeof($ret_data->Task);$i ++) {
            $d = $ret_data->Task[$i];
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

    public static function finishTask(Task &$task) {
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
        curl_setopt($ch_update, CURLOPT_CUSTOMREQUEST, "PUT");
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

    public static function updateTaskitem(Taskitem $taskitem){
        $id = $taskitem->getId();
        $url = self::$item_basic_url . $id;

        $post_data = self::encodeTaskitem($taskitem);

        $ch_update = curl_init();
        $header = array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length:' . strlen($post_data)
        );

        curl_setopt($ch_update, CURLOPT_URL, $url);
        curl_setopt($ch_update, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch_update, CURLOPT_HEADER,false);
        curl_setopt($ch_update, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_update, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch_update, CURLOPT_POSTFIELDS, $post_data);
        $ret_str = curl_exec($ch_update);
        curl_close($ch_update);

        $ret_data = json_decode($ret_str);
        $taskitem = new Taskitem($ret_data->id, $ret_data->taskid, $ret_data->userid, $ret_data->rangestart, $ret_data->rangeend,
            $ret_data->state);

        return $taskitem;
    }


    public static function encodeTask(Task $task)
    {
        $task_array = self::task_to_array($task);
        $str_encoded = json_encode($task_array, JSON_UNESCAPED_UNICODE);
        return $str_encoded;
    }

    public static function encodeTaskitem(Taskitem $taskitem)
    {
        $task_array = self::taskitem_to_array($taskitem);
        $str_encoded = json_encode($task_array, JSON_UNESCAPED_UNICODE);
        return $str_encoded;
    }


    public static function encodeTasks(array $tasks)
    {
        $tasks_array = array();
        foreach ($tasks as $task) {
            $task_array = self::task_to_array($task);
            array_push($tasks_array, $task_array);
        }
        $str_encoded = json_encode($tasks_array, JSON_UNESCAPED_UNICODE);
        return $str_encoded;
    }

    public static function encodeTaskitems(array $taskitems)
    {
        $taskitems_array = self::taskitemArray_to_array($taskitems);
        $str_encoded = json_encode($taskitems_array, JSON_UNESCAPED_UNICODE);
        return $str_encoded;
    }

    public static function taskArray_to_array(array $tasks, array $remains, $n){
        $ret = array();
        for ($i = 0; $i < sizeof($tasks); $i ++) {
            $recommend = 0;
            if($i < $n) {
                $recommend = 1;
            }

            $task = $tasks[$i];
            $ret_entry = array(
                "id" => $task->getId(),
                "name" => $task->getName(),
                "description" => $task->getDescription(),
                "progress" => $task->getProgress(),
                "type" => $task->getType(),
                "rewardtype" => $task->getRewardtype(),
                "reward" => $task->getReward(),
                "state" => $task->getState(),
                "remain" => $task->getRemain(),
                "count_remain" => $remains[$i],
                "recommend" => $recommend
            );
            array_push($ret, $ret_entry);
        }
        return $ret;
    }


    public static function task_to_array(Task $task){
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

    public static function taskitem_to_array(Taskitem $taskitem){
        $ret = array(
            "id"=>$taskitem->getId(),
            "taskid"=>$taskitem->getTaskid(),
            "userid"=>$taskitem->getUserid(),
            "rangestart"=>$taskitem->getRangestart(),
            "rangeend"=>$taskitem->getRangeend(),
            "state"=>$taskitem->getState()
        );
        return $ret;
    }

    public static function taskitemArray_to_array(array $taskitems){
        $ret = array();
        foreach ($taskitems as $entry) {
            $ret_entry = array(
                "id" => $entry->getId(),
                "taskid" => $entry->getTaskid(),
                "userid" => $entry->getUserid(),
                "rangestart" => $entry->getRangestart(),
                "rangeend" => $entry->getRangeend(),
                "state" => $entry->getState()
            );
            array_push($ret, $ret_entry);
        }
        return $ret;
    }


    public static function taskitemAndTaskArray_to_array(array $taskitems, array $task_array){
        $ret = array();

        if (sizeof($taskitems) != sizeof($task_array))
            return $ret;

        for ($i = 0; $i < sizeof($taskitems); $i ++) {
            $entry = $taskitems[$i];
            $task_entry = $task_array[$i];
            $ret_entry = array(
                "taskitemid" => $entry->getId(),
                "taskid" => $entry->getTaskid(),
                "userid" => $entry->getUserid(),
                "rangestart" => $entry->getRangestart(),
                "rangeend" => $entry->getRangeend(),
                "taskitem_state" => $entry->getState(),
                "id" => $task_entry->getId(),
                "name" => $task_entry->getName(),
                "description" => $task_entry->getDescription(),
                "progress" => $task_entry->getProgress(),
                "type" => $task_entry->getType(),
                "rewardtype" => $task_entry->getRewardtype(),
                "reward" => $task_entry->getReward(),
                "state" => $task_entry->getState(),
                "remain" => $task_entry->getRemain()
            );
            array_push($ret, $ret_entry);
        }

        return $ret;
    }




}