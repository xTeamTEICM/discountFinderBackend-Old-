<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 29/10/2017
 * Time: 7:05 μμ
 */

class discountRequest
{
    private $id;
    private $userId;
    private $category;
    private $price;
    private $tags;
    private $image;

    /**
     * discountRequest constructor.
     * @param $id
     * @param $userId
     * @param $category
     * @param $price
     * @param $tags
     * @param $image
     * @throws Exception
     */
    public function __construct($id, $userId, $category, $price, $tags, $image)
    {
        if(is_numeric($id) && is_numeric($userId) && is_numeric($category) && is_numeric($price) && is_string($tags) && is_string($image)) {
            $this->id = $id;
            $this->userId = $userId;
            $this->category = $category;
            $this->price = $price;
            $this->tags = $tags;
            $this->image = $image;
        } else {
            throw new Exception("Invalid data");
        }
    }

    /**
     * @param $row
     * @return discountRequest
     */
    public static function fromRow($row)
    {
        $instance = new self($row['id'], $row['userId'], $row['category'], $row['price'], $row['tags'], $row['image']);
        return $instance;
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
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Return the data as json
     * @return stdClass
     */
    public function asJSON()
    {
        $tmp = new stdClass();
        $tmp->id = $this->id;
        $tmp->userId = $this->userId;
        $tmp->category = $this->category;
        $tmp->price = $this->price;
        $tmp->tags = $this->tags;
        $tmp->image = $this->image;
        return $tmp;
    }

}