<?php

namespace KevinVR\FootbalistoAPIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations as Rest;
use KevinVR\FootbalistoBackendBundle\DivisionsMapping;
use KevinVR\FootbalistoBackendBundle\Entity\Level;
use KevinVR\FootbalistoBackendBundle\Entity\Province;
use KevinVR\FootbalistoBackendBundle\Entity\Season;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RankingController
 * @package KevinVR\FootbalistoAPIBundle\Controller
 */
class RankingAPIController extends FOSRestController
{
    /**
     * Retrieve national rankings with optional period.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param string $division
     * @param int $period
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/ranking/national/{shorthand_season}/{division}/{period}", defaults={"period" = 0})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getRankingNationalAction(Season $season, $division, $period, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Retrieve the ranking based on shorthand.
        $level = $em->getRepository('FootbalistoBackendBundle:Level')->findOneBy(array('shorthand' => 'nat'));

        $rankings = $this->_getRankingPerLevel($level, $season, $division, null, $period);

        $output = $this->_getDetails($rankings);

        $user = $this->getUser();
        $this->container->get('google_analytics')->sendData($request, 'api_rankings_get_ranking_national', $user);

        return $output;
    }

    /**
     * Retrieve province rankings with optional period.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Province $province
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param string $division
     * @param int $period
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/ranking/prov/{shorthand_province}/{shorthand_season}/{division}/{period}", defaults={"period" = 0})
     * @ParamConverter("province", options={"mapping": {"shorthand_province": "shorthand"}})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getRankingPerProvinceAction(Province $province, Season $season, $division, $period, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Retrieve the ranking based on shorthand.
        $level = $em->getRepository('FootbalistoBackendBundle:Level')->findOneBy(array('shorthand' => 'prov'));

        $ranks = $this->_getRankingPerLevel($level, $season, $division, $province, $period);

        $rankings = $this->_getDetails($ranks);

        $user = $this->getUser();
        $this->container->get('google_analytics')->sendData($request, 'api_rankings_get_ranking_per_province', $user);

        return $rankings;
    }

    /**
     * Retrieve short national rankings with optional period for a specific team.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param string $division
     * @param string $teamname
     * @param int $number
     * @param int
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/ranking/short/national/{shorthand_season}/{division}/{teamname}/{number}/{period}", defaults={"period" = 0, "number" = 5})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getRankingNationalShortAction(
        Season $season,
        $division,
        $teamname,
        $number,
        $period, Request $request
    ) {
        $em = $this->getDoctrine()->getManager();

        // Retrieve the ranking based on shorthand.
        $level = $em->getRepository('FootbalistoBackendBundle:Level')->findOneBy(array('shorthand' => 'nat'));

        $ranks = $this->_getRankingPerLevel($level, $season, $division, null, $period);

        $rankings = $this->_getDetailsShort($ranks, $teamname, $number);

        $user = $this->getUser();
        $this->container->get('google_analytics')->sendData($request, 'api_rankings_get_ranking_national_short', $user);

        return $rankings;
    }

    /**
     * Retrieve province rankings with optional period.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Province $province
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param string $division
     * @param string $teamname
     * @param int $number
     * @param int $period
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/ranking/short/prov/{shorthand_province}/{shorthand_season}/{division}/{teamname}/{number}/{period}", defaults={"period" = 0, "number" = 5})
     * @ParamConverter("province", options={"mapping": {"shorthand_province": "shorthand"}})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getRankingPerProvinceShortAction(
        Province $province,
        Season $season,
        $division,
        $teamname,
        $number,
        $period, Request $request
    ) {
        $em = $this->getDoctrine()->getManager();

        // Retrieve the ranking based on shorthand.
        $level = $em->getRepository('FootbalistoBackendBundle:Level')->findOneBy(array('shorthand' => 'prov'));

        $ranks = $this->_getRankingPerLevel($level, $season, $division, $province, $period);

        $rankings = $this->_getDetailsShort($ranks, $teamname, $number);

        $user = $this->getUser();
        $this->container->get('google_analytics')->sendData($request, 'api_rankings_get_ranking_per_province_short', $user);

        return $rankings;
    }

    /**
     * General helper to retrieve the rankings.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Level $level
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param string $division
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Province|null $province
     * @param int $period
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \KevinVR\FootbalistoBackendBundle\Entity\Ranking[]
     */
    private function _getRankingPerLevel(
        Level $level,
        Season $season,
        $division,
        Province $province = null,
        $period = 0
    ) {
        $em = $this->getDoctrine()->getManager();

        $rankings = $em->getRepository('FootbalistoBackendBundle:Ranking')->findBy(
            array(
                'season' => $season,
                'level' => $level,
                'province' => $province,
                'division' => $division,
                'period' => $period,
            ),
            array('position' => 'ASC')
        );

        return $rankings;
    }

