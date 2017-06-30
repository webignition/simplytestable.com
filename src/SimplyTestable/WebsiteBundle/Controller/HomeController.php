<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\IEFiltered;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends CacheableController implements IEFiltered
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->renderCacheableResponse();
    }
}
