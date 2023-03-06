<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
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
        $usersData = [
            0 => [
                'email' => 'akhan@example.com',
                'role' => ['ROLE_USER'],
                'password' => 123654
            ],
            1 => [
                'email' => 'eer@example.com',
                'role' => ['ROLE_USER'],
                'password' => 123654
            ],
            2 => [
                'email' => 'jack@example.com',
                'role' => ['ROLE_USER'],
                'password' => 123654
            ],
            3 => [
                'email' => 'arman@example.com',
                'role' => ['ROLE_USER'],
                'password' => 123654
            ],
            4 => [
                'email' => 'phpppp@example.com',
                'role' => ['ROLE_USER'],
                'password' => 123654
            ],
            5 => [
                'email' => 'пхпшник@example.com',
                'role' => ['ROLE_USER'],
                'password' => 123654
            ],
        ];

        foreach ($usersData as $user) {
            $newUser = new User();
            $newUser->setEmail($user['email']);
            $newUser->setPassword($this->hasher->hashPassword($newUser, $user['password']));
            $newUser->setRoles($user['role']);
            $this->entityManager->persist($newUser);
        }

        $this->entityManager->flush();
    }
}
