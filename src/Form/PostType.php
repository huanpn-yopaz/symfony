<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'required' => false,
                'attr' => 
                [
                    'class' => 'form-control',
                    'id' => 'name',
                    'placeholder' => 'Name'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Name is mandatory',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Name must be at least {{ limit }} characters',
                    ])
                ]
                ])
            ->add('title',TextareaType::class,[
                'required' => false,
                'attr' =>
                [
                    'class' => 'form-control my-4',
                    'id' => 'title',
                    'placeholder' => 'Title'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Title is mandatory',
                    ])
                ]
            ])
            ->add('save',SubmitType::class,[
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-primary mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
