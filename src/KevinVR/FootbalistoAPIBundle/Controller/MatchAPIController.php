<?php

namespace KevinVR\FootbalistoAPIBundle\Controller;

use Doctrine\ORM\EntityManager;
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
 * Class MatchAPIController
 * @package KevinVR\FootbalistoAPIBundle\Controller
 */
class MatchAPIController extends FOSRestController
{
    /**
     * Retrieve next matches for each team (1 per team) of a specified reg number.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param string $regnumber
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/next/{shorthand_season}/{regnumber}")
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getMatchesPerRegnrNextAction(
      Season $season,
      $regnumber,
      Request $request
    ) {
        $matches = $this->_getMatchesBySeasonAndRegnr($season, $regnumber);

        $output = $this->_getDetails($matches);

        $user = $this->getUser();
        $this->container->get('google_analytics')
          ->sendData($request, 'api_matches_get_matches_per_regnr_next', $user);

        return $output;
    }

    /**
     * Retrieve previous matches for each team (1 per team) of a specified reg number.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param string $regnumber
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/prev/{shorthand_season}/{regnumber}")
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getMatchesPerRegnrPrevAction(
      Season $season,
      $regnumber,
      Request $request
    ) {
        $matches = $this->_getMatchesBySeasonAndRegnr(
          $season,
          $regnumber,
          'prev'
        );

        $output = $this->_getDetails($matches);

        $user = $this->getUser();
        $this->container->get('google_analytics')
          ->sendData($request, 'api_matches_get_matches_per_regnr_prev', $user);

        return $output;
    }

    /**
     * Retrieve a specified number (default 1) next matches for a team of a specified reg number in a specific division.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param string $regnumber
     * @param string $division
     * @param int $number
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/next/{shorthand_season}/{regnumber}/{division}/{number}", defaults={"number" = 1})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getMatchesPerRegnrDivisionNextAction(
      Season $season,
      $regnumber,
      $division,
      $number,
      Request $request
    ) {
        $matches = $this->_getMatchesByRegnrAndDivision(
          $season,
          $regnumber,
          $division,
          'next',
          $number
        );

        $output = $this->_getDetails($matches);

        $user = $this->getUser();
        $this->container->get('google_analytics')
          ->sendData(
            $request,
            'api_matches_get_matches_per_regnr_division_next',
            $user
          );

        return $output;
    }

    /**
     * Retrieve a specified number (default 1) previous matches for a team of a specified reg number in a specific division.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param string $regnumber
     * @param string $division
     * @param int $number
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/prev/{shorthand_season}/{regnumber}/{division}/{number}", defaults={"number" = 1})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getMatchesPerRegnrDivisionPrevAction(
      Season $season,
      $regnumber,
      $division,
      $number,
      Request $request
    ) {
        $matches = $this->_getMatchesByRegnrAndDivision(
          $season,
          $regnumber,
          $division,
          'prev',
          $number
        );

        $output = $this->_getDetails($matches);

        $user = $this->getUser();
        $this->container->get('google_analytics')
          ->sendData(
            $request,
            'api_matches_get_matches_per_regnr_division_prev',
            $user
          );

        return $output;
    }

    /**
     * Retrieve matches for a specific (national) division, with optional matchday.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param string $division
     * @param int $matchday
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Rest\Get("/matches/national/{shorthand_season}/{division}/{matchday}", defaults={"matchday" = 0})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Rest\View
     */
    public function getMatchesNationalBySeasonAndDivisionAction(
      Season $season,
      $division,
      $matchday,
      Request $request
    ) {
        $em = $this->getDoctrine()->getManager();

        // Retrieve the ranking based on shorthand.
        $level = $em->getRepository('FootbalistoBackendBundle:Level')
          ->findOneBy(array('shorthand' => 'nat'));

        $matches = $this->_getMatchesBySeasonAndDivisionPerLevel(
          $level,
          $season,
          $division,
          null,
          $matchday
        );

        $output = $this->_getDetails($matches);

        $user = $this->getUser();
        $this->container->get('google_analytics')
          ->sendData(
            $request,
            'api_matches_get_matches_national_by_season_and_division',
            $user
          );

        return $output;
    }

