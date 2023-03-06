<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager)
    {
        $this->hasher = $hasher;
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager)
    {
        $adminsData = [
            0 => [
                'email' => 'akhanAdmin@example.com',
                'role' => ['ROLE_ADMIN'],
                'password' => 123654
            ],
            1 => [
                'email' => 'eerAdmin@example.com',
                'role' => ['ROLE_ADMIN'],
                'password' => 123654
            ],
            2 => [
                'email' => 'jackAdmin@example.com',
                'role' => ['ROLE_ADMIN'],
                'password' => 123654
            ],
            3 => [
                'email' => 'armanAdmin@example.com',
                'role' => ['ROLE_ADMIN'],
                'password' => 123654
            ],
            4 => [
                'email' => 'phppppAdmin@example.com',
                'role' => ['ROLE_ADMIN'],
                'password' => 123654
            ],
            5 => [
                'email' => 'пхпшникAdmin@example.com',
                'role' => ['ROLE_ADMIN'],
                'password' => 123654
            ],
        ];

        foreach ($adminsData as $admin) {
            $newUser = new User();
            $newUser->setEmail($admin['email']);
            $newUser->setPassword($this->hasher->hashPassword($newUser, $admin['password']));
            $newUser->setRoles($admin['role']);
            $this->entityManager->persist($newUser);
        }

        $this->entityManager->flush();
    }
}
