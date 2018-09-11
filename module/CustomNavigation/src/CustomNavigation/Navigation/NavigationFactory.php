<?php

namespace CustomNavigation\Navigation;

use Zend\Navigation\Service\DefaultNavigationFactory;

class NavigationFactory extends DefaultNavigationFactory
{
    const NAME = 'custom-navigation';

    /**
     * @return string
     */
    protected function getName()
    {
        return self::NAME;
    }
}
