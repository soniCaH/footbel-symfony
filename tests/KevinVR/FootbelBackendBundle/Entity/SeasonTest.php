<?php

namespace Tests\KevinVR\FootbelBackendBundle\Entity;

use KevinVR\FootbelBackendBundle\Entity\Season;

class SeasonTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor() {
        $season = new Season('1516', '2015 - 2016', new \DateTime('July 1 2015'), new \DateTime('June 30 2016'));

        $this->assertEquals('2015 - 2016', $season->getLabel());
        $this->assertEquals('01/07/2015', $season->getStart()->format('d/m/Y'));
    }
}