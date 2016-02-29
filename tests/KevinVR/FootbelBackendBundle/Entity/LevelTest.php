<?php

namespace Tests\KevinVR\FootbelBackendBundle\Entity;

use KevinVR\FootbelBackendBundle\Entity\Level;

class LevelTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor() {
        $level = new Level('nat', 'National');

        $this->assertEquals('National', $level->getLabel());
    }
}