<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 27/10/2017
 * Time: 11:03 μμ
 */

require_once (__DIR__ . "/../appConfig.php");
require_once ("Category.php");

class Categories
{
    private $connection;
    private $list;

    /**
     * Shops constructor.
     */
    public function __construct()
    {
        $this->connection = new MySQL();
        $this->initConnection();
        $this->updateList();
    }

    /**
     *  Open connection with DB
     */
    private function initConnection()
    {
        $this->connection->connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT, "", DB_CODE);
    }

    /**
     *  Update the local list from DB
     */
    private function updateList()
    {
        $result = $this->connection->query("SELECT * FROM category");
        for ($i = 0; $i < $this->connection->affectedRows($result); $i++) {
            $this->list[$i] = Category::fromRow($this->connection->fetchAssoc($result));
        }
    }

    public function add($title)
    {
        $result = $this->connection->query("INSERT INTO category VALUES (NULL,'$title')");
        if ($this->connection->affectedRows($result) == 1) {
            return "Added successfully";
        } else {
            return "We can't add this category";
        }
    }

    public function update($title, $newTitle)
    {
        $result = $this->connection->query("UPDATE category SET title='$newTitle' WHERE title = '$title'");
        if ($this->connection->affectedRows($result) == 1) {
            return "Updated successfully";
        } else {
            return "We can't update this category";
        }
    }

    public function remove($title)
    {
        $result = $this->connection->query("DELETE FROM category WHERE title='$title'");
        if ($this->connection->affectedRows($result) == 1) {
            return "Deleted successfully";
        } else {
            return "We can't delete this category";
        }
    }

    public function has($title)
    {
        foreach ($this->list as $category) {
            if ($category->getTitle() == $title) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get all list as JSON object
     * @return mixed
     */
    public function asJSON()
    {
        $tmp = new stdClass();

        $tmp->status = "OK";
        $tmp->message = "Our categories is here !";

        $i = 0;
        foreach ($this->list as $category) {
            $tmp->categories[$i] = $category->asJSON();
            $i++;
        }
        return $tmp;
    }


}