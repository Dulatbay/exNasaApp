<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ManagerFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager)
    {
        $this->hasher = $hasher;
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void
    {
        $managersData = [
            0 => [
                'email' => 'akhanManager@example.com',
                'role' => ['ROLE_MANAGER'],
                'password' => 123654
            ],
            1 => [
                'email' => 'eerManager@example.com',
                'role' => ['ROLE_MANAGER'],
                'password' => 123654
            ],
            2 => [
                'email' => 'jackManager@example.com',
                'role' => ['ROLE_MANAGER'],
                'password' => 123654
            ],
            3 => [
                'email' => 'armanManager@example.com',
                'role' => ['ROLE_MANAGER'],
                'password' => 123654
            ],
            4 => [
                'email' => 'phppppManager@example.com',
                'role' => ['ROLE_MANAGER'],
                'password' => 123654
            ],
            5 => [
                'email' => 'пхпшникManager@example.com',
                'role' => ['ROLE_MANAGER'],
                'password' => 123654
            ],
        ];

        foreach ($managersData as $manager) {
            $newUser = new User();
            $newUser->setEmail($manager['email']);
            $newUser->setPassword($this->hasher->hashPassword($newUser, $manager['password']));
            $newUser->setRoles($manager['role']);
            $this->entityManager->persist($newUser);
        }

        $this->entityManager->flush();
    }
}