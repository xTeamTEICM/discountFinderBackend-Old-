<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'MySQL.php';
/**
 * Created by PhpStorm.
 * User: paulkokos
 * Date: 22/10/2017
 * Time: 9:06 πμ
 */

$email = "paulkokos";/*$_POST['email'];*/
$pass_word ="paulkokos";/* $_POST['pass_word'];*/
$mysqlConnect = new MySQL();
$output = $mysqlConnect->connect('localhost',"paulkokos","daidalos_666","discountFinderdb",3306);
echo $output;
//$msqli_query = "SELECT * from login where username like '$mail' and password like $pass_word";
//echo 'Test 123';
//$result = mysqli($msqli_query,$output);
echo 'Test';
$sql="select * from Posts limit 20";

$response = array();
$posts = array();
//$result=$mysqlConnect->
while($row=mysqli_fetch_array($result))
{
    $title=$row['title'];
    $url=$row['url'];

    $posts[] = array('title'=> $title, 'url'=> $url);

}

$response['posts'] = $posts;

$fp = fopen('../../results.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);