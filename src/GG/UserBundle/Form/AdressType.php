<?php
 
namespace GG\UserBundle\Form;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class AdressType extends AbstractType{
  public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
    ->add('numero',      NumberType::class, array(
      'label'=>'Numéro',
      'attr'=>array(
      'style'=>'margin-left:0px;width:60px;'),
      'label_attr'=>array('style'=>'width:100px;background:;display:inline-block;text-align:left;margin:0;'))
    )
    ->add('rue',      TextType::class,array(
      'label'=>'Nom de voie',
      'attr'=>array(
      'style'=>'margin-left:0px;min-width:100px;','placeholder'=>" Rue de, Avenue de, etc..."),
      'label_attr'=>array('style'=>'width:100px;background:;display:inline-block;text-align:left;margin:0;'))
    )
    ->add('ville',      TextType::class,array(
      'attr'=>array(
      'style'=>'margin-left:0px;'),
      'label_attr'=>array('style'=>'width:100px;background:;display:inline-block;text-align:left;margin:0;'))
    )
    ->add('codePostal',      NumberType::class,array(
     'attr'=>array(
      'style'=>'margin-left:0px;width:50px;'),
      'label_attr'=>array('style'=>'width:100px;background:;display:inline-block;text-align:left;margin:0;'))
    )
    ->add('complement',      TextareaType::class,array(
      'label'=>'Complément',
      'attr'=>array(
      'style'=>'margin-left:0px;margin-top:20px;'),
      'label_attr'=>array('style'=>'width:100px;background:;display:inline-block;text-align:left;margin:0;'))
    );
				
	}
 
  /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GG\UserBundle\Entity\Adress'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gg_userbundle_adress';
    }

}