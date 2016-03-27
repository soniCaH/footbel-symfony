<?php

namespace KevinVR\FootbalistoAPIBundle\Service;

use Krizon\Google\Analytics\MeasurementProtocol\MeasurementProtocolClient;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GoogleAnalyticsService
 * @package KevinVR\FootbalistoAPIBundle\Service
 */
class GoogleAnalyticsService
{
    private $client;
    private $trackId;

    /**
     * GoogleAnalyticsService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->trackId = $container->getParameter('ga_trackid');

        $config = array(
            'ssl' => true, // Enable/Disable SSL, default false
        );
        $this->client = MeasurementProtocolClient::factory($config);
    }

    /**
     * Send data to Google Analytics.
     *
     * @param Request $request
     * @param $title
     */
    public function sendData(Request $request, $title)
    {
        $this->client->pageview(
            array(
                'tid' => $this->trackId,
                'cid' => $request->getClientIp(),
                'dh' => $_SERVER['SERVER_NAME'],
                'dp' => $request->getRequestUri(),
                'dt' => $title,
            )
        );
    }
}