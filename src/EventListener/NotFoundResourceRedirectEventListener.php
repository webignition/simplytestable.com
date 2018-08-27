<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundResourceRedirectEventListener
{
    const CSS_ASSET_PATH_PATTERN = '/^\/build\/.*\.css$/';
    const JS_ASSET_PATH_PATTERN = '/^\/build\/.*\.js/';
    const CSS_ASSET_KEY = 'build/app.css';
    const JS_ASSET_KEY = 'build/app.js';

    /**
     * @var string
     */
    private $assetManifestPath;

    public function __construct(string $assetManifestPath)
    {
        $this->assetManifestPath = $assetManifestPath;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return null;
        }

        $exception = $event->getException();

        if (!$exception instanceof NotFoundHttpException) {
            return null;
        }

        $urlPath = $event->getRequest()->getPathInfo();

        $isCssAssetRequest = preg_match(self::CSS_ASSET_PATH_PATTERN, $urlPath) > 0;
        $isJsAssetRequest = preg_match(self::JS_ASSET_PATH_PATTERN, $urlPath) > 0;

        if (false === $isCssAssetRequest && false === $isJsAssetRequest) {
            return null;
        }

        $assetManifest = json_decode(file_get_contents($this->assetManifestPath), true);

        $assetPath = null;

        if ($isCssAssetRequest) {
            $assetPath = $assetManifest[self::CSS_ASSET_KEY];
        }

        if ($isJsAssetRequest) {
            $assetPath = $assetManifest[self::JS_ASSET_KEY];
        }

        $event->setResponse(new RedirectResponse($assetPath));

        return null;
    }
}
