<?php

namespace KevinVR\FootbalistoProcessorBundle\Processor;

use KevinVR\FootbalistoBackendBundle\Entity\Ranking;

/**
 * Class ResourceProcessorRank
 * @package KevinVR\FootbalistoProcessorBundle\Processor
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
        $seasonRepository = $this->entityManager->getRepository('FootbalistoBackendBundle:Season');
        $levelRepository = $this->entityManager->getRepository('FootbalistoBackendBundle:Level');
        $provinceRepository = $this->entityManager->getRepository('FootbalistoBackendBundle:Province');

        $season = $seasonRepository->find($seasonId);
        $level = $levelRepository->find($levelId);
        $province = null;

        if ($provindeId) {
            $province = $provinceRepository->find($provindeId);
        }

        $div = $row['DIV'];
        $pos = $row['POS'];
        $team = $row['TEAM'];
        $matches = $row['M'];
        $wins = $row['W'];
        $losses = $row['L'];
        $draws = $row['D'];
        $goals_pro = $row['G+'];
        $goals_against = $row['G-'];
        $points = $row['PTS'];
        $period = $row['PER'];

        $rankRepository = $this->entityManager->getRepository('FootbalistoBackendBundle:Ranking');
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