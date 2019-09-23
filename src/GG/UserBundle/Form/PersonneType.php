<?php
 
namespace GG\UserBundle\Form;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use GG\BoutiqueBundle\Form\IdentifiantsType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use GG\BoutiqueBundle\Form\AdresseType;
use Symfony\Component\OptionsResolver\OptionsResolver;




class PersonneType extends AbstractType{
  public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
				->add('civilite', ChoiceType::class, array(
                'choices'            =>array('Mr'=>'M', 'Mme'=>'F'),
                'multiple'           =>false,
                'expanded'           => true,
                'label_attr'         =>array('style'=>'border:solid 0px blue;width:100px;margin:0;text-align:left;display:inline-block;'),
                'attr'               =>array('style'=>'height:34px;display:inline;background:;width:100px; border:0px solid green;border-radius:3px;text-align:center;margin:0;padding:0;', 'class'=>'label-choices-personneType'),
                'label'              => 'Civilité ',
                'translation_domain' => 'FOSUserBundle'))
        ->add('nom', TextType::class, array(
                'label' => 'nom',
                'translation_domain' => 'FOSUserBundle',
                'attr'=>array(
                'style'=>'margin-left:0px;'),
                'label_attr'=>array('style'=>'width:100px;background:;display:inline-block;text-align:left;margin-top:10px;')))
        ->add('prenom', TextType::class, array(
          'label' => 'prenom',
         'translation_domain' => 'FOSUserBundle',
         'attr'=>array(
                'style'=>'margin-left:0px;'),
                'label_attr'=>array('style'=>'width:100px;background:;display:inline-block;text-align:left;margin:0;')))
				;
	}
 
  public function setDefaultOptions(OptionsResolverInterface $resolver){
    $resolver->setDefaults(array(
      'data_class' => 'GG\UserBundle\Entity\Personne'
    ));
  }
  /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GG\UserBundle\Entity\Personne'
        ));
    }
  /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gg_userbundle_personne';
    }
}