    /**
     * Retrieve matches for a specific (province) division, with optional matchday.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Province $province
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param string $division
     * @param int $matchday
     * @param \Symfony\Component\HttpFoundation\Request $request
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
      $matchday,
      Request $request
    ) {
        $em = $this->getDoctrine()->getManager();

        // Retrieve the ranking based on shorthand.
        $level = $em->getRepository('FootbalistoBackendBundle:Level')
          ->findOneBy(array('shorthand' => 'prov'));

        $matches = $this->_getMatchesBySeasonAndDivisionPerLevel(
          $level,
          $season,
          $division,
          $province,
          $matchday
        );

        $output = $this->_getDetails($matches);

        $user = $this->getUser();
        $this->container->get('google_analytics')
          ->sendData(
            $request,
            'api_matches_get_matches_per_province_by_season_and_division',
            $user
          );

        return $output;
    }

    /**
     * Retrieve all upcoming or previous matches a club plays in a given season.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param $regnumber
     * @param string $direction
     *
     * @return array
     */
    private function _getMatchesBySeasonAndRegnr(
      Season $season,
      $regnumber,
      $direction = 'next'
    ) {
        $em = $this->getDoctrine()->getManager();

        switch ($direction) {
            case 'prev':
                $time_where = 'g.datetime < :time AND g.datetime > :timeprev';
                $order = 'DESC';
                break;
            case 'next':
            default:
                $time_where = 'g.datetime >= :time';
                $order = 'ASC';
                break;
        }

        $divisions = $this->_getDivisionsPerSeason($em, $season, $regnumber);

        $matches = array();

        if (empty($divisions)) {
            return $matches;
        }

        foreach ($divisions as $division) {
            $matches_query = $em->getRepository('FootbalistoBackendBundle:Game')
              ->createQueryBuilder('g')
              ->where('g.division = :division')
              ->andWhere(
                'g.homeRegnr = :home_regnr OR g.awayRegnr = :away_regnr'
              )
              ->andWhere($time_where)
              ->setParameter('division', $division)
              ->setParameter('home_regnr', $regnumber)
              ->setParameter('away_regnr', $regnumber)
              ->setParameter('time', new \DateTime());

            if ($direction == 'prev') {
                $matches_query = $matches_query->setParameter('timeprev', new \DateTime('- 1 MONTH'));
            }

            $matches_query = $matches_query
              ->orderBy('g.datetime', $order)
              ->getQuery();

            $result = $matches_query->setMaxResults(1)->getOneOrNullResult();
            if ($result) {
                $matches[] = $result;
            }
        }

        return $matches;
    }

    /**
     * Retrieve all the divisions a club will play in, in a given season.
     *
     * @param \Doctrine\ORM\EntityManager $em
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param $regnumber
     * @return array
     */
    private function _getDivisionsPerSeason(
      EntityManager $em,
      Season $season,
      $regnumber
    ) {
        $division = $em->getRepository('FootbalistoBackendBundle:Game')
          ->createQueryBuilder('g')
          ->select('g.division')
          ->distinct()
          ->where('g.season = :season')
          ->andWhere('g.homeRegnr = :home_regnr OR g.awayRegnr = :away_regnr')
          ->setParameter('season', $season)
          ->setParameter('home_regnr', $regnumber)
          ->setParameter('away_regnr', $regnumber)
          ->getQuery();

        $divisions = $division->getResult();

        return array_column($divisions, 'division');
    }

    /**
     * Get details of all matches in an array.
     *
     * @param array $matches
     * @return array
     */
    private function _getDetails($matches)
    {
        $matchOutput = array();

        if (empty($matches)) {
            return $matchOutput;
        }

        foreach ($matches as $match) {
            $matchOutput[] = array(
              'season' => $match->getSeason()->getShorthand(),
              'level' => $match->getLevel()->getShorthand(),
              'province' => ($match->getProvince()) ? $match->getProvince()
                ->getShorthand() : '',
              'division' => $match->getDivision(),
              'division_mapped' => DivisionsMapping::getMapping(
                $match->getDivision()
              ),
              'matchday' => $match->getMatchday(),
              'datetime' => $match->getDatetime(),
              'datetime_formatted' => $match->getDatetimeFormatted(
                'D d/m/Y H:i'
              ),
              'home_name' => $match->getHomeName(),
              'home_regnr' => $match->getHomeRegnr(),
              'away_name' => $match->getAwayName(),
              'away_regnr' => $match->getAwayRegnr(),
              'score_home' => ($match->getScoreHome(
                ) !== 0) ? $match->getScoreHome() : 0,
              'score_away' => ($match->getScoreAway(
                ) !== 0) ? $match->getScoreAway() : 0,
              'status' => $match->getStatus(),
              'logo_home' => '/logo/'.$match->getHomeRegnr(),
              'logo_away' => '/logo/'.$match->getAwayRegnr(),
            );
        }

        return $matchOutput;
    }

    /**
     * Retrieve all matches being played in a given season and level/division.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Level $level
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param $division
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Province|NULL $province
     * @param int $matchday
     * @return array
     */
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


        $matches = $em->getRepository('FootbalistoBackendBundle:Game')
          ->findBy($criteria);

        return $matches;

    }

    /**
     * Retrieve all next/prev matches a club plays in a given division/season.
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param $regnumber
     * @param $division
     * @param string $direction
     * @param $number
     * @return array
     */
    private function _getMatchesByRegnrAndDivision(
      Season $season,
      $regnumber,
      $division,
      $direction = 'next',
      $number
    ) {
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

        $matches_query = $em->getRepository('FootbalistoBackendBundle:Game')
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