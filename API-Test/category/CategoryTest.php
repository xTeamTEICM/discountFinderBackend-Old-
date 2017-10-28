<?php
/**
 * Created by PhpStorm.
 * User: iordk
 * Date: 27/10/2017
 * Time: 11:05 μμ
 */

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../../API/category/Category.php";

class CategoryTest extends TestCase
{

    public function testConstructorInvalidData()
    {
        try {
            new Category(1, 1);
        } catch (Exception $ex) {
            $this->assertEquals("Invalid data", $ex->getMessage());
        }
    }

    public function testConstructorValidData()
    {
        new Category(1, "Smartphones");
        $this->assertTrue(true);
    }

    public function testGetId()
    {
        $test = new Category(1, "Smartphones");
        $this->assertEquals(1, $test->getId());
    }

    public function testGetTitle()
    {
        $test = new Category(1, "Smartphones");
        $this->assertEquals("Smartphones", $test->getTitle());
    }

    public function testSetTitle()
    {
        $test = new Category(1, "Smartphones");
        $test->setTitle("TV");
        $this->assertEquals("TV", $test->getTitle());
    }

    public function testGetAsJSON() {
        $test = new Category(1, "Smartphones");
        $object = new stdClass();
        $object->id = 1;
        $object->title = "Smartphones";
        $this->assertEquals($object,$test->asJSON());
    }


}
