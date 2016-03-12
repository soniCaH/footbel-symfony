<?php

namespace KevinVR\FootbelAPIBundle\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use KevinVR\FootbelBackendBundle\Entity\Level;
use KevinVR\FootbelBackendBundle\Form\LevelType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Logo controller.
 */
class LogoController extends Controller
{
    /**
     * Display the logo of a regnumber.
     *
     * @param $regnumber
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return BinaryFileResponse|Response
     *
     * @Route("/logo/{regnumber}", name="logo", requirements={"regnumber" = "\d{5}"})
     * @Method("GET")
     */
    public function getLogoAction($regnumber, Request $request)
    {
        $filename = $regnumber.'.jpg';
        $newFilename = sys_get_temp_dir().DIRECTORY_SEPARATOR.$filename;
        if (!file_exists($newFilename)) {
            $url = "http://static.belgianfootball.be/project/publiek/clublogo/".$filename;
            $file = @fopen($url, "rb");
            if ($file) {
                $newFile = fopen($newFilename, "wb");

                if ($newFile) {
                    while (!feof($file)) {
                        fwrite($newFile, fread($file, 1024 * 8), 1024 * 8);
                    }
                }
            }

            if ($file) {
                fclose($file);
            }
        }

        if (!file_exists($newFilename)) {
            $response = new Response('No club with this regnumber found.');

            return $response;
        }

        $this->container->get('google_analytics')->sendData($request, 'api_logo_logo');

        $response = new BinaryFileResponse($newFilename);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE);

        return $response;
    }
}
