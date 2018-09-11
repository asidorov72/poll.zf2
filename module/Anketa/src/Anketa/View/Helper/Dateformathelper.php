<?php

namespace Anketa\View\Helper;

use Zend\View\Helper\AbstractHelper;
 
class Dateformathelper extends AbstractHelper
{
    public function __invoke($str, $dateformatpattern)
    {
        return date($dateformatpattern,strtotime($str));
    }
}