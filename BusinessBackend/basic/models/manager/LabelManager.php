<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/17
 * Time: 18:41
 */

class LabelManager
{
    public static $meta_basic_url = "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/Labelques/";
    public static $content_basic_url = "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/Label/";

    public static function createLabelMetaData($taskid, $a, $b, $c, $d, $count) {
        $post_data = json_encode(array(
            "taskid"=>$taskid,
            "a"=>$a,
            "b"=>$b,
            "c"=>$c,
            "d"=>$d,
            "count"=>$count,
            "remain"=>0
        ));

        $ch_to_create = curl_init();
        $header = array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length:' . strlen($post_data)
        );

        curl_setopt($ch_to_create, CURLOPT_URL, self::$meta_basic_url);
        curl_setopt($ch_to_create, CURLOPT_POST, true);
        curl_setopt($ch_to_create, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_create, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_to_create, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch_to_create, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_create);
        curl_close($ch_to_create);

        $ret_data = json_decode($ret_str);
        $labelques = new Labelques($ret_data->id, $ret_data->taskid, $ret_data->a, $ret_data->b, $ret_data->c, $ret_data->d, $ret_data->count, $ret_data->remain);

        return $labelques;
    }

    public static function createQuestionContent(array $labels){
        $labels_content = array();

        $ch_to_create = curl_init();
        curl_setopt($ch_to_create, CURLOPT_URL, self::$content_basic_url);
        curl_setopt($ch_to_create, CURLOPT_POST, true);
        curl_setopt($ch_to_create, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_create, CURLOPT_HEADER, 0);

        for ($i = 0; $i < sizeof($labels); $i ++) {

            $post_data = self::encodeLabel($labels[$i]);

            $header = array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length:' . strlen($post_data)
            );

            curl_setopt($ch_to_create, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch_to_create, CURLOPT_POSTFIELDS, $post_data);

            $ret_str = curl_exec($ch_to_create);
            $ret_data = json_decode($ret_str);

            $label_content_entry = new Label($ret_data->id, $ret_data->taskid, $ret_data->dataid, $ret_data->result,
                $ret_data->userid, $ret_data->content);
            array_push($labels_content, $label_content_entry);
        }
        curl_close($ch_to_create);

        return $labels_content;
    }


    public static function getLabelMetaById($id) {
        $url = self::$meta_basic_url . $id;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);
        $labelques = new Labelques($ret_data->id, $ret_data->taskid, $ret_data->a, $ret_data->b, $ret_data->c,
            $ret_data->d, $ret_data->count, $ret_data->remain);

        return $labelques;
    }


    public static function getLabelMetaByTaskid($taskid) {
        $url = self::$meta_basic_url . "?Labelques.taskid=" . $taskid;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);
        $ret_data = $ret_data->Labelques[0];
        $labelques = new Labelques($ret_data->id, $ret_data->taskid, $ret_data->a, $ret_data->b, $ret_data->c,
            $ret_data->d, $ret_data->count, $ret_data->remain);

        return $labelques;
    }


    public static function getLabelContentById($id) {
        $url = self::$content_basic_url . $id;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);
        $label = new Label($ret_data->id, $ret_data->taskid, $ret_data->dataid, $ret_data->result,
            $ret_data->userid, $ret_data->content);

        return $label;
    }

    public static function getLabelContentsByTaskid($taskid) {
        $labels_content = array();
        $url = self::$content_basic_url . "?Label.taskid=" . $taskid;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);
        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);
        $ret_data = $ret_data->Label;

        for ($i = 0; $i < sizeof($ret_data); $i ++) {
            $label_content_entry = new Label($ret_data[$i]->id, $ret_data[$i]->taskid, $ret_data[$i]->dataid, $ret_data[$i]->result,
                $ret_data[$i]->userid, $ret_data[$i]->content);
            array_push($labels_content, $label_content_entry);
        }

        return $labels_content;
    }

    public static function getLabelContentsByTaskidAndUserid($taskid, $userid) {
        $labels_content = array();
        $url = self::$content_basic_url . "?Label.taskid=" . $taskid . "&Label.userid=" . $userid;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);
        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);

        for ($i = 0; $i < sizeof($ret_data); $i ++) {
            $label_content_entry = new Label($ret_data[$i]->id, $ret_data[$i]->taskid, $ret_data[$i]->dataid, $ret_data[$i]->result,
                $ret_data[$i]->userid, $ret_data[$i]->content);
            array_push($labels_content, $label_content_entry);
        }

        return $labels_content;
    }

    public static function receiveAnswer($taskid, $userid, array $answers) {
        $label_entrys = self::getLabelContentsByTaskidAndUserid($taskid, $userid);
        self::labelSort($question_entrys);

        for ($i = 0; $i < sizeof($answers); $i ++){
            $label_index = $label_entrys[$i]->getDataid();
            $answer = $answers[$label_index];
            $label_entrys[$i]->setResult($answer);
        }

        return $label_entrys;
    }

    public static function assignLabel($taskid, $userid, $assign_count) {
        $label_entrys = self::getLabelContentsByTaskid($taskid);
        self::labelSort($label_entrys);
        $label_meta = self::getLabelMetaById($taskid);
        $low = $label_meta->getRemain();
        $high = $low + $assign_count;
        for ($i = $low; $i < $high; $i ++){
            $label_entrys[$i]->setUserid($userid);
        }
        $label_meta->setRemain($high);
        return array($label_entrys, $label_meta);
    }

    public static function updateLabelMeta(Labelques $labelques) {
        $id = $labelques->getId();
        $url = self::$meta_basic_url . $id;
        $post_data = self::encodeLabelMeta($labelques);

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
        $label_meta = new Labelques($ret_data->id, $ret_data->taskid, $ret_data->a, $ret_data->b, $ret_data->c,
            $ret_data->d, $ret_data->count, $ret_data->remain);

        return $label_meta;
    }



    public static function updateLabelContent(array $labels) {
        $labels_content = array();
        $ch_update = curl_init();
        curl_setopt($ch_update, CURLOPT_CUSTOMREQUEST, "put");
        curl_setopt($ch_update, CURLOPT_HEADER,false);
        curl_setopt($ch_update, CURLOPT_RETURNTRANSFER,true);

        foreach ($labels as $label) {
            $post_data = self::encodeObj($label);
            $header = array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length:' . strlen($post_data)
            );

            $url = self::$content_basic_url . $label->getId();
            curl_setopt($ch_update, CURLOPT_URL, $url);
            curl_setopt($ch_update, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch_update, CURLOPT_POSTFIELDS, $post_data);

            $ret_str = curl_exec($ch_update);
            $ret_data = json_decode($ret_str);

            $label_content_entry = new Label($ret_data->id, $ret_data->taskid, $ret_data->dataid, $ret_data->result,
                $ret_data->userid, $ret_data->content);
            array_push($labels_content, $label_content_entry);
        }
        curl_close($ch_update);
        return $labels_content;
    }


    public static function labelCompare(Label $left, Label $right) {
        if ($left->getDataid() == $right->getDataid())
            return 0;
        else
            return ($left->getDataid() < $right->getDataid()) ? -1 : 1;
    }

    public static function labelSort(array &$labels) {
        usort($labels, 'LabelManager::labelCompare');
    }



    public static function encodeLabelArray(array $arr)
    {
        $objs = array();
        foreach ($arr as $obj) {
            $obj_array = self::label_to_array($obj);
            array_push($objs, $obj_array);
        }
        $str_encoded = json_encode($objs, JSON_UNESCAPED_UNICODE);
        return $str_encoded;
    }



    public static function encodeLabel(Label $label)
    {
        $task_array = self::label_to_array($label);
        $str_encoded = json_encode($task_array, JSON_UNESCAPED_UNICODE);
        return $str_encoded;
    }

    public static function encodeLabelMeta(Labelques $label_meta)
    {
        $task_array = self::labelques_to_array($label_meta);
        $str_encoded = json_encode($task_array, JSON_UNESCAPED_UNICODE);
        return $str_encoded;
    }


    public static function label_to_array(Label $label){
        $ret = array(
            "id"=>$label->getId(),
            "taskid"=>$label->getTaskid(),
            "dataid"=>$label->getDataid(),
            "result"=>$label->getResult(),
            "userid"=>$label->getUserid(),
            "content"=>$label->getContent()
        );

        return $ret;
    }

    public static function labelArray_to_array(array $label){
        $ret = array();
        foreach ($label as $entry) {
            $ret_entry = array(
                "id" => $entry->getId(),
                "taskid" => $entry->getTaskid(),
                "dataid" => $entry->getDataid(),
                "result" => $entry->getResult(),
                "userid" => $entry->getUserid(),
                "content" => $entry->getContent()
            );
            array_push($ret, $ret_entry);
        }
        return $ret;
    }


    public static function labelques_to_array(Labelques $label_meta){
        $ret = array(
            "id"=>$label_meta->getId(),
            "taskid"=>$label_meta->getTaskid(),
            "a"=>$label_meta->getA(),
            "b"=>$label_meta->getB(),
            "c"=>$label_meta->getC(),
            "d"=>$label_meta->getD(),
            "count"=>$label_meta->getCount(),
            "remain"=>$label_meta->getRemain()
        );

        return $ret;
    }

}