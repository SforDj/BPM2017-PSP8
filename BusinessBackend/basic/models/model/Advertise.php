<?php
/**
 * Created by PhpStorm.
 * User: Zeyu Ni
 * Date: 2017/12/16
 * Time: 14:23
 */

class Advertise
{
    private $id;
    private $name;
    private $picurl;

    /**
     * Advertise constructor.
     * @param $id
     * @param $name
     * @param $picurl
     */
    public function __construct($id, $name, $picurl)
    {
        $this->id = $id;
        $this->name = $name;
        $this->picurl = $picurl;
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
    public function getPicurl()
    {
        return $this->picurl;
    }

    /**
     * @param mixed $picurl
     */
    public function setPicurl($picurl)
    {
        $this->picurl = $picurl;
    }
    
}