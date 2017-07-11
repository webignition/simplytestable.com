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
        return $this->renderCacheableResponse('@SimplyTestableWebsite/OutdatedBrowser/index.html.twig');
    }
}
