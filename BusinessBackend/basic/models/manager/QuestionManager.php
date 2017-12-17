<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/17
 * Time: 14:41
 */

class QuestionManager
{
    public static $meta_basic_url = "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/Quesques/";
    public static $content_basic_url = "http://120.79.42.137:8080/Entity/U1b73d91e189ed5/PSP8/Question/";

    public static function createQuestionMetaData($taskid, $count) {
        $post_data = json_encode(array(
            "taskid"=>$taskid,
            "count"=>$count,
            "remain"=>$count
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
        $quesques = new Quesques($ret_data->id, $ret_data->taskid, $ret_data->count, $ret_data->remain);

        return $quesques;
    }

    public static function createQuestionContent(array $questions){
        $question_content = array();

        $ch_to_create = curl_init();
        curl_setopt($ch_to_create, CURLOPT_URL, self::$content_basic_url);
        curl_setopt($ch_to_create, CURLOPT_POST, true);
        curl_setopt($ch_to_create, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_create, CURLOPT_HEADER, 0);

        for ($i = 0; $i < sizeof($questions); $i ++) {

            $post_data = self::encodeObj($questions[$i]);

            $header = array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length:' . strlen($post_data)
            );

            curl_setopt($ch_to_create, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch_to_create, CURLOPT_POSTFIELDS, $post_data);

            $ret_str = curl_exec($ch_to_create);
            $ret_data = json_decode($ret_str);

            $question_content_entry = new Question($ret_data->id, $ret_data->taskid, $ret_data->questionid, $ret_data->content,
                $ret_data->a, $ret_data->b, $ret_data->c, $ret_data->d, $ret_data->acount, $ret_data->bcount,
                $ret_data->ccount, $ret_data->dcount);
            array_push($question_content, $question_content_entry);
        }
        curl_close($ch_to_create);

        return $question_content;
    }

    public static function getQuestionMetaById($id) {
        $url = self::$meta_basic_url . $id;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);
        $quesques = new Quesques($ret_data->id, $ret_data->taskid, $ret_data->count, $ret_data->remain);

        return $quesques;
    }

