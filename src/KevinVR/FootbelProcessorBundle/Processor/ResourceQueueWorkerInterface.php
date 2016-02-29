<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

interface ResourceQueueWorkerInterface
{
    /**
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param \KevinVR\FootbelBackendBundle\Entity\Level $level
     * @param \KevinVR\FootbelBackendBundle\Entity\Province $province
     * @param string $filepath
     * @param string $handler
     * @param int $start
     * @param int $limit
     * @return mixed
     */
    public function queue($season, $level, $province, $filepath, $handler, $start = 0, $limit = 50);
}