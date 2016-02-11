<?php

namespace KevinVR\FootbelBackendBundle\Controller;

use KevinVR\FootbelBackendBundle\Entity\Level;
use KevinVR\FootbelBackendBundle\Entity\Province;
use KevinVR\FootbelBackendBundle\Entity\Resource;
use KevinVR\FootbelBackendBundle\Entity\ResourceType;
use KevinVR\FootbelBackendBundle\Entity\Season;
use KevinVR\FootbelBackendBundle\Form\LevelForm;
use KevinVR\FootbelBackendBundle\Form\ResourceTypeForm;
use KevinVR\FootbelBackendBundle\Form\SeasonForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use KevinVR\FootbelBackendBundle\Form\ProvinceForm;
use KevinVR\FootbelBackendBundle\Form\ResourceForm;

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
          'FootbelBackendBundle:Default:index.html.twig',
          $build
        );
    }
}
