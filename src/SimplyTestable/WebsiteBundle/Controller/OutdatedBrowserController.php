<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class OutdatedBrowserController extends CacheableController
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        if ($this->hasResponse()) {
            return $this->getResponse();
        }

        return $this->render(':OutdatedBrowser:index.html.twig');
    }
}
