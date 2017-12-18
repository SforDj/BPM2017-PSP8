<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/16
 * Time: 13:37
 */

class User
{
    private $id;
    private $mobile;
    private $traffic;
    private $telefee;
    private $cash;
    private $active;
    private $tradelay;

    /**
     * User constructor.
     * @param $id
     * @param $mobile
     * @param $traffic
     * @param $telefee
     * @param $cash
     * @param $active
     * @param $tradelay
     */
    public function __construct($id, $mobile, $traffic, $telefee, $cash, $active, $tradelay)
    {
        $this->id = $id;
        $this->mobile = $mobile;
        $this->traffic = $traffic;
        $this->telefee = $telefee;
        $this->cash = $cash;
        $this->active = $active;
        $this->tradelay = $tradelay;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getTradelay()
    {
        return $this->tradelay;
    }

    /**
     * @param mixed $tradelay
     */
    public function setTradelay($tradelay)
    {
        $this->tradelay = $tradelay;
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
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getTraffic()
    {
        return $this->traffic;
    }

    /**
     * @param mixed $traffic
     */
    public function setTraffic($traffic)
    {
        $this->traffic = $traffic;
    }

    /**
     * @return mixed
     */
    public function getTelefee()
    {
        return $this->telefee;
    }

    /**
     * @param mixed $telefee
     */
    public function setTelefee($telefee)
    {
        $this->telefee = $telefee;
    }

    /**
     * @return mixed
     */
    public function getCash()
    {
        return $this->cash;
    }

    /**
     * @param mixed $cash
     */
    public function setCash($cash)
    {
        $this->cash = $cash;
    }




}