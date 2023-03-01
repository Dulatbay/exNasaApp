<?php

namespace App\Form\Type;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Title',
                    'class' => 'create__post-input'
                ]
            ])
            ->add("contentText", TextType::class, [
                'attr' => [
                    'placeholder' => 'Content',
                    'class' => 'create__post-input'
                ]
            ])
            ->add('postFiles', FileType::class, [
                'attr' => [
                    'multiple' => 'multiple',
                ],
            ]);
    }


}