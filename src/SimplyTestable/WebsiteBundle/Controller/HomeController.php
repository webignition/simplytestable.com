<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController extends CacheableController
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        if ($this->isOldIE()) {
            return $this->createRedirectToOutdatedBrowserResponse();
        }

        return $this->renderCacheableResponse();
    }
}
