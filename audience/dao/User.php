<?php

/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 2016/2/28
 * Time: 16:37
 */
class User {
    public $openId;
    public $orderNumber;
    public $userName;
    public $email;
    public $gender;
    public $age;
    public $university;
    public $wechat;
    public $height;
    public $weight;
    public $interest;
    public $personality;
    public $serialNumber;
    public $flag;

    /**
     * User constructor.
     * @param $orderNumber
     * @param $userName
     * @param $email
     * @param $gender
     * @param $age
     * @param $university
     * @param $wechat
     * @param $height
     * @param $weight
     * @param $interest
     * @param $personality
     * @param $flag :: 0:not matched, 1:already matched.
     */
    public function __construct($openId, $orderNumber, $userName, $email, $gender, $age, $university, $wechat, $height, $weight, $interest, $personality, $serialNumber, $flag)
    {
        $this->openId = $openId;
        $this->orderNumber = $orderNumber;
        $this->userName = $userName;
        $this->email = $email;
        $this->gender = $gender;
        $this->age = $age;
        $this->university = $university;
        $this->wechat = $wechat;
        $this->height = $height;
        $this->weight = $weight;
        $this->interest = $interest;
        $this->personality = $personality;
        $this->serialNumber = $serialNumber;
        $this->flag = $flag;
    }

    /**
     * @return mixed
     */
    public function getOpenId()
    {
        return $this->openId;
    }

    /**
     * @return mixed
     */
    public function getserialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * @return mixed
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @param mixed $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    /**
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return mixed
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * @return mixed
     */
    public function getWechat()
    {
        return $this->wechat;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return mixed
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * @return mixed
     */
    public function getPersonality()
    {
        return $this->personality;
    }

}