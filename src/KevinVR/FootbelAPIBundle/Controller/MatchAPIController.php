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

/**
 * Class MatchAPIController
 * @package KevinVR\FootbelAPIBundle\Controller
 */
class MatchAPIController extends FOSRestController
{
    /**
     * Retrieve matches for a specific (national) division, with optional matchday.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param string $division
     * @param int $matchday
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/national/{shorthand_season}/{division}/{matchday}", defaults={"matchday" = 0})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getMatchesNationalBySeasonAndDivisionAction(Season $season, $division, $matchday)
    {
        $em = $this->getDoctrine()->getManager();

        // Retrieve the ranking based on shorthand.
        $level = $em->getRepository('FootbelBackendBundle:Level')->findOneBy(array('shorthand' => 'nat'));

        $matches = $this->_getMatchesBySeasonAndDivisionPerLevel($level, $season, $division, null, $matchday);

        $output = $this->_getDetails($matches);

        return $output;
    }

    /**
     * Retrieve matches for a specific (province) division, with optional matchday.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Province $province
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param string $division
     * @param int $matchday
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/{shorthand_province}/{shorthand_season}/{division}/{matchday}", defaults={"matchday" = 0})
     * @ParamConverter("province", options={"mapping": {"shorthand_province": "shorthand"}})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getMatchesPerProvinceBySeasonAndDivisionAction(
        Province $province,
        Season $season,
        $division,
        $matchday
    ) {
        $em = $this->getDoctrine()->getManager();

        // Retrieve the ranking based on shorthand.
        $level = $em->getRepository('FootbelBackendBundle:Level')->findOneBy(array('shorthand' => 'prov'));

        $matches = $this->_getMatchesBySeasonAndDivisionPerLevel($level, $season, $division, $province, $matchday);

        $output = $this->_getDetails($matches);

        return $output;
    }

    /**
     * Retrieve next matches for each team (1 per team) of a specified reg number.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param string $regnumber
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/next/{shorthand_season}/{regnumber}")
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getMatchesPerRegnrNextAction($season, $regnumber)
    {

    }

    /**
     * Retrieve previous matches for each team (1 per team) of a specified reg number.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param string $regnumber
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/prev/{shorthand_season}/{regnumber}")
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function matchesPerRegnrPrevAction($season, $regnumber)
    {

    }

    /**
     * Retrieve a specified number (default 1) next matches for a team of a specified reg number in a specific division.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param string $regnumber
     * @param string $division
     * @param int $number
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/next/{shorthand_season}/{regnumber}/{division}/{number}", defaults={"number" = 1})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getMatchesPerRegnrDivisionNextAction($season, $regnumber, $division, $number = 1)
    {

    }

    /**
     * Retrieve a specified number (default 1) previous matches for a team of a specified reg number in a specific division.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param string $regnumber
     * @param string $division
     * @param int $number
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param string $regnumber
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/prev/{season}/{regnumber}/{division}/{number}", defaults={"number" = 1})
     */
    public function getMatchesPerRegnrDivisionPrevAction($season, $regnumber, $division, $number = 1)
    {

    }

    private function _getMatchesBySeasonAndDivisionPerLevel(
        Level $level,
        Season $season,
        $division,
        Province $province = null,
        $matchday = 0
    ) {
        $em = $this->getDoctrine()->getManager();

        $criteria = ($matchday) ? array(
            'season' => $season,
            'level' => $level,
            'province' => $province,
            'division' => $division,
            'matchday' => $matchday,
        ) : array(
            'season' => $season,
            'level' => $level,
            'province' => $province,
            'division' => $division,
        );

        $matches = $em->getRepository('FootbelBackendBundle:Game')->findBy(
            $criteria,
            array('matchday' => 'ASC', 'datetime' => 'ASC')
        );

        return $matches;

    }

    private function _getDetails($matches)
    {
        $matchOutput = array();

        foreach ($matches as $match) {
            $matchOutput[] = array(
                'season' => $match->getSeason()->getShorthand(),
                'level' => $match->getLevel()->getShorthand(),
                'province' => ($match->getProvince()) ? $match->getProvince()->getShorthand() : '',
                'division' => $match->getDivision(),
                'matchday' => $match->getMatchday(),
                'datetime' => $match->getDatetime(),
                'datetime_formatted' => $match->getDatetimeFormatted('D d/m/Y H:i'),
                'home_name' => $match->getHomeName(),
                'home_regnr' => $match->getHomeRegnr(),
                'away_name' => $match->getAwayName(),
                'away_regnr' => $match->getAwayRegnr(),
                'score_home' => $match->getScoreHome(),
                'score_away' => $match->getScoreAway(),
                'status' => $match->getStatus(),
                'logo_home' => '/logo/'.$match->getHomeRegnr(),
                'logo_away' => '/logo/'.$match->getAwayRegnr(),
            );
        }

        return $matchOutput;
    }
}