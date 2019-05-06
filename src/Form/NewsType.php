<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType {
    const CREATED = 'created';

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $created = $options[self::CREATED];

        $builder
            ->add('created', TextType::class)
            ->add('title', TextType::class)
            ->add('thumbnail', FileType::class)
            ->add('image', FileType::class)
            ->add('url', UrlType::class)
            ->add('text', TextareaType::class)
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) use ($created) {
                $requestData = $event->getData();

                if (!isset($requestData[self::CREATED])) {
                    $requestData[self::CREATED] = $created;

                    $event->setData($requestData);
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setRequired(self::CREATED);

        $resolver->setDefaults([
            'data_class' => News::class
        ]);
    }
}
