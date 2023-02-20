<?php
namespace App\Form\Type;
use App\Entity\UserEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("email", TextType::class, [
                'attr' => [
                    'placeholder'=> 'name@example.com',
                    'type'=>'email',
                    'class'=>'form-control',
                ]
            ] )
            ->add("password", PasswordType::class, [
                'attr' => [
                    'placeholder'=> 'Password...',
                    'type'=>'password',
                    'class'=>'form-control'
                ],
            ])
            ->add('Registration', SubmitType::class, [
                'attr' => [
                    'class'=>'btn btn-primary form-btn btn-lg'
                ],
            ])
        ;
    }


}