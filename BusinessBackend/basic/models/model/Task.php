<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/16
 * Time: 14:18
 */

class Task
{
    private $id;
    private $name;
    private $description;
    private $progress;
    private $type;
    private $rewardtype;
    private $reward;
    private $state;
    private $remain;

    /**
     * Task constructor.
     * @param $id
     * @param $name
     * @param $progress
     * @param $type
     * @param $rewardtype
     * @param $reward
     * @param $state
     */
    public function __construct($id, $name, $description, $progress, $type, $rewardtype, $reward, $state, $remain)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->progress = $progress;
        $this->type = $type;
        $this->rewardtype = $rewardtype;
        $this->reward = $reward;
        $this->state = $state;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @param mixed $progress
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getRewardtype()
    {
        return $this->rewardtype;
    }

    /**
     * @param mixed $rewardtype
     */
    public function setRewardtype($rewardtype)
    {
        $this->rewardtype = $rewardtype;
    }

    /**
     * @return mixed
     */
    public function getReward()
    {
        return $this->reward;
    }

    /**
     * @param mixed $reward
     */
    public function setReward($reward)
    {
        $this->reward = $reward;
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