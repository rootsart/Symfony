<?php
namespace GG\BoutiqueBundle\Form;

use GG\BoutiqueBundle\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class RechercheType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options){
		 $builder
  ->add('article', EntityType::class, array(

    'class'        => 'GGBoutiqueBundle:Article',

    'choice_label' => 'id',

    'multiple'     => false,

  ));
	}


	public function setDefaultOptions(OptionsResolverInterface $resolver){
	   $resolver->setDefaults(array(
	      'data_class' => null,
	   ));
	}
	public function getName(){
    	return 'gg_boutiquebundle_recherchetype';
  	}
}




