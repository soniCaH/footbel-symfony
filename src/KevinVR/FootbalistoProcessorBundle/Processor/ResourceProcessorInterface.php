<?php
/**
 * @file
 * Contains KevinVR\FootbalistoProcessorBundle\Processor\ResourceProcessorInterface.
 */

namespace KevinVR\FootbalistoProcessorBundle\Processor;

/**
 * Process a single row entry from a resource.
 *
 * Interface ResourceProcessorInterface
 * @package KevinVR\FootbalistoProcessorBundle\Processor
 */
interface ResourceProcessorInterface
{
    /**
     * Process one data row.
     *
     * @param int $seasonId
     * @param int $levelId
     * @param int $provindeId
     * @param array $row
     *   Row with data.
     */
    public function process($seasonId, $levelId, $provindeId, $row);
}