    public static function getQuestionContentById($id) {
        $url = self::$content_basic_url . $id;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);

        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);
        $question_content = new Question($ret_data->id, $ret_data->taskid, $ret_data->questionid, $ret_data->content,
            $ret_data->a, $ret_data->b, $ret_data->c, $ret_data->d, $ret_data->acount, $ret_data->bcount,
            $ret_data->ccount, $ret_data->dcount);

        return $question_content;
    }

    public static function getQuestionContentsByTaskid($taskid) {
        $questions_content = array();
        $url = self::$content_basic_url . "?Question.taskid=" . $taskid;
        $ch_to_get = curl_init();
        curl_setopt($ch_to_get, CURLOPT_URL, $url);
        curl_setopt($ch_to_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_to_get, CURLOPT_HEADER, 0);
        $ret_str = curl_exec($ch_to_get);
        curl_close($ch_to_get);

        $ret_data = json_decode($ret_str);

        for ($i = 0; $i < sizeof($ret_data); $i ++) {
            $question_content_entry = new Question($ret_data[$i]->id, $ret_data[$i]->taskid, $ret_data[$i]->questionid, $ret_data[$i]->content,
                $ret_data[$i]->a, $ret_data[$i]->b, $ret_data[$i]->c, $ret_data[$i]->d, $ret_data[$i]->acount, $ret_data[$i]->bcount,
                $ret_data[$i]->ccount, $ret_data[$i]->dcount);
            array_push($questions_content, $question_content_entry);
        }

        return $questions_content;
    }


    public static function receiveAnswer($taskid, array $answers) {
        $question_entrys = self::getQuestionContentsByTaskid($taskid);

        self::questionSort($question_entrys);
        for ($i = 0; $i < sizeof($answers); $i ++){
            $answer = $answers[$i];
            switch ($answer) {
                case $question_entrys[$i]->getA():
                    $acount = $question_entrys[$i]->getAcount() + 1;
                    $question_entrys[$i]->setAcount($acount);
                    break;
                case $question_entrys[$i]->getB();
                    $bcount = $question_entrys[$i]->getBcount() + 1;
                    $question_entrys[$i]->setBcount($bcount);
                    break;
                case $question_entrys[$i]->getC():
                    $ccount = $question_entrys[$i]->getCcount() + 1;
                    $question_entrys[$i]->setCcount($ccount);
                    break;
                case $question_entrys[$i]->getD():
                    $dcount = $question_entrys[$i]->getDcount() + 1;
                    $question_entrys[$i]->setDcount($dcount);
                    break;
                default:
                    break;
            }
        }

        return $question_entrys;
    }

    public static function remainDesc(Quesques &$quesques) {
        $remain_now = $quesques->getRemain();
        $remain_now -= 1;
        $quesques->setRemain($remain_now);
    }

    public static function updateQuesMeta(Quesques $quesques) {
        $id = $quesques->getId();
        $url = self::$meta_basic_url . $id;
        $post_data = self::encodeObj($quesques);

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
        $ques_meta = new Quesques($ret_data->id, $ret_data->taskid, $ret_data->count, $ret_data->remain);

        return $ques_meta;
    }


    public static function updateQuesContent(array $questions) {
        $questions_content = array();
        $ch_update = curl_init();
        curl_setopt($ch_update, CURLOPT_CUSTOMREQUEST, "put");
        curl_setopt($ch_update, CURLOPT_HEADER,false);
        curl_setopt($ch_update, CURLOPT_RETURNTRANSFER,true);

        foreach ($questions as $question) {
            $post_data = self::encodeObj($question);
            $header = array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length:' . strlen($post_data)
            );

            $url = self::$content_basic_url . $question->getId();
            curl_setopt($ch_update, CURLOPT_URL, $url);
            curl_setopt($ch_update, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch_update, CURLOPT_POSTFIELDS, $post_data);

            $ret_str = curl_exec($ch_update);
            $ret_data = json_decode($ret_str);

            $question_content_entry = new Question($ret_data->id, $ret_data->taskid, $ret_data->questionid, $ret_data->content,
                $ret_data->a, $ret_data->b, $ret_data->c, $ret_data->d, $ret_data->acount, $ret_data->bcount,
                $ret_data->ccount, $ret_data->dcount);
            array_push($questions_content, $question_content_entry);
        }
        curl_close($ch_update);
        return $questions_content;
    }


    public static function questionCompare(Question $left, Question $right) {
        if ($left->getQuestionid() == $right->getQuestionid())
            return 0;
        else
            return ($left->getQuestionid() < $right->getQuestionid()) ? -1 : 1;
    }

    public static function questionSort(array &$questions) {
        usort($questions, 'QuestionManager::questionCompare');
    }



    public static function encodeQuestionArray(array $arr)
    {
        $objs = array();
        foreach ($arr as $obj) {
            $obj_array = self::question_to_array($obj);
            array_push($objs, $obj_array);
        }
        $str_encoded = json_encode($objs);
        return $str_encoded;
    }



    public static function encodeQuestion(Question $obj)
    {
        $task_array = self::question_to_array($obj);
        $str_encoded = json_encode($task_array);
        return $str_encoded;
    }

    public static function encodeQuestionMeta(Quesques $obj)
    {
        $task_array = self::quesques_to_array($obj);
        $str_encoded = json_encode($task_array);
        return $str_encoded;
    }


    public static function question_to_array(Question $question){
        $ret = array(
            "id"=>$question->getId(),
            "taskid"=>$question->getTaskid(),
            "questionid"=>$question->getQuestionid(),
            "content"=>$question->getContent(),
            "a"=>$question->getA(),
            "b"=>$question->getB(),
            "c"=>$question->getC(),
            "d"=>$question->getD(),
            "acount"=>$question->getAcount(),
            "bcount"=>$question->getBcount(),
            "ccount"=>$question->getCcount(),
            "dcount"=>$question->getDcount()
        );
        return $ret;
    }

    public static function quesques_to_array(Quesques $ques_meta){
        $ret = array(
            "id"=>$ques_meta->getId(),
            "taskid"=>$ques_meta->getTaskid(),
            "count"=>$ques_meta->getCount(),
            "remain"=>$ques_meta->getRemain(),
        );
        return $ret;
    }

}
