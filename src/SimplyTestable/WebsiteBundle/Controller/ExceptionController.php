<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Services\NotFoundRedirectService;
use SimplyTestable\WebsiteBundle\Services\TestimonialService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use webignition\Url\Url;

class ExceptionController extends Controller
{
    /**
     * Converts an Exception to a Response.
     *
     * @param FlattenException     $exception A FlattenException instance
     * @param DebugLoggerInterface $logger    A DebugLoggerInterface instance
     * @param string               $format    The format to use for rendering (html, xml, ...)
     *
     * @return Response
     *
     * @throws \InvalidArgumentException When the exception template does not exist
     */
    public function showAction(FlattenException $exception, DebugLoggerInterface $logger = null, $format = 'html')
    {
        if ($this->getNotFoundRedirectService()->hasRedirectFor($this->container->get('request')->getRequestUri())) {
            return $this->redirect(
                $this->getNotFoundRedirectService()->getRedirectFor($this->container->get('request')->getRequestUri())
            );
        }

        $normalisedRequestUrl = preg_replace('/^\/app_dev.php/', '', $this->container->get('request')->getRequestUri());
        if ($this->isNotFoundException($exception) && $this->isProtocolRelativeRequestUrl($normalisedRequestUrl)) {
            return $this->redirect('http:' . $normalisedRequestUrl);
        }

        if (!$this->container->get('kernel')->isDebug()) {
            $this->sendDeveloperEmail($exception);
        }

        $this->container->get('request')->setRequestFormat($format);

        $currentContent = $this->getAndCleanOutputBuffering();

        $templating = $this->container->get('templating');
        $code = $exception->getStatusCode();

        return $templating->renderResponse(
            $this->findTemplate($templating, $format, $code, $this->container->get('kernel')->isDebug()),
            array(
                'status_code'    => $code,
                'status_text'    => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
                'exception'      => $exception,
                'logger'         => $logger,
                'currentContent' => $currentContent,
                'requestUri' => $this->container->get('request')->getRequestUri(),
                'testimonial' => $this->getTestimonialService()->getRandom()
            )
        );
    }

    /**
     * @param string $url
     * @return boolean
     */
    private function isProtocolRelativeRequestUrl($url)
    {
        $urlObject = new Url($url);
        return $urlObject->isProtocolRelative();
    }

    /**
     * @param FlattenException $exception
     *
     * @return boolean
     */
    private function isNotFoundException(FlattenException $exception)
    {
        return $exception->getStatusCode() == 404;
    }

    /**
     * @return string
     */
    protected function getAndCleanOutputBuffering()
    {
        // ob_get_level() never returns 0 on some Windows configurations, so if
        // the level is the same two times in a row, the loop should be stopped.
        $previousObLevel = null;
        $startObLevel = $this->container->get('request')->headers->get('X-Php-Ob-Level', -1);

        $currentContent = '';

        while (($obLevel = ob_get_level()) > $startObLevel && $obLevel !== $previousObLevel) {
            $previousObLevel = $obLevel;
            $currentContent .= ob_get_clean();
        }

        return $currentContent;
    }

    /**
     * @param EngineInterface $templating
     * @param string          $format
     * @param integer         $code       An HTTP response status code
     * @param Boolean         $debug
     *
     * @return TemplateReference
     */
    protected function findTemplate($templating, $format, $code, $debug)
    {
        $name = $debug ? 'exception' : 'error';
        if ($debug && 'html' == $format) {
            $name = 'exception_full';
        }

        // when not in debug, try to find a template for the specific HTTP status code and format
        if (!$debug) {
            $template = new TemplateReference('SimplyTestableWebsiteBundle', 'Exception', $name.$code, $format, 'twig');
            if ($templating->exists($template)) {
                return $template;
            }
        }

        // try to find a template for the given format
        $template = new TemplateReference('TwigBundle', 'Exception', $name, $format, 'twig');

        if ($templating->exists($template)) {
            return $template;
        }

        // default to a generic HTML exception
        $this->container->get('request')->setRequestFormat('html');

        return new TemplateReference('TwigBundle', 'Exception', $name, 'html', 'twig');
    }

    /**
     * @param FlattenException $exception
     */
    private function sendDeveloperEmail(FlattenException $exception)
    {
        $message = \Swift_Message::newInstance();

        $message->setSubject($this->getDeveloperEmailSubject($exception));
        $message->setFrom('exceptions@simplytestable.com');
        $message->setTo('jon@simplytestable.com');
        $message->setBody($this->renderView('SimplyTestableWebsiteBundle:Email:exception.txt.twig', array(
            'status_code' => $exception->getStatusCode(),
            'status_text' => '"status text"',
            'exception' => $exception,
            'remote_addr' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        )));

        $this->get('mailer')->send($message);
    }

    /**
     * @param FlattenException $exception
     *
     * @return string
     */
    private function getDeveloperEmailSubject(FlattenException $exception)
    {
        $subject = 'Exception ['.$exception->getCode().','.$exception->getStatusCode().']';

        if ($exception->getStatusCode() == 404) {
            $subject .= ' [' . $exception->getMessage() . ']';
        }

        if ($exception->getStatusCode() == 500) {
            $subject .= ' [' . $exception->getMessage() . ']';
        }

        return $subject;
    }

    /**
     * @return TestimonialService
     */
    private function getTestimonialService()
    {
        return $this->get('simplytestable.services.testimonialService');
    }

    /**
     * @return NotFoundRedirectService
     */
    private function getNotFoundRedirectService()
    {
        return $this->get('simplytestable.services.notfoundredirectservice');
    }
}
