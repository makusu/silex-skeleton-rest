<?php

namespace SomeBundle\Tests\SomeNamespace;

use SomeBundle\SomeNamespace\SomeClass;

class SomeClassTest extends \PHPUnit_Framework_Testcase {

    private $someClass;

    public function setUp() {
        $this->someClass = new SomeClass();
    }

    public function tearDown() {
        unset($this->someClass);
    }

    public function testPlus() {
        $this->assertEquals($this->someClass->plus(5, 1), 6);
    }

    public function testMinus() {
        $this->assertEquals($this->someClass->minus(5, 1), 4);
    }

}
