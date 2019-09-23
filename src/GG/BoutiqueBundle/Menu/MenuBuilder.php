<?php
namespace GG\BoutiqueBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface{
	private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory){
            $this->factory = $factory;
    }
	use ContainerAwareTrait;
	public function createMainMenu(){
		$menu = $this->factory->createItem('root');

		$menu->addChild('Profile', array('route' => '', 'label'=>'Informations Personnelles'));
		$menu['Profile']->setAttribute('id', 'idListe');
		$menu['Profile']->addChild('En cours', array('route' => 'fos_user_profile_show_infos', 'label'=>'Infos Profile'));

		$menu->addChild('Modification', array('route' => '', 'label'=>'Gestion Données'));
		$menu['Modification']->setAttribute('id', 'infos');
		$menu['Modification']->addChild('Modifier Profile', ['route' => 'fos_user_profile_edit']);
		$menu['Modification']->addChild('Modifier mot de passe', ['route' => 'fos_user_change_password']);

		$menu->addChild('Commmandes', array('route' => '', 'label'=>'Commandes'));
		$menu['Commmandes']->setAttribute('id', 'comm');
		
		/*$menu->addChild('Home', ['user/profile' => 'fos_user_profile_edit ']);
		$em = $this->container->get('doctrine')->getManager();
		$user = 
		*/
		return $menu;

	}
	
}
    