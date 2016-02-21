<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

interface ResourceProcessorInterface
{
    /**
     * Process one data row.
     *
     * @param array $row
     *   Row with data.
     */
    public static function process($row);
}
