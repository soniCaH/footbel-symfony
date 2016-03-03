<?php

namespace KevinVR\FootbelAPIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use KevinVR\FootbelBackendBundle\Entity\Level;
use KevinVR\FootbelBackendBundle\Entity\Province;
use KevinVR\FootbelBackendBundle\Entity\Season;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class RankingController extends FOSRestController
{
    /**
     * Retrieve province rankings with optional period.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Province $province
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param string $division
     * @param int $period
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/ranking/{shorthand_province}/{shorthand_season}/{division}/{period}", name="ranking_province", defaults={"period" = 0})
     * @ParamConverter("province", options={"mapping": {"shorthand_province": "shorthand"}})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Method("GET")
     */
    public function getRankingPerProvinceAction(Province $province, Season $season, $division, $period)
    {
        $em = $this->getDoctrine()->getManager();

        // Retrieve the ranking based on shorthand.
        $level = $em->getRepository('FootbelBackendBundle:Level')->findOneBy(array('shorthand' => 'prov'));

        $ranks = $this->_getRankingPerLevel($level, $season, $province, $division, $period);

        $rankings = $this->_getDetails($ranks);

        return $rankings;
    }

    private function _getRankingPerLevel(Level $level, Season $season, $province, $division, $period = 0)
    {
        $em = $this->getDoctrine()->getManager();

        $rankings = $em->getRepository('FootbelBackendBundle:Ranking')->findBy(
            array(
                'season' => $season,
                'level' => $level,
                'province' => $province,
                'division' => $division,
                'period' => $period,
            )
        );

        return $rankings;
    }

    private function _getDetails($rankings)
    {
        $rank_output = array();

        usort(
            $rankings,
            function ($a, $b) {
                return strcmp($a->getPosition(), $b->getPosition());
            }
        );

        foreach ($rankings as $ranking) {
            $rank_output[] = array(
                'season' => $ranking->getSeason()->getShorthand(),
                'level' => $ranking->getLevel()->getShorthand(),
                'province' => $ranking->getProvince()->getShorthand(),
                'division' => $ranking->getDivision(),
                'team' => $ranking->getTeam(),
                'matches' => $ranking->getMatches(),
                'wins' => $ranking->getWins(),
                'losses' => $ranking->getLosses(),
                'draws' => $ranking->getDraws(),
                'goals_pro' => $ranking->getGoalsPro(),
                'goals_against' => $ranking->getGoalsAgainst(),
                'goals_diff' => $ranking->getGoalsDifference(),
                'points' => $ranking->getPoints(),
                'period' => $ranking->getPeriod(),
                'position' => $ranking->getPosition(),
            );
        }

        return $rank_output;
    }
}
