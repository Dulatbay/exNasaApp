<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Post;
use App\Entity\PostFile;
use App\Services\FileUploader;
use DateTime;
use DateTimeZone;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class PostController extends AbstractController
{
    #[Route('/create-post', name: 'create_post', methods: ['POST'])]
    public function createPost(Request                $request,
                               FileUploader           $fileUploader,
                               EntityManagerInterface $entityManager,
                               TokenStorageInterface  $tokenStorage): JsonResponse
    {
        $title = $request->request->get('title');
        $contentText = $request->request->get('contentText');
        $post = new Post();
        $files = $request->files->get('files');
        // Получаем часовой пояс клиента

        // Создаем новую дату-время в часовом поясе клиента
        try {
            $clientDateTime = new \DateTimeImmutable('now');
            // Преобразуем дату-время в UTC для сохранения в базе данных
            $post->setCreatedAt($clientDateTime);
        } catch (\Exception $e) {
            // TODO:
            // return

        }


        if ($files)
            foreach ($files as $file) {
                $fileToDatabase = new File();
                $fileToDatabase
                    ->setName($fileUploader->upload($file));
                $entityManager
                    ->persist($fileToDatabase);
                $post->addFile($fileToDatabase);
            }
        $post->setUserId($tokenStorage->getToken()->getUser());
        $post->setTitle($title);
        $post->setContentText($contentText);
        $entityManager->persist($post);
        $entityManager->flush();
        $normalizers = [new ObjectNormalizer()];
        $encoders = [new JsonEncoder()];
        $serializer = new Serializer($normalizers, $encoders);

        return
            ($this->json([
                $serializer->serialize($post, 'json', [
                    'circular_reference_handler' => function ($object) {
                        return $object->getId();
                    }
                ]),
            ]));
    }

}