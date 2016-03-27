<?php

namespace KevinVR\FootbalistoProcessorBundle\Processor;

interface ResourceQueueWorkerInterface
{
    /**
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Level $level
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Province $province
     * @param string $filepath
     * @param string $handler
     * @param int $start
     * @param int $limit
     * @return mixed
     */
    public function queue($season, $level, $province, $filepath, $handler, $start = 0, $limit = 50);
}