<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 22/10/2017
 * Time: 5:21 μμ
 */

class Shop
{
    private $id;
    private $ownerId;
    private $brandName;
    private $logPos;
    private $latPos;

    /**
     * Shop constructor.
     * @param $row
     * @internal param $id
     * @internal param $ownerId
     * @internal param $brandName
     * @internal param $logPos
     * @internal param $latPos
     */
    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->ownerId = $row['ownerId'];
        $this->brandName = $row['brandName'];
        $this->logPos = $row['logPos'];
        $this->latPos = $row['latPos'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @return mixed
     */
    public function getBrandName()
    {
        return $this->brandName;
    }

    /**
     * @return mixed
     */
    public function getLogPos()
    {
        return $this->logPos;
    }

    /**
     * @return mixed
     */
    public function getLatPos()
    {
        return $this->latPos;
    }

    /**
     * @param mixed $brandName
     */
    public function setBrandName($brandName)
    {
        $this->brandName = $brandName;
    }

    /**
     * @param mixed $logPos
     */
    public function setLogPos($logPos)
    {
        $this->logPos = $logPos;
    }

    /**
     * @param mixed $latPos
     */
    public function setLatPos($latPos)
    {
        $this->latPos = $latPos;
    }

    public function asJSON() {
        $tmp = new stdClass();
        $tmp->id = $this->id;
        $tmp->ownerId = $this->ownerId;
        $tmp->brandName = $this->brandName;
        $tmp->logPos = $this->logPos;
        $tmp->latPos = $this->latPos;
        return $tmp;
    }


}