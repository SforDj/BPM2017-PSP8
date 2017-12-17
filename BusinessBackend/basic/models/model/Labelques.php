<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/16
 * Time: 14:15
 */

class Labelques
{
    private $id;
    private $taskid;
    private $a;
    private $b;
    private $c;
    private $d;
    private $count;
    private $remain;

    /**
     * Labelques constructor.
     * @param $taskid
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     * @param $count
     */
    public function __construct($id, $taskid, $a, $b, $c, $d, $count, $remain)
    {
        $this->id = $id;
        $this->taskid = $taskid;
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
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
    public function getA()
    {
        return $this->a;
    }

    /**
     * @param mixed $a
     */
    public function setA($a)
    {
        $this->a = $a;
    }

    /**
     * @return mixed
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * @param mixed $b
     */
    public function setB($b)
    {
        $this->b = $b;
    }

    /**
     * @return mixed
     */
    public function getC()
    {
        return $this->c;
    }

    /**
     * @param mixed $c
     */
    public function setC($c)
    {
        $this->c = $c;
    }

    /**
     * @return mixed
     */
    public function getD()
    {
        return $this->d;
    }

    /**
     * @param mixed $d
     */
    public function setD($d)
    {
        $this->d = $d;
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