<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

interface ResourceProcessorInterface
{
    public function process($start, $limit);
}