    /**
     * Retrieve sorted array of ranking information.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Ranking[] $rankings
     *
     * @return array
     */
    private function _getDetails($rankings)
    {
        $rankOutput = array();

        foreach ($rankings as $ranking) {
            $rankOutput[] = array(
                'season' => $ranking->getSeason()->getShorthand(),
                'level' => $ranking->getLevel()->getShorthand(),
                'province' => ($ranking->getProvince()) ? $ranking->getProvince()->getShorthand() : '',
                'division' => $ranking->getDivision(),
                'division_mapped' => DivisionsMapping::getMapping($ranking->getDivision()),
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

    /**
     * Retrieve sorted array of ranking information.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Ranking[] $rankings
     * @param string $teamName
     * @param int $number
     *
     * @return array
     */
    private function _getDetailsShort($rankings, $teamName, $number = 5)
    {
        // Search wanted team.
        $result = array_filter(
            $rankings,
            function ($ranking) use ($teamName) {
                return strpos($ranking->getTeam(), urldecode($teamName)) !== false;
            }
        );

        if (!$result) {
            return array();
        }

        // Get the key of our wanted team.
        $allKeys = array_keys($result);

        $teamNameKey = reset($allKeys);

        // Get the position of the key (associative array), needed to slice.
        $teamNameKeyPosition = array_search($teamNameKey, array_keys($rankings));

        // Get teams above our wanted team.
        $above = array_slice($rankings, 0, $teamNameKeyPosition);
        // Get teams below our wanted team.
        $below = array_slice($rankings, $teamNameKeyPosition + 1);

        // Check if there are equal to/more rankings than requested.
        if (count($rankings) < $number) {
            $number = count($rankings);
        }

        // Calculate how many teams we need above and below.
        $numberBelow = $numberAbove = (int) ($number / 2);

        // Check if there are enough rankings above the requested team.
        if (count($above) < $numberAbove) {
            // Nope, more rankings below needed.
            $numberBelow = $numberBelow + ($numberAbove - count($above));
            $numberAbove = count($above);
        }

        // Check if there are enough rankings below the requested team.
        if (count($below) < $numberBelow) {
            // Nope, more rankings below needed.
            $numberAbove = $numberAbove + ($numberBelow - count($below));
            $numberBelow = count($below);
        }

        // If number is even, we'll have too many results.
        // Drop "above" if possible. Else below.
        while ($number < ($numberAbove + $numberBelow + 1)) {
            if ($numberAbove > 0) {
                $numberAbove--;
            } else {
                $numberBelow--;
            }
        }

        // Start popping/shifting.

        // Populate above. Need to start from the bottom of the array.
        $popping = 1;
        while ($popping <= $numberAbove) {
            $rankingObjectsFiltered[0 - $popping++] = array_pop($above);
        }

        // Populate below. Need to start from the top of the array.
        $shifting = 1;
        while ($shifting <= $numberBelow) {
            $rankingObjectsFiltered[0 + $shifting++] = array_shift($below);
        }

        $rankingObjectsFiltered[0] = $rankings[$teamNameKey];

        ksort($rankingObjectsFiltered);

        return $this->_getDetails($rankingObjectsFiltered);
    }
}
