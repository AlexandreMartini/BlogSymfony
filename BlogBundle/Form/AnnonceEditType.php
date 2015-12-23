<?php

namespace Alex\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnnonceEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder -> remove('date');
    }

    public function getName()
    {
        return 'alex_blogbundle_annonce_edit';
    }
	
	 public function getParent()
  {
    return new AnnonceType();
  }
}
