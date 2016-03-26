<?php

namespace Glory\Bundle\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GloryCategoryBundle:Default:index.html.twig', array('name' => $name));
    }
}
