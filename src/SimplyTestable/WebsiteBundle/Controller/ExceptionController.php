<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Services\NotFoundRedirectService;
use SimplyTestable\WebsiteBundle\Services\TestimonialService;
use Swift_Mailer;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseExceptionController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Twig\Environment as TwigEnvironment;
use webignition\Url\Url;

class ExceptionController extends BaseExceptionController
{
    /**
     * @var NotFoundRedirectService
     */
    private $notFoundRedirectService;

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var TestimonialService
     */
    private $testimonialService;

    /**
     * @param bool $debug
     * @param TwigEnvironment $twig
     * @param NotFoundRedirectService $notFoundRedirectService
     * @param Swift_Mailer $mailer
     * @param TestimonialService $testimonialService
     */
    public function __construct(
        $debug,
        TwigEnvironment $twig,
        NotFoundRedirectService $notFoundRedirectService,
        Swift_Mailer $mailer,
        TestimonialService $testimonialService
    ) {
        parent::__construct($twig, $debug);
        $this->notFoundRedirectService = $notFoundRedirectService;
        $this->mailer = $mailer;
        $this->testimonialService = $testimonialService;
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
        $redirectUrl = $this->notFoundRedirectService->getRedirectFor($requestUri);

        if (!empty($redirectUrl)) {
            return new RedirectResponse($redirectUrl);
        }

        $normalisedRequestUrl = preg_replace('/^\/app_dev.php/', '', $requestUri);
        $isNotFoundException = $exception->getStatusCode() == Response::HTTP_NOT_FOUND;

        if ($isNotFoundException && $this->isProtocolRelativeRequestUrl($normalisedRequestUrl)) {
            return new RedirectResponse(
                'http:' . $normalisedRequestUrl
            );
        }

        if (!$this->debug) {
            $this->sendDeveloperEmail($exception);
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
            $template = sprintf('SimplyTestableWebsiteBundle:Exception:%s%s.%s.twig', $name, $code, $format);
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

    /**
     * @param FlattenException $exception
     */
    private function sendDeveloperEmail(FlattenException $exception)
    {
        $message = \Swift_Message::newInstance();

        $message->setSubject(sprintf(
            'Exception [%s,%s]',
            $exception->getCode(),
            $exception->getStatusCode()
        ));
        $message->setFrom('exceptions@simplytestable.com');
        $message->setTo('jon@simplytestable.com');

        $message->setBody($this->twig->render('SimplyTestableWebsiteBundle:Email:exception.txt.twig', array(
            'status_code' => $exception->getStatusCode(),
            'status_text' => '"status text"',
            'exception' => $exception,
            'remote_addr' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        )));

        $this->mailer->send($message);
    }
}
