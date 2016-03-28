<?php

namespace Tests\KevinVR\FootbalistoBackendBundle\Entity;

use KevinVR\FootbalistoBackendBundle\Entity\ResourceType;

class ResourceTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor() {
        $resourceType = new ResourceType('match', 'Matches Resource');

        $this->assertEquals('Matches Resource', $resourceType->getLabel());
    }
}