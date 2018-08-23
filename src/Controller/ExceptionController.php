<?php

namespace App\Controller;

use App\Services\NotFoundIgnoreList;
use Postmark\Models\PostmarkException;
use Postmark\PostmarkClient;
use App\Services\TestimonialService;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseExceptionController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Twig\Environment as TwigEnvironment;
use webignition\Url\Url;

class ExceptionController extends BaseExceptionController
{
    /**
     * @var PostmarkClient
     */
    private $postmarkClient;

    /**
     * @var TestimonialService
     */
    private $testimonialService;

    /**
     * @var NotFoundIgnoreList
     */
    private $notFoundIgnoreList;

    /**
     * @param bool $debug
     * @param TwigEnvironment $twig
     * @param PostmarkClient $postmarkClient
     * @param TestimonialService $testimonialService
     * @param NotFoundIgnoreList $notFoundIgnoreList
     */
    public function __construct(
        $debug,
        TwigEnvironment $twig,
        PostmarkClient $postmarkClient,
        TestimonialService $testimonialService,
        NotFoundIgnoreList $notFoundIgnoreList
    ) {
        parent::__construct($twig, $debug);

        $this->postmarkClient = $postmarkClient;
        $this->testimonialService = $testimonialService;
        $this->notFoundIgnoreList = $notFoundIgnoreList;
    }

    /**
     * @param Request $request
     * @param FlattenException $exception
     * @param DebugLoggerInterface|null $logger
     *
     * @return Response
     */
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {
        $requestUri = $request->getRequestUri();
        $isNotFoundException = $exception->getStatusCode() == Response::HTTP_NOT_FOUND;

        if ($isNotFoundException && $this->isProtocolRelativeRequestUrl($requestUri)) {
            return new RedirectResponse(
                'http:' . $requestUri
            );
        }

        if ($this->shouldSendDeveloperEmail($request, $exception)) {
            if ($exception->getClass() === NotFoundHttpException::class) {
                $this->sendDeveloperHttpNotFoundExceptionEmail($exception);
            } else {
                $this->sendGenericDeveloperEmail($exception);
            }
        }

        $currentContent = $this->getAndCleanOutputBuffering($request->headers->get('X-Php-Ob-Level', -1));
        $showException = $request->attributes->get('showException', $this->debug);
        $code = $exception->getStatusCode();

        return new Response(
            $this->twig->render(
                (string) $this->findTemplate($request, $request->getRequestFormat(), $code, $showException),
                array(
                    'status_code'    => $code,
                    'status_text'    => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
                    'exception'      => $exception,
                    'logger'         => $logger,
                    'currentContent' => $currentContent,
                    'requestUri' => $requestUri,
                    'testimonial' => $this->testimonialService->getRandom()
                )
            ),
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @param Request $request
     * @param FlattenException $exception
     *
     * @return bool
     */
    private function shouldSendDeveloperEmail(Request $request, FlattenException $exception)
    {
        if ($this->debug) {
            return false;
        }

        if ($exception->getStatusCode() !== 404) {
            return true;
        }

        if (in_array($request->getPathInfo(), $this->notFoundIgnoreList->get())) {
            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     * @param string  $format
     * @param int     $code          An HTTP response status code
     * @param bool    $showException
     *
     * @return string
     */
    protected function findTemplate(Request $request, $format, $code, $showException)
    {
        $name = $showException ? 'exception' : 'error';
        if ($showException && 'html' == $format) {
            $name = 'exception_full';
        }

        // For error pages, try to find a template for the specific HTTP status code and format
        if (!$showException) {
            $template = sprintf('Exception/%s%s.%s.twig', $name, $code, $format);
            if ($this->templateExists($template)) {
                return $template;
            }
        }

        // try to find a template for the given format
        $template = sprintf('@Twig/Exception/%s.%s.twig', $name, $format);
        if ($this->templateExists($template)) {
            return $template;
        }

        // default to a generic HTML exception
        $request->setRequestFormat('html');

        return sprintf('@Twig/Exception/%s.html.twig', $showException ? 'exception_full' : $name);
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    private function isProtocolRelativeRequestUrl($url)
    {
        $urlObject = new Url($url);

        return $urlObject->isProtocolRelative();
    }

    private function sendGenericDeveloperEmail(FlattenException $exception)
    {
        $subject = sprintf(
            'simplytestable.com Exception [%s]',
            $exception->getStatusCode()
        );

        $messageBody = $this->twig->render('Email/generic-exception.txt.twig', [
            'status_code' => $exception->getStatusCode(),
            'exception' => $exception,
            'remote_addr' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);

        $this->sendDeveloperEmail($subject, $messageBody);
    }

    private function sendDeveloperHttpNotFoundExceptionEmail(FlattenException $exception)
    {
        $subject = sprintf(
            'simplytestable.com NotFoundHttpException [%s]',
            trim(str_replace(['No route found for', '"'], '', $exception->getMessage()))
        );

        $messageBody = $this->twig->render('Email/not-found-http-exception.txt.twig', [
            'remote_addr' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);

        $this->sendDeveloperEmail($subject, $messageBody);
    }

    private function sendDeveloperEmail(string $subject, string $messageBody)
    {
        try {
            $this->postmarkClient->sendEmail(
                'robot@simplytestable.com',
                'jon@simplytestable.com',
                $subject,
                null,
                $messageBody
            );
        } catch (PostmarkException $postmarkException) {
            // Intentionally do nothing
        }
    }
}
