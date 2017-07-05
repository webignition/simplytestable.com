<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Services\CacheableResponseFactory;
use SimplyTestable\WebsiteBundle\Services\TestimonialService;
use SimplyTestable\WebsiteBundle\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractBaseController extends Controller
{
    /**
     * @return UserService
     */
    protected function getUserService()
    {
        return $this->get('simplytestable.services.userservice');
    }

    /**
     * @return TestimonialService
     */
    protected function getTestimonialService()
    {
        return $this->get('simplytestable.services.testimonialservice');
    }

    /**
     * @return array
     */
    protected function getDefaultViewParameters()
    {
        return array(
            'testimonial' => $this->getTestimonialService()->getRandom(),
            'user' => $this->getUserService()->getUser(),
            'is_logged_in' => $this->getUserService()->isLoggedIn(),
            'web_client_urls' => $this->container->getParameter('web_client_urls'),
        );
    }

    /**
     * @param array $additionalParameters
     *
     * @return Response
     */
    protected function renderResponse(array $additionalParameters = array())
    {
        return parent::render(
            $this->getViewName(),
            array_merge($this->getDefaultViewParameters(), $additionalParameters)
        );
    }

    /**
     * @param array $additionalParameters
     *
     * @return Response
     */
    protected function renderCacheableResponse(array $additionalParameters = array())
    {
        return CacheableResponseFactory::createCacheableResponse(
            $this->get('request_stack')->getCurrentRequest(),
            $this->renderResponse($additionalParameters)
        );
    }

    /**
     * @return string
     */
    protected function getViewName()
    {
        $classNamespaceParts = $this->getClassNamespaceParts();
        $bundleNamespaceParts = array_slice($classNamespaceParts, 0, array_search('Controller', $classNamespaceParts));

        return implode('', $bundleNamespaceParts) . ':' .  $this->getViewPath() . ':' . $this->getViewFilename();
    }

    /**
     * @return string
     */
    protected function getViewPath()
    {
        $classNamespaceParts = $this->getClassNamespaceParts();
        $controllerClassNameParts = array_slice(
            $classNamespaceParts,
            array_search('Controller', $classNamespaceParts) + 1
        );

        array_walk($controllerClassNameParts, function (&$part) {
            $part = preg_replace('/Controller$/', '', $part);
        });

        return implode('/', $controllerClassNameParts);
    }

    /**
     * @return string
     */
    protected function getViewFilename()
    {
        $routeParts = explode('_', $this->container->get('request_stack')->getCurrentRequest()->get('_route'));

        return $routeParts[count($routeParts) - 1] . '.html.twig';
    }

    /**
     * @return string[]
     */
    private function getClassNamespaceParts()
    {
        return explode('\\', get_class($this));
    }

    /**
     * @return bool
     */
    protected function isOldIE()
    {
        $userAgentDetector = $this->container->get('simplytestable.services.useragentdetector');
        $currentRequest = $this->get('request_stack')->getCurrentRequest();
        $userAgentDetector->setUserAgentString($currentRequest->headers->get('user-agent'));

        return $this->container->get('simplytestable.services.useragentdetector')->isOldIE();
    }

    /**
     * @return RedirectResponse
     */
    protected function createRedirectToOutdatedBrowserResponse()
    {
        return $this->redirect($this->generateUrl('outdatedbrowser_index'));
    }
}
