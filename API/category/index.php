<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 28/10/2017
 * Time: 2:32 μμ
 */

require_once (__DIR__ . "/../JSONEnabler/JSONEnabler.php");
require_once (__DIR__ . "Categories.php");

$jsonController = new JSONEnabler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categories = new Categories();
    if (isset($_POST['action'])) {

        if (isset($_POST['title'])) {
            switch ($_POST['action']) {
                case "add" : {
                    $jsonController->getObject()->result = $categories->add($_POST['title']);
                    break;
                }
                case "update" : {
                    if (isset($_POST['newTitle'])) {
                        $jsonController->getObject()->result = $categories->update($_POST['title'], $_POST['newTitle']);
                    } else {
                        $jsonController->getObject()->result->status = "BAD";
                        $jsonController->getObject()->result->message = "You must define the new name";
                    }
                    break;
                }
                case "remove" : {
                    $jsonController->getObject()->result = $categories->remove($_POST['title']);
                    break;
                }
            }
        } else {
            $jsonController->getObject()->result->status = "BAD";
            $jsonController->getObject()->result->message = "You must define the category title";
        }

    } else {
        $jsonController->getObject()->result = $categories->asJSON();
    }
} else {
    $jsonController->getObject()->status = "BAD";
    $jsonController->getObject()->message = "We accept ONLY POST requests";
}

$jsonController->printJSON();