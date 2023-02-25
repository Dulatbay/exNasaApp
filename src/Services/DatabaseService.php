<?php

namespace App\Services;

use App\Entity\Rover;
use App\Entity\RoverCamera;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;

class DatabaseService
{
    public function __construct()
    {

    }

    /**
     * @throws \Exception
     */
    #[NoReturn] public function updateDatabase(array $values, EntityManagerInterface $entityManager): bool
    {
        try {
            // Get the metadata for your entity
            $metadata = $entityManager->getClassMetadata(Rover::class);

            // Execute the query
            $entityManager->createQuery("DELETE FROM " . $metadata->getName())->execute();
            $entityManager->flush();



            // insert values
            foreach ($values as $value) {
                $rover = new Rover();
                // TODO: remake this wonderful algorithm
                $rover->setId($value["id"]);
                $rover->setName($value["name"]);
                $rover->setLandingDate(new \DateTime($value["landing_date"]));
                $rover->setLaunchDate(new \DateTime($value["launch_date"]));
                $rover->setStatus($value["status"]);
                $rover->setMaxSol($value["max_sol"]);
                $rover->setMaxDate(new \DateTime($value["max_date"]));
                $rover->setTotalPhotos($value["total_photos"]);
                foreach ($value["cameras"] as $camera){
                    $obj = $entityManager->find(RoverCamera::class, $camera["id"]);
                    if(!$obj) {
                        $obj = new RoverCamera();
                        $obj->setName($camera["name"]);
                        $obj->setFullName($camera["full_name"]);
                        $obj->setId($camera["id"]);
                    }
                    $rover->addRoverCamera($obj);
                    $obj->addRoverId($rover);
                    $entityManager->persist($obj);
                }
                $entityManager->persist($rover);
                $entityManager->flush();
            }
            return true;
        }
        catch (\Exception $ex){
            // TODO: log
            throw $ex;
            return false;
        }

    }
}
