<?php

namespace App\Services;

use App\Entity\Rover;
use App\Entity\RoverCamera;
use App\Repository\RoverRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;

class DatabaseService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Exception
     */
    // TODO: make images init from the database
    #[NoReturn] public function updateDatabase(array $values): bool
    {
        try {
            // Get the metadata for your entity
            $metadata = $this->entityManager->getClassMetadata(Rover::class);

            // Execute the query
            $this->entityManager->createQuery("DELETE FROM " . $metadata->getName())->execute();
            $this->entityManager->flush();


            // insert values

            // TODO: remake this wonderful algorithm 0
            // $addedValues = []; // array to reduce database queries
            foreach ($values as $value) {
                $rover = new Rover();
                // TODO: remake this wonderful algorithm 1
                $rover->setId($value["id"]);
                $rover->setName($value["name"]);
                $rover->setLandingDate(new \DateTime($value["landing_date"]));
                $rover->setLaunchDate(new \DateTime($value["launch_date"]));
                $rover->setStatus($value["status"]);
                $rover->setMaxSol($value["max_sol"]);
                $rover->setMaxDate(new \DateTime($value["max_date"]));
                $rover->setTotalPhotos($value["total_photos"]);
                foreach ($value["cameras"] as $camera) {
                    $obj = $this->entityManager->find(RoverCamera::class, $camera["id"]);
                    if (!$obj) {
                        $obj = new RoverCamera();
                        $obj->setName($camera["name"]);
                        $obj->setFullName($camera["full_name"]);
                        $obj->setId($camera["id"]);
                    }
                    $rover->addRoverCamera($obj);
                    $obj->addRoverId($rover);
                    $this->entityManager->persist($obj);
                }
                $this->entityManager->persist($rover);
            }
            $this->entityManager->flush();
            return true;
        } catch (\Exception $ex) {
            // TODO: log
            throw $ex;
            return false;
        }

    }


    public function getAllRovers(): array
    {
        $roverObjs = $this->entityManager->getRepository(Rover::class)->findAll();
        $result = [];
        foreach ($roverObjs as $roverObj) {
            $rover = [];
            foreach ($roverObj as $key => $val) {
                // TODO: i changed the property private to public
                if ($key != 'roverCameras') {
                    $rover[$key] = $val;
                } else {
                    $roverCameraObjs = $roverObj->getRoverCameras()->toArray();
                    $cameras = [];
                    foreach ($roverCameraObjs as $roverCameraObj){
                        $camera = json_decode(json_encode($roverCameraObj), true);
                        $cameras[] = $camera;
                    }
                    $rover[$key] = $cameras;
                }
            }
            $result[] = $rover;
        }
        return $result;
    }
}
