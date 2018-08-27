<?php

namespace App\Tests\Src\Functional\EventListener;

use App\EventListener\NotFoundResourceRedirectEventListener;
use App\Tests\Src\Functional\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelInterface;

class NotFoundResourceRedirectEventListenerTest extends AbstractWebTestCase
{
    /**
     * @var NotFoundResourceRedirectEventListener
     */
    private $eventListener;

    protected function setUp()
    {
        parent::setUp();

        $this->eventListener = self::$container->get(NotFoundResourceRedirectEventListener::class);
    }

    /**
     * @dataProvider onKernelExceptionNullResponseDataProvider
     *
     * @param Request $request
     * @param int $requestType
     * @param \Exception $exception
     */
    public function testOnKernelExceptionNullResponse(Request $request, int $requestType, \Exception $exception)
    {
        $event = $this->createGetResponseForExceptionEvent($request, $exception, $requestType);
        $this->eventListener->onKernelException($event);

        $this->assertFalse($event->hasResponse());
    }

    /**
     * @return array
     */
    public function onKernelExceptionNullResponseDataProvider()
    {
        return [
            'sub request' => [
                'request' => new Request(),
                'requestType' => KernelInterface::SUB_REQUEST,
                'exception' => new \Exception(),
            ],
            'not NotFoundHttpException' => [
                'request' => new Request(),
                'requestType' => KernelInterface::MASTER_REQUEST,
                'exception' => new \Exception(),
            ],
            'not css or js resource request' => [
                'request' => new Request([], [], [], [], [], [
                    'REQUEST_URI' => '/foo'
                ]),
                'requestType' => KernelInterface::MASTER_REQUEST,
                'exception' => new NotFoundHttpException(),
            ],
        ];
    }

    /**
     * @dataProvider onKernelExceptionResponseIsSetDataProvider
     *
     * @param string $requestUrl
     * @param string $expectedRedirectUrl
     */
    public function testOnKernelExceptionResponseIsSet(string $requestUrl, string $expectedRedirectUrl)
    {
        $event = $this->createGetResponseForExceptionEvent(
            new Request([], [], [], [], [], [
                'REQUEST_URI' => $requestUrl
            ]),
            new NotFoundHttpException()
        );

        $this->eventListener->onKernelException($event);

        $this->assertTrue($event->hasResponse());

        /* @var RedirectResponse $response */
        $response = $event->getResponse();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(
            $expectedRedirectUrl,
            $response->getTargetUrl()
        );
    }

    /**
     * @return array
     */
    public function onKernelExceptionResponseIsSetDataProvider()
    {
        $latestCssResourceUrl = $this->getLatestResourcePath(NotFoundResourceRedirectEventListener::CSS_ASSET_KEY);
        $latestJsResourceUrl = $this->getLatestResourcePath(NotFoundResourceRedirectEventListener::JS_ASSET_KEY);

        return [
            'outdated app-level css' => [
                'requestUrl' => '/build/app.foo.css',
                'expectedRedirectUrl' => $latestCssResourceUrl,
            ],
            'outdated app-level js' => [
                'requestUrl' => '/build/app.foo.js',
                'expectedRedirectUrl' => $latestJsResourceUrl,
            ],
            'page-level css' => [
                'requestUrl' => '/build/homepage.foo.css',
                'expectedRedirectUrl' => $latestCssResourceUrl,
            ],
            'page-level css, realistic' => [
                'requestUrl' => '/build/plan-details.be752083e5af7edeb372ed94790eac5d.css',
                'expectedRedirectUrl' => $latestCssResourceUrl,
            ],
            'page-level js' => [
                'requestUrl' => '/build/homepage.foo.js',
                'expectedRedirectUrl' => $latestJsResourceUrl,
            ],
            'page-level js, realistic' => [
                'requestUrl' => '/build/plan-details.be752083e5af7edeb372ed94790eac5d.js',
                'expectedRedirectUrl' => $latestJsResourceUrl,
            ],
        ];
    }

    /**
     * @param string $assetKey
     *
     * @return string
     */
    private function getLatestResourcePath(string $assetKey)
    {
        $projectDirectory = __DIR__ . '/../../../..';

        $manifestPath = $projectDirectory . '/public/build/manifest.json';

        $manifest = json_decode(file_get_contents($manifestPath), true);

        return $manifest[$assetKey];
    }

    /**
     * @param Request $request
     * @param \Exception $exception
     * @param int $requestType
     *
     * @return GetResponseForExceptionEvent
     */
    private function createGetResponseForExceptionEvent(
        Request $request,
        \Exception $exception,
        int $requestType = KernelInterface::MASTER_REQUEST
    ) {
        $kernel = self::$container->get(KernelInterface::class);

        return new GetResponseForExceptionEvent($kernel, $request, $requestType, $exception);
    }
}
