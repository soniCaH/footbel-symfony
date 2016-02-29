<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

use Doctrine\ORM\EntityManager;

/**
 * Class ResourceProcessor
 * @package KevinVR\FootbelProcessorBundle\Processor
 */
abstract class ResourceProcessor implements ResourceProcessorInterface
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

}
