<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Doctrine\ORM\EntityRepository;
use SimplyTestable\WebsiteBundle\Controller\HomeController;
use SimplyTestable\WebsiteBundle\Controller\LandingPageController;
use SimplyTestable\WebsiteBundle\Entity\CacheValidatorHeaders;
use SimplyTestable\WebsiteBundle\EventListener\CachedResponseEventListener;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class CachedResponseEventListenerTest extends AbstractWebTestCase
{
    /**
     * @var EntityRepository
     */
    private $entityRepository;

    protected function setUp()
    {
        parent::setUp();
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $this->entityRepository = $entityManager->getRepository(CacheValidatorHeaders::class);
    }

    /**
     * @dataProvider onKernelRequestNoChangesToRequestDataProvider
     *
     * @param int $requestType
     * @param array $requestAttributes
     */
    public function testOnKernelRequestNoChangesToRequest(
        $requestType,
        $requestAttributes
    ) {
        $cachedResponseEventListener = $this->container->get('simplytestable.eventlistener.cachedresponse');

        $request = new Request([], [], $requestAttributes);

        $getResponseEvent = new GetResponseEvent(
            $this->container->get('kernel'),
            $request,
            $requestType
        );

        $cachedResponseEventListener->onKernelRequest($getResponseEvent);

        $this->assertNull($getResponseEvent->getResponse());
        $this->assertFalse($request->headers->has(CachedResponseEventListener::REQUEST_HEADER_ETAG));
        $this->assertFalse($request->headers->has(CachedResponseEventListener::REQUEST_HEADER_LASTMODIFIED));

        $this->assertEmpty($this->entityRepository->findAll());
    }

    /**
     * @return array
     */
    public function onKernelRequestNoChangesToRequestDataProvider()
    {
        return [
            'sub request' => [
                'requestType' => HttpKernelInterface::SUB_REQUEST,
                'requestAttributes' => [],
            ],
            'no controller in request attributes' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestAttributes' => [],
            ],
            'not instance of CacheableController' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestAttributes' => [
                    '_controller' => sprintf('%s::indexAction', LandingPageController::class),
                ],
            ],
        ];
    }

    /**
     * @dataProvider onKernelRequestNoResponseDataProvider
     *
     * @param int $requestType
     * @param array $requestAttributes
     * @param array $requestHeaders
     */
    public function testOnKernelRequestNoResponse(
        $requestType,
        $requestAttributes,
        $requestHeaders
    ) {
        $cachedResponseEventListener = $this->container->get('simplytestable.eventlistener.cachedresponse');

        $request = new Request([], [], $requestAttributes);
        $request->headers->add($requestHeaders);

        $getResponseEvent = new GetResponseEvent(
            $this->container->get('kernel'),
            $request,
            $requestType
        );

        $cachedResponseEventListener->onKernelRequest($getResponseEvent);

        $this->assertNull($getResponseEvent->getResponse());
        $this->assertTrue($request->headers->has(CachedResponseEventListener::REQUEST_HEADER_ETAG));
        $this->assertTrue($request->headers->has(CachedResponseEventListener::REQUEST_HEADER_LASTMODIFIED));

        $allCacheValidatorHeaders = $this->entityRepository->findAll();
        $this->assertCount(1, $allCacheValidatorHeaders);
    }

    /**
     * @return array
     */
    public function onKernelRequestNoResponseDataProvider()
    {
        return [
            'no relevant request headers' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestAttributes' => [
                    '_controller' => sprintf('%s::indexAction', HomeController::class),
                ],
                'requestHeaders' => [],
            ],
            'non-matching etag' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestAttributes' => [
                    '_controller' => sprintf('%s::indexAction', HomeController::class),
                ],
                'requestHeaders' => [
                    'if_none_match' => 'foo',
                ],
            ],
        ];
    }

    /**
     * @dataProvider onKernelRequestHasResponseDataProvider
     *
     * @param int $requestType
     * @param array $requestAttributes
     * @param array $requestHeaders
     */
    public function testOnKernelRequestHasResponse(
        $requestType,
        $requestAttributes,
        $requestHeaders
    ) {
        $cachedResponseEventListener = $this->container->get('simplytestable.eventlistener.cachedresponse');

        $request = new Request([], [], $requestAttributes);
        $request->headers->add($requestHeaders);

        $getResponseEvent = new GetResponseEvent(
            $this->container->get('kernel'),
            $request,
            $requestType
        );

        $cachedResponseEventListener->onKernelRequest($getResponseEvent);
        $response = $getResponseEvent->getResponse();

        $this->assertNotNull($response);
        $this->assertEquals(304, $response->getStatusCode());
        $this->assertTrue($request->headers->has(CachedResponseEventListener::REQUEST_HEADER_ETAG));
        $this->assertTrue($request->headers->has(CachedResponseEventListener::REQUEST_HEADER_LASTMODIFIED));

        $allCacheValidatorHeaders = $this->entityRepository->findAll();
        $this->assertCount(1, $allCacheValidatorHeaders);
    }

    /**
     * @return array
     */
    public function onKernelRequestHasResponseDataProvider()
    {
        return [
            'etag match' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestAttributes' => [
                    '_controller' => sprintf('%s::indexAction', HomeController::class),
                ],
                'requestHeaders' => [
                    'if_none_match' => '"c7523ad91c65550c4d532abe6ac86a7f"',
                ],
            ],
            'etag match with accept header' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestAttributes' => [
                    '_controller' => sprintf('%s::indexAction', HomeController::class),
                ],
                'requestHeaders' => [
                    'if_none_match' => '"05584d722c9e31c6c4bcfa004529b8f9"',
                    'accept' => 'foo',
                ],
            ],
        ];
    }
}
