<?php

namespace Tests\KevinVR\FootbalistoBackendBundle\Entity;

use KevinVR\FootbalistoBackendBundle\Entity\Level;

class LevelTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor() {
        $level = new Level('nat', 'National');

        $this->assertEquals('National', $level->getLabel());
    }
}