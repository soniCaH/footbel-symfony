<?php

namespace KevinVR\FootbalistoBackendBundle\Controller;

use KevinVR\FootbalistoBackendBundle\Entity\Level;
use KevinVR\FootbalistoBackendBundle\Entity\Province;
use KevinVR\FootbalistoBackendBundle\Entity\Resource;
use KevinVR\FootbalistoBackendBundle\Entity\ResourceType;
use KevinVR\FootbalistoBackendBundle\Entity\Season;
use KevinVR\FootbalistoBackendBundle\Form\LevelForm;
use KevinVR\FootbalistoBackendBundle\Form\ResourceTypeForm;
use KevinVR\FootbalistoBackendBundle\Form\SeasonForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use KevinVR\FootbalistoBackendBundle\Form\ProvinceForm;
use KevinVR\FootbalistoBackendBundle\Form\ResourceForm;

class DefaultController extends Controller
{
    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("/", name="admin_homepage")
     */
    public function indexAction(Request $request)
    {
        $overviews = array(
            'resourcetype_index' => 'Resource Type',
            'season_index' => 'Seasons',
            'level_index' => 'Levels',
            'province_index' => 'Provinces',
            'resource_index' => 'Resources',
        );

        $build['overviews'] = $overviews;

        return $this->render(
          'FootbalistoBackendBundle:Default:index.html.twig',
          $build
        );
    }
}
