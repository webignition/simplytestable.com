<?php

namespace App\Tests\Src\Functional\EventListener;

use Mockery;
use App\Controller\PageController;
use App\Entity\CacheValidatorHeaders;
use App\EventListener\CachedResponseEventListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Tests\Src\Functional\AbstractWebTestCase;

class CachedResponseEventListenerTest extends AbstractWebTestCase
{
    /**
     * @dataProvider onKernelControllerDataProvider
     *
     * @param int $requestType
     * @param array $requestHeaders
     * @param bool $expectedResponseIsNull
     * @param int $expectedResponseStatusCode
     * @param bool $expectedRequestHasCacheValidatorEtagHeader
     * @param bool $expectedRequestHasCacheValidatorLastModifiedHeader
     * @param int $expectedCacheValidatorHeadersCount
     */
    public function testOnKernelController(
        $requestType,
        $requestHeaders,
        $expectedResponseIsNull,
        $expectedResponseStatusCode,
        $expectedRequestHasCacheValidatorEtagHeader,
        $expectedRequestHasCacheValidatorLastModifiedHeader,
        $expectedCacheValidatorHeadersCount
    ) {
        $entityManager = self::$container->get('doctrine.orm.entity_manager');
        $entityRepository = $entityManager->getRepository(CacheValidatorHeaders::class);
        $cachedResponseEventListener = $this->testServiceProvider->getCachedResponseEventListener();

        /* @var KernelInterface $kernel */
        $kernel = Mockery::mock(HttpKernelInterface::class);
        $controller = self::$container->get(PageController::class);
        $request = new Request();
        $request->headers->add($requestHeaders);
        $callable = [
            $controller,
            'homeAction'
        ];

        $filterControllerEvent = new FilterControllerEvent(
            $kernel,
            $callable,
            $request,
            $requestType
        );

        $cachedResponseEventListener->onKernelController($filterControllerEvent);
        $response = $controller->getResponse();

        if ($expectedResponseIsNull) {
            $this->assertNull($response);
        } else {
            $this->assertNotNull($response);
            $this->assertEquals($expectedResponseStatusCode, $response->getStatusCode());
        }

        $this->assertEquals(
            $expectedRequestHasCacheValidatorEtagHeader,
            $request->headers->has(CachedResponseEventListener::REQUEST_HEADER_ETAG)
        );
        $this->assertEquals(
            $expectedRequestHasCacheValidatorLastModifiedHeader,
            $request->headers->has(CachedResponseEventListener::REQUEST_HEADER_LASTMODIFIED)
        );

        $allCacheValidatorHeaders = $entityRepository->findAll();
        $this->assertCount($expectedCacheValidatorHeadersCount, $allCacheValidatorHeaders);
    }

    /**
     * @return array
     */
    public function onKernelControllerDataProvider()
    {
        return [
            'sub-request' => [
                'requestType' => HttpKernelInterface::SUB_REQUEST,
                'requestHeaders' => [],
                'expectedResponseIsNull' => true,
                'expectedResponseStatusCode' => null,
                'expectedRequestHasCacheValidatorEtagHeader' => false,
                'expectedRequestHasCacheValidatorLastModifiedHeader' => false,
                'expectedCacheValidatorHeadersCount' => 0,
            ],
            'no relevant request headers' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestHeaders' => [],
                'expectedResponseIsNull' => true,
                'expectedResponseStatusCode' => null,
                'expectedRequestHasCacheValidatorEtagHeader' => true,
                'expectedRequestHasCacheValidatorLastModifiedHeader' => true,
                'expectedCacheValidatorHeadersCount' => 1,
            ],
            'non-matching etag' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestHeaders' => [
                    'if_none_match' => 'foo',
                ],
                'expectedResponseIsNull' => true,
                'expectedResponseStatusCode' => null,
                'expectedRequestHasCacheValidatorEtagHeader' => true,
                'expectedRequestHasCacheValidatorLastModifiedHeader' => true,
                'expectedCacheValidatorHeadersCount' => 1,
            ],
            'etag match' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestHeaders' => [
                    'if_none_match' => '"c7523ad91c65550c4d532abe6ac86a7f"',
                ],
                'expectedResponseIsNull' => false,
                'expectedResponseStatusCode' => 304,
                'expectedRequestHasCacheValidatorEtagHeader' => true,
                'expectedRequestHasCacheValidatorLastModifiedHeader' => true,
                'expectedCacheValidatorHeadersCount' => 1,
            ],
            'etag match with accept header' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestHeaders' => [
                    'if_none_match' => '"05584d722c9e31c6c4bcfa004529b8f9"',
                    'accept' => 'foo',
                ],
                'expectedResponseIsNull' => false,
                'expectedResponseStatusCode' => 304,
                'expectedRequestHasCacheValidatorEtagHeader' => true,
                'expectedRequestHasCacheValidatorLastModifiedHeader' => true,
                'expectedCacheValidatorHeadersCount' => 1,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
