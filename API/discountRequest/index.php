<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 29/10/2017
 * Time: 7:22 μμ
 */

require_once(__DIR__ . "/../JSONEnabler/JSONEnabler.php");
require_once(__DIR__ . "/discountRequests.php");

$jsonController = new JSONEnabler();

function hasAllAddFields()
{
    if (isset($_POST['userId'], $_POST['category'], $_POST['price'], $_POST['tags'], $_POST['image'])) {
        return true;
    }

    return false;
}

function hasAllUpdateFields()
{
    if (isset($_POST['id'], $_POST['userId'], $_POST['category'], $_POST['price'], $_POST['tags'], $_POST['image'])) {
        return true;
    }

    return false;
}

function hasAllRemoveFields() {
    if(isset($_POST['id'])) {
        return true;
    }

    return false;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['userId'])) {
        $discountRequests = new discountRequests($_POST['userId']);
        if (isset($_POST['action'])) {

            switch ($_POST['action']) {
                case "add" : {
                    if (hasAllAddFields()) {
                        $jsonController->getObject()->result = $discountRequests->add($_POST['category'], $_POST['price'], $_POST['tags'], $_POST['image']);
                    } else {
                        $jsonController->getObject()->result->status = "BAD";
                        $jsonController->getObject()->result->message = "You must fill all fields !";
                    }
                    break;
                }
                case "update" : {
                    if (hasAllUpdateFields()) {
                        $jsonController->getObject()->result = $discountRequests->update($_POST['id'], $_POST['category'], $_POST['price'], $_POST['tags'], $_POST['image']);
                    } else {
                        $jsonController->getObject()->result->status = "BAD";
                        $jsonController->getObject()->result->message = "You must fill all fields !";
                    }
                    break;
                }
                case "remove" : {
                    if(hasAllRemoveFields()) {
                        $jsonController->getObject()->result = $discountRequests->remove($_POST['id']);
                    } else {
                        $jsonController->getObject()->result->status = "BAD";
                        $jsonController->getObject()->result->message = "You must set id !";
                    }
                    break;
                }
            }

        } else {
            $jsonController->getObject()->result = $discountRequests->asJSON();
        }
    } else {
        $jsonController->getObject()->result->status = "BAD";
        $jsonController->getObject()->result->message = "You must provide the userId !";
    }
} else {
    $jsonController->getObject()->result->status = "BAD";
    $jsonController->getObject()->result->message = "We accept ONLY POST requests";
}

$jsonController->printJSON();
