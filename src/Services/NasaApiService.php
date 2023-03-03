<?php

namespace App\Services;


use PharIo\Manifest\Exception;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NasaApiService
{
    private HttpClientInterface $httpClient;
    // private string $api_key = 'vypQbfVJX694pYGvYeylkvdU7BcrZPmVg0n1mYfD';
    private string $api_key = '2KlcaMNeirkzD4HNsZXRXaM1BccidC0dqGrRo5RM';
    // private string $api_key = 'DEMO_KEY';

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }


    public function getPictureOfDay(int $count = 3)
    {
        // TODO: remake this code
        try {
            $response = $this->httpClient->request(
                'GET',
                'https://api.nasa.gov/planetary/apod?count=' . $count . '&api_key=' . $this->api_key
            );
            return json_decode($response->getContent());
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            return null;
        }
    }


    public function getAllRovers()
    {
        try {
            $response = $this->httpClient->request('GET', 'https://api.nasa.gov/mars-photos/api/v1/rovers?api_key=' . $this->api_key);
            return json_decode($response->getContent(), true)["rovers"];
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            // TODO: log
            return null;
        }

    }

}