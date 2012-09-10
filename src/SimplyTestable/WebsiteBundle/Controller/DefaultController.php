<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        if ($this->isUsingOldIE()) {
            return $this->forward('SimplyTestableWebsiteBundle:Default:outdatedBrowser');
        }
        
        return $this->render('SimplyTestableWebsiteBundle:Default:index.html.twig');
    }
    
    public function roadmapAction() {
        if ($this->isUsingOldIE()) {
            return $this->forward('SimplyTestableWebsiteBundle:Default:outdatedBrowser');
        }
        
        return $this->render('SimplyTestableWebsiteBundle:Default:roadmap.html.twig');
    }
    
    public function outdatedBrowserAction() {
        return $this->render('SimplyTestableWebsiteBundle:Default:outdated-browser.html.twig');
    }
    
    public function isUsingOldIE() {
        $browserInfo =  $this->container->get('jbi_browscap.browscap')->getBrowser($this->getRequest()->server->get('HTTP_USER_AGENT'));                
        return ($browserInfo->Browser == 'IE' && $browserInfo->MajorVer < 8);     
    }
}

