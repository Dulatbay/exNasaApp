<?php

namespace App\Services;


use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NasaApi
{
    private HttpClientInterface $httpClient;
    private string $api_key = 'vypQbfVJX694pYGvYeylkvdU7BcrZPmVg0n1mYfD';

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getPictureOfDay(int $count = 3)
    {
        // TODO: remake this code
        $response = $this->httpClient->request(
            'GET',
            'https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY&count=' . $count
        );
        $statusCode = $response->getStatusCode();
        $content = json_decode($response->getContent());
        return $content;

    }

}