<?php

namespace KevinVR\FootbalistoProcessorBundle\Processor;

use Doctrine\ORM\EntityManager;

/**
 * Class ResourceProcessor
 * @package KevinVR\FootbalistoProcessorBundle\Processor
 */
abstract class ResourceProcessor implements ResourceProcessorInterface
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

}
