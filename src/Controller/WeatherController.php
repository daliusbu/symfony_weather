<?php

namespace App\Controller;

use App\Model\NullWeather;
use App\Weather\LoaderService;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Psr\SimpleCache\InvalidArgumentException;

class WeatherController extends AbstractController
{
    /**
     * @param               $day
     * @param LoaderService $weatherLoader
     * @return Response
     * @throws InvalidArgumentException
     */
    public function index($day, LoaderService $weatherLoader): Response
    {
        try {
            $weather = $weatherLoader->loadWeatherByDay(new DateTime($day));
        } catch (Exception $exp) {
            $weather = new NullWeather();
        }

        return $this->render('weather/index.html.twig', [
            'weatherData' => [
                'date'      => $weather->getDate()->format('Y-m-d'),
                'dayTemp'   => $weather->getDayTemp(),
                'nightTemp' => $weather->getNightTemp(),
                'sky'       => $weather->getSky(),
                'provider'  => $weather->getProviderName()
            ],
        ]);
    }
}
