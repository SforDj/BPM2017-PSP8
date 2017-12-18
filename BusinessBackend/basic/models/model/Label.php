<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/16
 * Time: 14:27
 */

class Label
{
    private $id;
    private $taskid;
    private $dataid;
    private $result;
    private $userid;
    private $content;

    /**
     * Label constructor.
     * @param $id
     * @param $taskid
     * @param $dataid
     * @param $result
     * @param $userid
     * @param $content
     */
    public function __construct($id, $taskid, $dataid, $result, $userid, $content)
    {
        $this->id = $id;
        $this->taskid = $taskid;
        $this->dataid = $dataid;
        $this->result = $result;
        $this->userid = $userid;
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTaskid()
    {
        return $this->taskid;
    }

    /**
     * @param mixed $taskid
     */
    public function setTaskid($taskid)
    {
        $this->taskid = $taskid;
    }

    /**
     * @return mixed
     */
    public function getDataid()
    {
        return $this->dataid;
    }

    /**
     * @param mixed $dataid
     */
    public function setDataid($dataid)
    {
        $this->dataid = $dataid;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


}