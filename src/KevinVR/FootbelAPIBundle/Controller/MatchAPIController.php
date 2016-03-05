<?php

namespace KevinVR\FootbelAPIBundle\Controller;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\Controller\Annotations as Rest;
use KevinVR\FootbelBackendBundle\Entity\Level;
use KevinVR\FootbelBackendBundle\Entity\Province;
use KevinVR\FootbelBackendBundle\Entity\Season;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MatchAPIController
 * @package KevinVR\FootbelAPIBundle\Controller
 */
class MatchAPIController extends FOSRestController
{
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
    public function getMatchesPerRegnrNextAction(Season $season, $regnumber, Request $request)
    {
        $matches = $this->_getMatchesBySeasonAndRegnr($season, $regnumber);

        $output = $this->_getDetails($matches);

        $this->container->get('google_analytics')->sendData($request, 'api_matches_get_matches_per_regnr_next');

        return $output;
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
    public function getMatchesPerRegnrPrevAction(Season $season, $regnumber)
    {
        $matches = $this->_getMatchesBySeasonAndRegnr($season, $regnumber, 'prev');

        $output = $this->_getDetails($matches);

        return $output;
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
    public function getMatchesPerRegnrDivisionNextAction(Season $season, $regnumber, $division, $number = 1)
    {
        $matches = $this->_getMatchesByRegnrAndDivision($season, $regnumber, $division, 'next', $number);

        $output = $this->_getDetails($matches);

        return $output;
    }

    /**
     * Retrieve a specified number (default 1) previous matches for a team of a specified reg number in a specific division.
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param string $regnumber
     * @param string $division
     * @param int $number
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/prev/{shorthand_season}/{regnumber}/{division}/{number}", defaults={"number" = 1})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getMatchesPerRegnrDivisionPrevAction(Season $season, $regnumber, $division, $number = 1)
    {
        $matches = $this->_getMatchesByRegnrAndDivision($season, $regnumber, $division, 'prev', $number);

        $output = $this->_getDetails($matches);

        return $output;
    }

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
     * @Rest\Get("/matches/prov/{shorthand_province}/{shorthand_season}/{division}/{matchday}", defaults={"matchday" = 0})
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

    private function _getMatchesBySeasonAndRegnr(Season $season, $regnumber, $direction = 'next')
    {
        $em = $this->getDoctrine()->getManager();

        switch ($direction) {
            case 'prev':
                $time_where = 'g.datetime < :time';
                $order = 'DESC';
                break;
            case 'next':
            default:
                $time_where = 'g.datetime >= :time';
                $order = 'ASC';
                break;
        }

        $divisions = $this->_getDivisionsPerSeason($em, $season, $regnumber);

        if (empty($divisions)) {
            return array();
        }

        foreach ($divisions as $division) {
            $matches_query = $em->getRepository('FootbelBackendBundle:Game')
                ->createQueryBuilder('g')
                ->where('g.division = :division')
                ->andWhere('g.homeRegnr = :home_regnr OR g.awayRegnr = :away_regnr')
                ->andWhere($time_where)
                ->setParameter('division', $division)
                ->setParameter('home_regnr', $regnumber)
                ->setParameter('away_regnr', $regnumber)
                ->setParameter('time', new \DateTime())
                ->orderBy('g.datetime', $order)
                ->getQuery();

            $result = $matches_query->setMaxResults(1)->getOneOrNullResult();
            if ($result) {
                $matches[] = $result;
            }
        }

        return $matches;
    }

    private function _getDivisionsPerSeason(EntityManager $em, Season $season, $regnumber)
    {
        $division = $em->getRepository('FootbelBackendBundle:Game')
            ->createQueryBuilder('g')
            ->select('g.division')
            ->where('g.season = :season')
            ->andWhere('g.homeRegnr = :home_regnr OR g.awayRegnr = :away_regnr')
            ->setParameter('season', $season)
            ->setParameter('home_regnr', $regnumber)
            ->setParameter('away_regnr', $regnumber)
            ->distinct()
            ->orderBy('g.datetime')
            ->getQuery();

        $divisions = $division->getResult();

        return array_column($divisions, 'division');
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
                'score_home' => ($match->getScoreHome()) ? $match->getScoreHome() : '',
                'score_away' => ($match->getScoreAway()) ? $match->getScoreAway() : '',
                'status' => $match->getStatus(),
                'logo_home' => '/logo/'.$match->getHomeRegnr(),
                'logo_away' => '/logo/'.$match->getAwayRegnr(),
            );
        }

        return $matchOutput;
    }

    private function _getMatchesBySeasonAndDivisionPerLevel(
        Level $level,
        Season $season,
        $division,
        Province $province = null,
        $matchday = 0
    ) {
        $em = $this->getDoctrine()->getManager();

        if ($matchday) {
            $criteria = array(
                'season' => $season,
                'level' => $level,
                'province' => $province,
                'division' => $division,
                'matchday' => $matchday,
            );
        } else {
            $criteria = array(
                'season' => $season,
                'level' => $level,
                'province' => $province,
                'division' => $division,
            );
        }


        $matches = $em->getRepository('FootbelBackendBundle:Game')->findBy($criteria);

        return $matches;

    }

    private function _getMatchesByRegnrAndDivision(Season $season, $regnumber, $division, $direction = 'next', $number)
    {
        $em = $this->getDoctrine()->getManager();

        switch ($direction) {
            case 'prev':
                $time_where = 'g.datetime < :time';
                $order = 'DESC';
                break;
            case 'next':
            default:
                $time_where = 'g.datetime >= :time';
                $order = 'ASC';
                break;
        }

        $matches = array();

        $matches_query = $em->getRepository('FootbelBackendBundle:Game')
            ->createQueryBuilder('g')
            ->where('g.division = :division')
            ->andWhere('g.season = :season')
            ->andWhere('g.homeRegnr = :home_regnr OR g.awayRegnr = :away_regnr')
            ->andWhere($time_where)
            ->setParameter('season', $season)
            ->setParameter('division', $division)
            ->setParameter('home_regnr', $regnumber)
            ->setParameter('away_regnr', $regnumber)
            ->setParameter('time', new \DateTime())
            ->orderBy('g.datetime', $order)
            ->getQuery();

        $result = $matches_query->setMaxResults($number)->getResult();
        if ($result) {
            $matches = $result;
        }

        return $matches;
    }
}