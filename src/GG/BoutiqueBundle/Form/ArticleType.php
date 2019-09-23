<?php
 
namespace GG\BoutiqueBundle\Form;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use GG\BoutiqueBundle\Form\ImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use GG\BoutiqueBundle\Repository\ArticleRepository;



class ArticleType extends AbstractType{
  public function buildForm(FormBuilderInterface $builder, array $options){
    $entity=$options['data'];
    $rubrique=$entity->getRubrique();
    $categorie = $entity->getCategorie();
    $builder
        ->add('categorie', EntityType::class, array(
           /* 'class'        => 'GGBoutiqueBundle:Article',
            'choice_label' => 'categorie',
            'choice_value' => 'id',
            'multiple'     => false,
            'data' =>$options['entity_manager']->getReference('GGBoutiqueBundle:Article', $entity->getId() ? $entity->getId() : '6'),
            */
            'class'    => 'GGBoutiqueBundle:Categorie',
            'choice_label' => 'categorie',
            'choice_value' => 'id',
            'multiple' => false,
             'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                        return $er->createQueryBuilder("u")
                           ;
                    },

            ))

       ->add('rubrique', EntityType::class, array(
            /*'class'        => 'GGBoutiqueBundle:Article',
            'choice_label' => 'rubrique',
            'multiple'     => false,
           'data' =>$options['entity_manager']->getReference('GGBoutiqueBundle:Article', $entity->getId() ? $entity->getId() : '6'),*/
            'class'    => 'GGBoutiqueBundle:Rubriques',
            'choice_label' => 'rubrique',
            'choice_value' => 'id',
            'multiple' => false,
             'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                        return $er->createQueryBuilder("u")
                           ;
                    },
            ))
       
				->add('reference',     	TextType::class)
				->add('url',   			UrlType::class)
				->add('prix',    		NumberType::class)
        ->add('stock',      TextType::class)
				->add('infos', 			TextType::class)
				->add('photo',      	ImageType::class)
        ->add('level',        TextType::class)
				->add('save',      		SubmitType::class);
	}

  
  public function configureOptions(OptionsResolver $resolver){
    $resolver->setRequired('entity_manager');
  }
  public function setDefaultOptions(OptionsResolverInterface $resolver){
    $resolver->setDefaults(array(
      'data_class' => 'GG\BoutiqueBundle\Entity\Article'
    ));
  }
 
  public function getName(){
    return 'gg_boutiquebundle_articletype';
  }


}

 