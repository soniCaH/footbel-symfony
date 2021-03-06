<?php

namespace KevinVR\FootbalistoBackendBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add(
            'type',
            EntityType::class,
            array(
              'class' => 'FootbalistoBackendBundle:ResourceType',
              'choice_label' => 'label',
              'placeholder' => 'Choose an option',
            )
          )
          ->add(
            'season',
            EntityType::class,
            array(
              'class' => 'FootbalistoBackendBundle:Season',
              'choice_label' => 'label',
              'placeholder' => 'Choose an option',
            )
          )
          ->add(
            'level',
            EntityType::class,
            array(
              'class' => 'FootbalistoBackendBundle:Level',
              'choice_label' => 'label',
              'placeholder' => 'Choose an option',
            )
          )
          ->add(
            'province',
            EntityType::class,
            array(
              'class' => 'FootbalistoBackendBundle:Province',
              'choice_label' => 'label',
              'placeholder' => 'Choose an option',
            )
          )
          ->add('url', UrlType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
          array(
            'data_class' => 'KevinVR\FootbalistoBackendBundle\Entity\Resource',
          )
        );
    }
}
