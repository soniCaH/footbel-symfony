<?php

namespace Tests\KevinVR\FootbelBackendBundle\Entity;

use KevinVR\FootbelBackendBundle\Entity\ResourceType;

class ResourceTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor() {
        $resourceType = new ResourceType('match', 'Matches Resource');

        $this->assertEquals('Matches Resource', $resourceType->getLabel());
    }
}