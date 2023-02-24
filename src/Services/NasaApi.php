<?php

namespace App\Services;


use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NasaApi
{
    private HttpClientInterface $httpClient;
    // private string $api_key = 'vypQbfVJX694pYGvYeylkvdU7BcrZPmVg0n1mYfD';
       private string $api_key = 'DEMO_KEY';

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getPictureOfDay(int $count = 3)
    {
        // TODO: remake this code
        $response = $this->httpClient->request(
            'GET',
            'https://api.nasa.gov/planetary/apod?count=' . $count . '&api_key=' . $this->api_key
        );
        $statusCode = $response->getStatusCode();
        return json_decode($response->getContent());

    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getAllRovers(){
        $response = $this->httpClient->request('get', 'https://api.nasa.gov/mars-photos/api/v1/rovers?api_key=' . $this->api_key);
        return json_decode($response->getContent(),true);
    }

}