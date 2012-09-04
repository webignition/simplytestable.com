<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SimplyTestableWebsiteBundle:Default:index.html.twig', array('name' => $name));
    }
}
