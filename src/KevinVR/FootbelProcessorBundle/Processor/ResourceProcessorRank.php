<?php

namespace KevinVR\FootbelProcessorBundle\Processor;

use KevinVR\FootbelBackendBundle\Entity\Ranking;

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

        $div = utf8_encode($row['DIV']);
        $pos = utf8_encode($row['POS']);
        $team = utf8_encode($row['TEAM']);
        $matches = utf8_encode($row['M']);
        $wins = utf8_encode($row['W']);
        $losses = utf8_encode($row['L']);
        $draws = utf8_encode($row['D']);
        $goals_pro = utf8_encode($row['G+']);
        $goals_against = utf8_encode($row['G-']);
        $points = utf8_encode($row['PTS']);
        $period = utf8_encode($row['PER']);

        $rankRepository = $this->entityManager->getRepository('FootbelBackendBundle:Ranking');
        $ranking = $rankRepository->findOneBy(
            array(
                'season' => $season,
                'level' => $level,
                'province' => $province,
                'division' => $div,
                'period' => $period,
                'team' => $team,
            )
        );

        if (!$ranking) {
            $ranking = new Ranking(
                $season,
                $level,
                $province,
                $div,
                $pos,
                $team,
                $matches,
                $wins,
                $draws,
                $losses,
                $goals_pro,
                $goals_against,
                $points,
                $period
            );
        }
        else {
            $ranking->setPosition($pos);
            $ranking->setMatches($matches);
            $ranking->setWins($wins);
            $ranking->setDraws($draws);
            $ranking->setLosses($losses);
            $ranking->setGoalsPro($goals_pro);
            $ranking->setGoalsAgainst($goals_against);
            $ranking->setPoints($points);
        }

        $this->entityManager->persist($ranking);
        $this->entityManager->flush();

    }
}