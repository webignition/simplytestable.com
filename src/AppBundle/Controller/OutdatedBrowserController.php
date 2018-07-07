<?php

namespace AppBundle\Controller;

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

        return $this->render(':Page:outdated-browser.html.twig');
    }
}