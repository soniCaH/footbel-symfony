<?php

namespace KevinVR\FootbelAPIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations as Rest;
use KevinVR\FootbelBackendBundle\Entity\Level;
use KevinVR\FootbelBackendBundle\Entity\Province;
use KevinVR\FootbelBackendBundle\Entity\Season;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class RankingController extends FOSRestController
{
    /**
     * Retrieve national rankings with optional period.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param string $division
     * @param int $period
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/ranking/national/{shorthand_season}/{division}/{period}", name="ranking_national", defaults={"period" = 0})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Method("GET")
     * @Rest\View
     */
    public function getRankingNationalAction(Season $season, $division, $period)
    {
        $em = $this->getDoctrine()->getManager();

        // Retrieve the ranking based on shorthand.
        $level = $em->getRepository('FootbelBackendBundle:Level')->findOneBy(array('shorthand' => 'nat'));

        $ranks = $this->_getRankingPerLevel($level, $season, $division, null, $period);

        $rankings = $this->_getDetails($ranks);

        return $rankings;
    }

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
     * @Rest\View
     */
    public function getRankingPerProvinceAction(Province $province, Season $season, $division, $period)
    {
        $em = $this->getDoctrine()->getManager();

        // Retrieve the ranking based on shorthand.
        $level = $em->getRepository('FootbelBackendBundle:Level')->findOneBy(array('shorthand' => 'prov'));

        $ranks = $this->_getRankingPerLevel($level, $season, $division, $province, $period);

        $rankings = $this->_getDetails($ranks);

        return $rankings;
    }

    /**
     * General helper to retrieve the rankings.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Level $level
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param string $division
     * @param \KevinVR\FootbelBackendBundle\Entity\Province|null $province
     * @param int $period
     *
     * @return \KevinVR\FootbelBackendBundle\Entity\Ranking[]
     */
    private function _getRankingPerLevel(
        Level $level,
        Season $season,
        $division,
        Province $province = null,
        $period = 0
    ) {
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

    /**
     * Retrieve sorted array of ranking information.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Ranking[] $rankings
     *
     * @return array
     */
    private function _getDetails($rankings)
    {
        $rankOutput = array();

        usort(
            $rankings,
            function ($a, $b) {
                if ($a->getPosition() == $b->getPosition()) {
                    return 0;
                }

                return ($a->getPosition() < $b->getPosition()) ? -1 : 1;

            }
        );

        foreach ($rankings as $ranking) {
            $rankOutput[] = array(
                'season' => $ranking->getSeason()->getShorthand(),
                'level' => $ranking->getLevel()->getShorthand(),
                'province' => ($ranking->getProvince()) ? $ranking->getProvince()->getShorthand() : '',
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

        return $rankOutput;
    }
}
