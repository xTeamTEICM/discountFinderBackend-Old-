<?php

use PHPUnit\Framework\TestCase;

require_once("JSONEnabler.php");

class JSONEnablerTest extends TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testDefaultValues()
    {
        $test = new JSONEnabler();
        $this->assertEquals("application/json", $test->getType());
        $this->assertEquals("utf-8", $test->getCharset());
    }

    /**
     * @runInSeparateProcess
     */
    public function testCustomValues()
    {
        $test = new JSONEnabler("someType", "someCharSet");
        $this->assertEquals("someType", $test->getType());
        $this->assertEquals("someCharSet", $test->getCharset());
    }
}
