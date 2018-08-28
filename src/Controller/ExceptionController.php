<?php

namespace App\Controller;

use App\Services\TestimonialService;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseExceptionController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Twig\Environment as TwigEnvironment;

class ExceptionController extends BaseExceptionController
{
    /**
     * @var TestimonialService
     */
    private $testimonialService;

    /**
     * @param bool $debug
     * @param TwigEnvironment $twig
     * @param TestimonialService $testimonialService
     */
    public function __construct(
        $debug,
        TwigEnvironment $twig,
        TestimonialService $testimonialService
    ) {
        parent::__construct($twig, $debug);

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
                    'requestUri' => $request->getRequestUri(),
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
}
