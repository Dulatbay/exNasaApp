<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Post;
use App\Entity\PostFile;
use App\Form\Type\PostType;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/create-post', name: 'create_post', methods: ['POST'])]
    public function createPost(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager): Response
    {
        $title = $request->request->get('title');
        $contentText = $request->request->get('contentText');
        $files = $request->files->get('files');
        $post = new Post();
        foreach ($files as $file) {
            $fileToDatabase = new File();
            $fileToDatabase->setName($fileUploader->upload($file));
            $entityManager->persist($fileToDatabase);
        }
        $post->setTitle($title);
        $post->setContentText($contentText);
        $entityManager->persist($post);
        $entityManager->flush();
        return $this->json([
            'status' => 'success',
            'message' => $post,
        ]);
    }

}