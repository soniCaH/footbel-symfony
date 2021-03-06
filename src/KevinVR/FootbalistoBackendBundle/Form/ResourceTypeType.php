<?php

namespace KevinVR\FootbalistoBackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceTypeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('shorthand')
          ->add('label')
          ->add(
            'handler',
            ChoiceType::class,
            array(
              'choices' => array(
                'MatchHandler' => 'KevinVR\FootbalistoProcessorBundle\Processor\ResourceProcessorMatch',
                'RankHandler' => 'KevinVR\FootbalistoProcessorBundle\Processor\ResourceProcessorRank',
              ),
            )
          );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
          array(
            'data_class' => 'KevinVR\FootbalistoBackendBundle\Entity\ResourceType',
          )
        );
    }
}
