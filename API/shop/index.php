<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 22/10/2017
 * Time: 5:24 μμ
 */

require_once ("../appConfig.php");
require_once ("../JSONEnabler/JSONEnabler.php");
require_once ("Shops.php");

$json = new JSONEnabler();

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $json->getObject()->status = "OK";
    $json->getObject()->message = "Working !!!";

    $shops = new Shops();
    $shops->updateList();
    $shops->allAsJSON($json->getObject());
} else {
    $json->getObject()->status = "BAD";
    $json->getObject()->message = "We accept ONLY POST Calls !";
}

$json->printJSON();