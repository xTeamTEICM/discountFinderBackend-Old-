<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 29/10/2017
 * Time: 7:24 μμ
 */

require_once(__DIR__ . "/../appConfig.php");
require_once(__DIR__ . "/discountRequest.php");

class discountRequests
{
    private $connection;
    private $list;
    private $userId;

    /**
     * Shops constructor.
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
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
        $result = $this->connection->query("SELECT * FROM requesteddiscounts WHERE userId = '" . $this->userId . "'");
        for ($i = 0; $i < $this->connection->affectedRows($result); $i++) {
            $this->list[$i] = discountRequest::fromRow($this->connection->fetchAssoc($result));
        }
    }


    /**
     * @param $categoryId
     * @param $price
     * @param $tags
     * @param $image
     * @return string
     */
    public function add($categoryId, $price, $tags, $image)
    {
        if(is_numeric($categoryId) && is_numeric($price) && is_string($tags) && is_string($image)) {
            if ($image != "") {
                $result = $this->connection->query("INSERT INTO requesteddiscounts VALUES (NULL,'" . $this->userId . "', '$categoryId', '$price', '$tags', '$image')");
            } else {
                $result = $this->connection->query("INSERT INTO requesteddiscounts VALUES (NULL,'" . $this->userId . "', '$categoryId', '$price', '$tags', DEFAULT)");
            }

            if ($this->connection->affectedRows($result) == 1) {
                return "Added successfully";
            }
        }

        return "We can't add this discount request";
    }

    /**
     * @param $id
     * @param $categoryId
     * @param $price
     * @param $tags
     * @param $image
     * @return string
     */
    public function update($id, $categoryId, $price, $tags, $image)
    {
        if ($image != "") {
            $result = $this->connection->query("INSERT INTO requesteddiscounts VALUES ('$id','" . $this->userId . "', '$categoryId', '$price', '$tags', '$image')");
        } else {
            $result = $this->connection->query("INSERT INTO requesteddiscounts VALUES ('$id','" . $this->userId . "', '$categoryId', '$price', '$tags', NULL)");
        }

        if ($this->connection->affectedRows($result) == 1) {
            return "Added successfully";
        } else {
            return "We can't add this discountRequest";
        }
    }

    public function remove($id)
    {
        $result = $this->connection->query("DELETE FROM requesteddiscounts WHERE id='$id' AND userId = '" . $this->userId . "'");
        if ($this->connection->affectedRows($result) == 1) {
            return "Deleted successfully";
        } else {
            return "We can't delete this discount request";
        }
    }


    /**
     * Get all list as JSON object
     * @return mixed
     */
    public function asJSON()
    {
        $tmp = new stdClass();

        $tmp->status = "OK";
        $tmp->message = "Our requested discounts is here !";

        $i = 0;
        foreach ($this->list as $discountRequest) {
            $tmp->discountRequests[$i] = $discountRequest->asJSON();
            $i++;
        }
        return $tmp;
    }
}