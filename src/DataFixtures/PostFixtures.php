<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\File;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    private EntityManagerInterface $entity;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entity = $entityManager;
    }


    public function load(ObjectManager $manager)
    {
        // Create users
        $user1 = new User();
        $user1->setEmail('user1@example.com');
        $user1->setPassword('password');
        $user1->setRoles(['ROLE_USER']);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('user2@example.com');
        $user2->setPassword('password');
        $user2->setRoles(['ROLE_USER']);
        $manager->persist($user2);

        // Create posts
        $post1 = new Post();
        $post1->setTitle('Post 1');
        $post1->setContentText('This is the content of post 1.');
        $post1->setUserId($user1);
        $post1->setCreatedAt(new \DateTimeImmutable());

        $post2 = new Post();
        $post2->setTitle('Post 2');
        $post2->setContentText('This is the content of post 2.');
        $post2->setUserId($user2);
        $post2->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($post1);
        $manager->persist($post2);

        // Create comments
        $comment1 = new Comment();
        $comment1->setContent('Comment 1 for post 1.');
        $comment1->setUserId($user2);
        $comment1->setPostId($post1);

        $comment2 = new Comment();
        $comment2->setContent('Comment 2 for post 1.');
        $comment2->setUserId($user1);
        $comment2->setPostId($post1);

        $manager->persist($comment1);
        $manager->persist($comment2);

        $manager->flush();
    }
}