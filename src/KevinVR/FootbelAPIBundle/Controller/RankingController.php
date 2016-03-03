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
     * @Route("/ranking/{shorthand_province}/{shorthand_season}/{division}/{period}", name="ranking_province", defaults={"period" = 0})
     * @ParamConverter("province", options={"mapping": {"shorthand_province": "shorthand"}})
     * @ParamConverter("season", options={"mapping": {"shorthand_season": "shorthand"}})
     * @Method("GET")
     */
    public function getRankingPerProvinceAction(Province $province, Season $season, $division, $period)
    {
        $em = $this->getDoctrine()->getManager();

        $level = $em->getRepository('FootbelBackendBundle:Level')->findOneBy(array('shorthand' => 'prov'));
        $ranks = $this->getRankingPerLevel($level, $season, $province, $division, $period);

        return $ranks;
    }

    private function getRankingPerLevel(Level $level, Season $season, $province, $division, $period = 0)
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
}
