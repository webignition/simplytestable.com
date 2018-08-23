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

    public function testOnKernelExceptionResponseIsSetForCssResource()
    {
        $this->assertOnKernelExceptionResponseIsSet(
            '/build/app.foo.css',
            $this->getLatestResourcePath(NotFoundResourceRedirectEventListener::CSS_ASSET_KEY)
        );
    }

    public function testOnKernelExceptionResponseIsSetForJsResource()
    {
        $this->assertOnKernelExceptionResponseIsSet(
            '/build/app.foo.js',
            $this->getLatestResourcePath(NotFoundResourceRedirectEventListener::JS_ASSET_KEY)
        );
    }

    private function assertOnKernelExceptionResponseIsSet($requestUrl, $expectedRedirectUrl)
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

    private function getLatestResourcePath(string $assetKey)
    {
        $manifestPath = self::$container->getParameter('kernel.project_dir') . '/public/build/manifest.json';

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
