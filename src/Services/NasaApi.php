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

    public function getMarsPhotos(int $page = 1){
        // TODO
        $response = $this->httpClient->request(
            'GET',
            'https://api.nasa.gov/mars-photos/api/v1/rovers/curiosity/photos?earth_date=2015-6-3&api_key=DEMO_KEY&page=' . $page
        );
        /*

        response model =>
        0 => {
            +"id": 102685
            +"sol": 1004
            +"camera": {
                +"id": 20
                +"name": "FHAZ"
                +"rover_id": 5
                +"full_name": "Front Hazard Avoidance Camera"
            }
            +"img_src": "http://mars.jpl.nasa.gov/msl-raw-images/proj/msl/redops/ods/surface/sol/01004/opgs/edr/fcam/FLB_486615455EDR_F0481570FHAZ00323M_.JPG"
            +"earth_date": "2015-06-03"
            +"rover": {#493 ▼
                +"id": 5
                +"name": "Curiosity"
                +"landing_date": "2012-08-06"
                +"launch_date": "2011-11-26"
                +"status": "active"
            }
        }



        */
        $content = json_decode($response->getContent());
        return $content;
    }
}