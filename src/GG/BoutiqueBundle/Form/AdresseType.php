<?php
 
namespace GG\BoutiqueBundle\Form;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class AdresseType extends AbstractType{
  public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
    ->add('Numero',      NumberType::class)
    ->add('rue',      TextType::class)
    ->add('ville',      TextType::class)
    ->add('codePostal',      NumberType::class)
    ->add('complement',      TextareaType::class);
				
	}
 
  /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GG\BoutiqueBundle\Entity\Adresse'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gg_boutiquebundle_adresse';
    }

}