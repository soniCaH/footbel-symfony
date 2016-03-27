<?php

namespace KevinVR\FootbalistoProcessorBundle\Processor;

use KevinVR\FootbalistoBackendBundle\Entity\Game;
use KevinVR\FootbalistoBackendBundle\Entity\Season;
use Symfony\Component\Debug\Exception\ContextErrorException;

/**
 * Class ResourceProcessorMatch
 * @package KevinVR\FootbalistoProcessorBundle\Processor
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
     * @param int $seasonId
     * @param int $levelId
     * @param int $provindeId
     * @param array $row
     *   Row with data.
     */
    public function process($seasonId, $levelId, $provindeId, $row)
    {
        $seasonRepository = $this->entityManager->getRepository('FootbelBackendBundle:Season');
        $levelRepository = $this->entityManager->getRepository('FootbelBackendBundle:Level');
        $provinceRepository = $this->entityManager->getRepository('FootbelBackendBundle:Province');

        $season = $seasonRepository->find($seasonId);
        $level = $levelRepository->find($levelId);
        $province = null;

        if ($provindeId) {
            $province = $provinceRepository->find($provindeId);
        }

        try {
            $div = $row['DIV'];
            $md = $row['MD'];
            $regnumberhome = $row['REGNUMBERHOME'];
            $regnumberaway = $row['REGNUMBERAWAY'];
            $date = $row['DATE'];
            $hour = $row['HOUR'];
            $home = $row['HOME'];
            $away = $row['AWAY'];
            $rh = ($row['RH'] !== "") ? intval($row['RH']) : null;
            $ra = ($row['RA'] !== "") ? intval($row['RA']) : null;
            $status = $row['STATUS'];

            $matchRepository = $this->entityManager->getRepository('FootbelBackendBundle:Game');
            $match = $matchRepository->findOneBy(
                array(
                    'season' => $season,
                    'level' => $level,
                    'province' => $province,
                    'division' => $div,
                    'matchday' => $md,
                    'homeRegnr' => $regnumberhome,
                    'awayRegnr' => $regnumberaway,
                )
            );

            $datetime = \DateTime::createFromFormat('d/m/Y H:i', $date.' '.$hour);

            if (!$match) {
                $match = new Game(
                    $season,
                    $level,
                    $province,
                    $div,
                    $md,
                    $datetime,
                    $home,
                    $away,
                    $regnumberhome,
                    $regnumberaway,
                    $rh,
                    $ra,
                    $status
                );
            } else {
                $match->setScoreHome($rh);
                $match->setScoreAway($ra);
                $match->setStatus($status);
                $match->setDatetime($datetime);
            }

            $this->entityManager->persist($match);
            $this->entityManager->flush();
        } catch (ContextErrorException $contextException) {
            // Ignore error, process next match.
            // @TODO: Error Logging.
        }
    }
}