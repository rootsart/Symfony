<?php
namespace GG\BoutiqueBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MailType extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
    ->add('Email',      EmailType::class)
    ->add('Sujet',      TextType::class)
    ->add('Message',      TextareaType::class)
	->add('Envoyer',      		SubmitType::class);			
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver){
    $resolver->setDefaults(array(
      'data_class' => 'GG\BoutiqueBundle\Entity\Mail'
    ));
  }

}