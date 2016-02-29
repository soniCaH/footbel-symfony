<?php

namespace Tests\KevinVR\FootbelBackendBundle\Entity;

use KevinVR\FootbelBackendBundle\Entity\Province;

class ProvinceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor() {
        $province = new Province('bra', 'Brabant');

        $this->assertEquals('Brabant', $province->getLabel());
    }
}