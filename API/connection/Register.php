<?php
include_once 'errorHandler.php';

/**
 * Created by PhpStorm.
 * User: paulkokos
 * Date: 23/10/2017
 * Time: 12:44 πμ


 */

/**
 * Class Register
 * It is useed to functionalize the register action
 */
class Register implements IRegister
{
    private $eMail;
    private $firstName;
    private $lastName;
    private $password;
    //private $Brand($opt); //TODO What is this ??


    public function __construct()
    {
        $this->eMail = "";
        $this->firstName = "";
        $this->lastName = "";
        $this->password = "";
    }

    /**
     * @return mixed
     */
    public function getEMail()
    {
        return $this->eMail;
    }

    /**
     * @param mixed $eMail
     */
    public function setEMail($eMail)
    {
        $this->eMail = $eMail;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     *
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param $object
     * @return string
     */

//    public function setJSON($object) {
//        return json_encode($object);
//    }

    /**
     * @param $JSON
     */
//    public function setJSON($JSON) {
//        $object = array();
//        $object = var_dump(json_decode($JSON,true));
//        return $object;
//    }
    public function returnJSON($object)
    {
        // TODO: Implement returnJSON() method.
    }
}