<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 28/10/2017
 * Time: 6:09 μμ
 */

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../API/category/Categories.php";

class CategoriesTest extends TestCase
{

    public function testConstructor()
    {
        $test= new Categories();
        $this->assertNotNull($test);
    }

    public function testHasValid() {
        $test = new Categories();
        $this->assertTrue($test->has("Smartphones"));
    }

    public function testHasInvalid() {
        $test = new Categories();
        $this->assertFalse($test->has("sadasdsadasdas"));
    }

    public function testAddValid() {
        $test=new Categories();
        $this->assertEquals("Added successfully",$test->add("SmartphonesTest"));
    }

    public function testAddInvalid() {
        $test=new Categories();
        $this->assertEquals("We can't add this category",$test->add("SmartphonesTest"));
    }

    public function testUpdateValid() {
        $test=new Categories();
        $this->assertEquals("Updated successfully",$test->update("SmartphonesTest", "SmartphonesTestTest"));
    }

    public function testUpdateInvalid() {
        $test=new Categories();
        $this->assertEquals("We can't update this category",$test->update("SmartphonesTest", "SmartphonesTestTest"));
    }

    public function testRemoveValid() {
        $test=new Categories();
        $this->assertEquals("Deleted successfully",$test->remove("SmartphonesTestTest"));
    }

    public function testRemoveInvalid() {
        $test=new Categories();
        $this->assertEquals("We can't delete this category",$test->remove("SmartphonesTest"));
    }


}
