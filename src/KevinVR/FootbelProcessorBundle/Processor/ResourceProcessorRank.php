<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

/**
 * Class ResourceProcessorRank
 * @package KevinVR\FootbelProcessorBundle\Processor
 */
class ResourceProcessorRank extends ResourceProcessor
{
    /**
     * Process one data row.
     *
     * Headers are:
     * - DIV
     * - POS
     * - TEAM
     * - M
     * - W
     * - L
     * - D
     * - G+
     * - G-
     * - PTS
     * - PER
     *
     * @param array $row
     *   Row with data.
     */
    public function process($row)
    {

        var_dump($row);

    }
}