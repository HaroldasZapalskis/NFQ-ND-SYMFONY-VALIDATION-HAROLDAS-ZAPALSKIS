<?php

namespace App\Controller;

use App\Model\NullWeather;
use App\Weather\LoaderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use App\Validation\ValidationService;

class WeatherController extends AbstractController
{
    /**
     * @param               $day
     * @param LoaderService $weatherLoader
     * @param ValidationService $validationService
     * @return Response
     * @throws InvalidArgumentException
     */
    public function index($day, LoaderService $weatherLoader, ValidationService $validationService): Response
    {
        try {
            $error = $validationService->validate($day);
            if($day === null || !$error)
            {
                $weather = $weatherLoader->loadWeatherByDay(new \DateTime($day));
            } else {
                return $this->render('weather/error.html.twig', [
                    'error' => $error
                ]);
            }
        } catch (\Exception $exp) {
            $weather = new NullWeather();
        }

        return $this->render('weather/index.html.twig', [
            'weatherData' => [
                'date'      => $weather->getDate()->format('Y-m-d'),
                'dayTemp'   => $weather->getDayTemp(),
                'nightTemp' => $weather->getNightTemp(),
                'sky'       => $weather->getSky(),
            ],
        ]);
    }
}
