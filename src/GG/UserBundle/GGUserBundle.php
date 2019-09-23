<?php

namespace GG\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GGUserBundle extends Bundle
{
	public function getParent(){
    	return 'FOSUserBundle';}
 
}
