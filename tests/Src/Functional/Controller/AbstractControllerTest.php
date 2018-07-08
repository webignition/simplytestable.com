<?php

namespace App\Tests\Src\Functional\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Tests\Src\Functional\AbstractWebTestCase;

abstract class AbstractControllerTest extends AbstractWebTestCase
{
    const OUTDATED_BROWSER_USER_AGENT = 'Mozilla/4.0 (MSIE 6.0; Windows NT 5.0)';

    /**
     * @return Request
     */
    protected function createRequestForOutdatedBrowser()
    {
        $request = new Request();
        $request->headers->set('user-agent', self::OUTDATED_BROWSER_USER_AGENT);

        return $request;
    }
}
