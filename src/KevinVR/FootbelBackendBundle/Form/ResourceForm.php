<?php

namespace KevinVR\FootbelBackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ResourceForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('type', EntityType::class, array(
            'class' => 'FootbelBackendBundle:ResourceType',
            'choice_label' => 'label',
          ))
          ->add('season', EntityType::class, array(
            'class' => 'FootbelBackendBundle:Season',
            'choice_label' => 'label',
          ))
          ->add('level', EntityType::class, array(
            'class' => 'FootbelBackendBundle:Level',
            'choice_label' => 'label',
          ))
          ->add('province', EntityType::class, array(
            'class' => 'FootbelBackendBundle:Province',
            'choice_label' => 'label',
          ))
          ->add('url', UrlType::class)

          ->add('save', SubmitType::class, array('label' => 'Create Resource'));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
          array(
            'data_class' => 'KevinVR\FootbelBackendBundle\Entity\Resource',
          )
        );
    }

}
