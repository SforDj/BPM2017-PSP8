<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/16
 * Time: 14:21
 */

class Quesques
{
    private $id;
    private $taskid;
    private $count;
    private $remain;

    /**
     * Quesques constructor.
     * @param $id
     * @param $taskid
     * @param $count
     */
    public function __construct($id, $taskid, $count, $remain)
    {
        $this->id = $id;
        $this->taskid = $taskid;
        $this->count = $count;
        $this->remain = $remain;
    }

    /**
     * @return mixed
     */
    public function getRemain()
    {
        return $this->remain;
    }

    /**
     * @param mixed $remain
     */
    public function setRemain($remain)
    {
        $this->remain = $remain;
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
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }





}