<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 29/10/2017
 * Time: 8:19 μμ
 */

use PHPUnit\Framework\TestCase;
require_once ( __DIR__ . "/../../API/discountRequest/discountRequests.php");

class discountRequestsTest extends TestCase
{


    public function testConstructor()
    {
        $test = new discountRequests(1);
        $this->assertNotNull($test);
    }

    public function testAddValid() {
        $test = new discountRequests(1);
        $this->assertEquals("Added successfully",$test->add(1,22,"test,phpunit", ""));
    }

    public function testAddInvalid() {
        $test = new discountRequests(1);
        $this->assertEquals("We can't add this discount request",$test->add(1,"kkk",1,1));
    }

   /* public function testUpdateValid() {
        $test = new discountRequests(1);
        $this->assertEquals("Updated successfully",$test->update();
    }

    public function testUpdateInvalid() {
        $test = new discountRequests(1);
        $this->assertEquals("We can't update this discount request",$test->update());
    }

    public function testRemoveValid() {
        $test = new discountRequests(1);
        $this->assertEquals("Deleted successfully",$test->remove());
    }

    public function testRemoveInvalid() {
        $test = new discountRequests(1);
        $this->assertEquals("We can't delete this discount request",$test->remove());
    } */

}
