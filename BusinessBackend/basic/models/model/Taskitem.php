<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/16
 * Time: 14:32
 */

class Taskitem
{
    private $id;
    private $taskid;
    private $userid;
    private $rangestart;
    private $rangeend;
    private $state;

    /**
     * Taskitem constructor.
     * @param $id
     * @param $taskid
     * @param $userid
     * @param $rangestart
     * @param $rangeend
     * @param $state
     */
    public function __construct($id, $taskid, $userid, $rangestart, $rangeend, $state)
    {
        $this->id = $id;
        $this->taskid = $taskid;
        $this->userid = $userid;
        $this->rangestart = $rangestart;
        $this->rangeend = $rangeend;
        $this->state = $state;
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
    public function getRangestart()
    {
        return $this->rangestart;
    }

    /**
     * @param mixed $rangestart
     */
    public function setRangestart($rangestart)
    {
        $this->rangestart = $rangestart;
    }

    /**
     * @return mixed
     */
    public function getRangeend()
    {
        return $this->rangeend;
    }

    /**
     * @param mixed $rangeend
     */
    public function setRangeend($rangeend)
    {
        $this->rangeend = $rangeend;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }


}