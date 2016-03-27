<?php

namespace Tests\KevinVR\FootbalistoBackendBundle\Entity;

use KevinVR\FootbalistoBackendBundle\Entity\Province;

class ProvinceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor() {
        $province = new Province('bra', 'Brabant');

        $this->assertEquals('Brabant', $province->getLabel());
    }
}