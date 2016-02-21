<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

/**
 * Class ResourceProcessorMatch
 * @package KevinVR\FootbelProcessorBundle\Processor
 */
class ResourceProcessorMatch extends ResourceProcessor
{
    /**
     * Process one data row.
     *
     * Headers are:
     * - DIV
     * - DATE
     * - HOUR
     * - HOME
     * - AWAY
     * - RH
     * - RA
     * - STATUS
     * - MD
     * - REGNUMBERHOME
     * - REGNUMBERAWAY
     *
     * @param array $row
     *   Row with data.
     */
    public function process($row)
    {
//        $this->entityManager->getRepository();
        // Retrieve entitymanager.
        var_dump($this->entityManager, $row);
        // Check if entry already exists.
        // If so, retrieve entity.
        // If not, create a new entity object and persist.
    }
}