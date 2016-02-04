<?php

namespace Tests\KevinVR\FootbelBackendBundle\Entity;

use KevinVR\FootbelBackendBundle\Entity\Level;
use KevinVR\FootbelBackendBundle\Entity\Province;
use KevinVR\FootbelBackendBundle\Entity\Resource;
use KevinVR\FootbelBackendBundle\Entity\ResourceType;
use KevinVR\FootbelBackendBundle\Entity\Season;

class ResourceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $resource = $this->getResourceObject();

        $this->assertEquals('http://domain.ext/url.csv', $resource->getUrl());
    }

    public function testBinding() {
        $resource = $this->getResourceObject();

        $this->assertEquals('Brabant', $resource->getProvince()->getLabel());
        $this->assertEquals('Provincial', $resource->getLevel()->getLabel());
        $this->assertEquals('2015 - 2016', $resource->getSeason()->getLabel());
        $this->assertEquals('match', $resource->getType()->getShorthand());
    }

    /**
     * Helper to create Resource Object.
     *
     * @return \KevinVR\FootbelBackendBundle\Entity\Resource
     */
    private function getResourceObject()
    {
        return new Resource(
            new ResourceType('match', 'Matches'),
            new Season(
                '1516',
                '2015 - 2016',
                new \DateTime('July 1 2015'),
                new \DateTime('June 30 2016')
            ),
            new Level('prov', 'Provincial'),
            new Province('bra', 'Brabant'),
            'http://domain.ext/url.csv'
        );
    }
}