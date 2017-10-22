<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 22/10/2017
 * Time: 5:33 μμ
 */

require_once ("Shop.php");

class Shops
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
    }


    private function initConnection() {
        $this->connection->connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT, "", DB_CODE);
    }

    public function updateList() {
        $result = $this->connection->query("SELECT * FROM shops");

        for($i=0;$i<$this->connection->affectedRows($result); $i++) {
            $this->list[$i] = new Shop($this->connection->fetchAssoc($result));
        }
    }

    /**
     * @param $jsonObject
     * @return mixed
     */
    public function allAsJSON($jsonObject) {
        $i = 0;
        foreach ($this->list as $shop) {
            $jsonObject->shops[$i] = $shop->asJSON();
            $i++;
        }
        return $jsonObject;
    }


}