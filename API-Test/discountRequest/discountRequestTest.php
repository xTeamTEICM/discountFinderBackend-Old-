<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 29/10/2017
 * Time: 7:11 μμ
 */

use PHPUnit\Framework\TestCase;
require_once ( __DIR__ . "/../../API/discountRequest/discountRequest.php");

class discountRequestTest extends TestCase
{

    public function testConstructorInvalidData()
    {
        try {
            new discountRequest(1, 1,1,1,1,"test");
        } catch (Exception $ex) {
            $this->assertEquals("Invalid data", $ex->getMessage());
        }
    }

    public function testConstructorValidData()
    {
        new discountRequest(1, 1,1,1,"phpunit,test","test");
        $this->assertTrue(true);
    }

    public function testGetId()
    {
        $discountRequest = new discountRequest(1, 1,1,1,"phpunit,test","test");
        $this->assertEquals(1,$discountRequest->getId());
    }

    public function testGetUserId()
    {
        $discountRequest = new discountRequest(1, 1,1,1,"phpunit,test","test");
        $this->assertEquals(1,$discountRequest->getUserId());
    }

    public function testGetCategory()
    {
        $discountRequest = new discountRequest(1, 1,1,1,"phpunit,test","test");
        $this->assertEquals(1, $discountRequest->getCategory());
    }

    public function testGetPrice()
    {
        $discountRequest = new discountRequest(1, 1,1,1,"phpunit,test","test");
        $this->assertEquals(1,$discountRequest->getPrice());
    }

    public function testGetTags()
    {
        $discountRequest = new discountRequest(1, 1,1,1,"phpunit,test","test");
        $this->assertEquals("phpunit,test",$discountRequest->getTags());
    }

    public function testGetImage()
    {
        $discountRequest = new discountRequest(1, 1,1,1,"phpunit,test","test");
        $this->assertEquals("test", $discountRequest->getImage());
    }

    public function testAsJSON()
    {
        $discountRequest = new discountRequest(1, 1,11,1,"phpunit,test","test");
        $this->assertEquals(11, $discountRequest->asJSON()->category);
    }


}
