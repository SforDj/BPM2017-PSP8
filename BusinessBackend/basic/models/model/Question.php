<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/16
 * Time: 14:25
 */

class Question
{
    private $id;
    private $taskid;
    private $questionid;
    private $content;
    private $a;
    private $b;
    private $c;
    private $d;
    private $acount;
    private $bcount;
    private $ccount;
    private $dcount;

    /**
     * Question constructor.
     * @param $id
     * @param $taskid
     * @param $questionid
     * @param $content
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     * @param $acount
     * @param $bcount
     * @param $ccount
     * @param $dcount
     */
    public function __construct($id, $taskid, $questionid, $content, $a, $b, $c, $d, $acount, $bcount, $ccount, $dcount)
    {
        $this->id = $id;
        $this->taskid = $taskid;
        $this->questionid = $questionid;
        $this->content = $content;
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
        $this->acount = $acount;
        $this->bcount = $bcount;
        $this->ccount = $ccount;
        $this->dcount = $dcount;
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
    public function getQuestionid()
    {
        return $this->questionid;
    }

    /**
     * @param mixed $questionid
     */
    public function setQuestionid($questionid)
    {
        $this->questionid = $questionid;
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
    public function getAcount()
    {
        return $this->acount;
    }

    /**
     * @param mixed $acount
     */
    public function setAcount($acount)
    {
        $this->acount = $acount;
    }

    /**
     * @return mixed
     */
    public function getBcount()
    {
        return $this->bcount;
    }

    /**
     * @param mixed $bcount
     */
    public function setBcount($bcount)
    {
        $this->bcount = $bcount;
    }

    /**
     * @return mixed
     */
    public function getCcount()
    {
        return $this->ccount;
    }

    /**
     * @param mixed $ccount
     */
    public function setCcount($ccount)
    {
        $this->ccount = $ccount;
    }

    /**
     * @return mixed
     */
    public function getDcount()
    {
        return $this->dcount;
    }

    /**
     * @param mixed $dcount
     */
    public function setDcount($dcount)
    {
        $this->dcount = $dcount;
    }

}