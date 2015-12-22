<?php

namespace Alex\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnnonceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('date',      'date')
           ->add('title',     'text')
           ->add('author',    'text')
           ->add('content',   'textarea')
           ->add('published', 'checkbox', array('required' => false))
           ->add('image',      new ImageType())
           ->add('categories', 'collection', array(
                 'type'         => new CategoryType(),
                 'allow_add'    => true,
                 'allow_delete' => true
                 ))
           ->add('save',      'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Alex\BlogBundle\Entity\Annonce'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'alex_blogbundle_annonce';
    }
}
