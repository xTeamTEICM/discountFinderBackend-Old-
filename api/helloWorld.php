<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 21/10/2017
 * Time: 7:44 μμ
 */

class HelloWorld {
    private $msg;

    /**
     * helloWorld constructor.
     */
    public function __construct()
    {
        $this->msg = "Hello World";
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    public function getJsonMsg():stdClass {
        header('Content-type: application/json;charset=utf-8;');

        $tmp = new stdClass();
        $tmp->msg = $this->msg;
        return $tmp;
    }



}

$helloWorld = new HelloWorld();
echo json_encode($helloWorld->getJsonMsg(),JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);