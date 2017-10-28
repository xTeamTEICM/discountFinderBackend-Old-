<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 27/10/2017
 * Time: 11:02 μμ
 */

class Category
{
    private $id;
    private $title;

    /**
     * Category constructor.
     * @param $id
     * @param $title
     * @throws Exception
     */
    public function __construct($id, $title)
    {
        if (is_numeric($id) && is_string($title)) {
            $this->id = $id;
            $this->title = $title;
        } else {
            throw new Exception("Invalid data");
        }
    }

    public static function fromRow($row)
    {
        $instance = new self($row['id'], $row['title']);
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
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /**
     * Return the data as json
     * @return stdClass
     */
    public function asJSON()
    {
        $tmp = new stdClass();
        $tmp->id = $this->id;
        $tmp->title = $this->title;
        return $tmp;
    }

}