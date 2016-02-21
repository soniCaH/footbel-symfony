<?php
/**
 * @file
 * Contains KevinVR\FootbelProcessorBundle\Processor\ResourceProcessorInterface.
 */

namespace KevinVR\FootbelProcessorBundle\Processor;

/**
 * Process a single row entry from a resource.
 *
 * Interface ResourceProcessorInterface
 * @package KevinVR\FootbelProcessorBundle\Processor
 */
interface ResourceProcessorInterface
{
    /**
     * Process one data row.
     *
     * @param array $row
     *   Row with data.
     */
    public function process($row);
}
