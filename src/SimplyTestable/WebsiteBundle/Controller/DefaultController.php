<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('SimplyTestableWebsiteBundle:Default:index.html.twig');
    }
    
    public function roadmapAction() {
        return $this->render('SimplyTestableWebsiteBundle:Default:roadmap.html.twig');
    }
}
