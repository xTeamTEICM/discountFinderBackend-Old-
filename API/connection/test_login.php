<?php
// This file extracts all users from "USERS" database table.

//Error display script
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// End of error display script


//Connection
$connection = new mysqli("localhost","root","daidalos_666","discountFinderdb") or die();
$return_array = array();
$row_array = array();
if ($connection->connect_error) {
    die ("Connection failed ".$connection->connect_error);
} else {
//    echo "Connection Successful";
    $Status = "";
    $sql = "SELECT * from discountFinderdb.users";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row

        while($row = $result->fetch_assoc()) {
//            echo "id: " . $row["id"]. " - Name: " . $row["firstName"]. " " . $row["lastName"]. "<br>";
            $row_array['id'] = $row['id'];
            $row_array['firstname'] = $row['firstName'];
            $row_array['lastname'] = $row['lastName'];
            $row_array['email'] = $row['eMail'];
            $row_array['password'] = $row['password'];
            $row_array['passwordsalt'] = $row['passwordSalt'];
            $row_array['role'] = $row['role'];
            $row_array['token'] = $row['token'];
            $row_array['logintries'] = $row['loginTries'];
            $row_array['status'] = $row['status'];
            $row_array['unlockdate'] = $row['unlockDate'];
            $row_array['lastlogindate'] = $row['lastLoginDate'];
            $row_array['creationdate'] = $row['creationDate'];

            array_push($return_array,$row_array);
        }
    } else {
        echo "0 results";
    }

    //closes the connection
    $connection->close();
}
//$data = [ 'id' => $id,'userName' ,'age' => -1 ];
header('Content-Type: application/json');
print json_encode($return_array);
//TODO Login (eMail, Password) (Returns: Status, Message, Token, UserID   IN PROGRESS
//TODO Register (eMail, FirstName, LastName, Password, Brand (opt)) (Returns: Same as Login)  IN PROGRESS
//TODO Shops () Returns (Status, Message, JSONArray (Name, Lat, Log)  DONE
//
//Host        ouranos.jnksoftware.eu
//Username    discountFinderUser
//Password    4JgVaSVDkueUL9v4
//Database    discountFinderdb

