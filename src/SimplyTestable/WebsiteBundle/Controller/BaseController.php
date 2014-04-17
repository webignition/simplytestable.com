<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{   

    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\UserService
     */
    protected function getUserService() {
        return $this->get('simplytestable.services.userservice');
    }     
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\UserSerializerService
     */
    protected function getUserSerializerService() {
        return $this->get('simplytestable.services.userserializerservice');
    } 
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\TestimonialService
     */
    protected function getTestimonialService() {
        return $this->get('simplytestable.services.testimonialService');
    } 
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\CacheableResponseService
     */
    protected function getCacheableResponseService() {
        return $this->get('simplytestable.services.cacheableResponseService');
    } 
    
    
    /**
     * 
     * @param string $templateId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function defaultPageAction($templateId) {        
        return $this->getCacheableResponseService()->getCachableResponse(
            $this->getRequest(),
            $this->render('SimplyTestableWebsiteBundle:Default:'.$templateId.'.html.twig', array(
                'testimonial' => $this->getTestimonialService()->getRandom(),
                'user' => $this->getUserService()->getUser(),
                'is_logged_in' => $this->getUserService()->isLoggedIn(),
                'web_client_urls' => $this->container->getParameter('web_client_urls'),
            ))                
        );         
    } 
    
    
    /**
     * 
     * @return array
     */
    protected function getDefaultViewParameters() {
        return array(
            'testimonial' => $this->getTestimonialService()->getRandom(),
            'user' => $this->getUserService()->getUser(),
            'is_logged_in' => $this->getUserService()->isLoggedIn(),
            'web_client_urls' => $this->container->getParameter('web_client_urls'),
        );
    }
    
    
    /**
     * 
     * @param array $additionalParameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderResponse(array $additionalParameters = array()) {
        return parent::render($this->getViewName(), array_merge($this->getDefaultViewParameters(), $additionalParameters));
    } 
    

    /**
     * 
     * @param array $additionalParameters
     * @return \Symfony\Component\HttpFoundation\Response
     */    
    protected function renderCacheableResponse(array $additionalParameters = array()) {
        return $this->getCacheableResponseService()->getCachableResponse(
            $this->getRequest(), $this->renderResponse($additionalParameters)
        );        
    }
    
    
    
    private function getViewName() {
        $classNamespaceParts = $this->getClassNamespaceParts();
        $bundleNamespaceParts = array_slice($classNamespaceParts, 0, array_search('Controller', $classNamespaceParts));
        
        return implode('', $bundleNamespaceParts) . ':' .  $this->getViewPath() . ':' . $this->getViewFilename();
    }

    
    /**
     * 
     * @return string
     */
    private function getViewPath() {
        $classNamespaceParts = $this->getClassNamespaceParts();
        $controllerClassNameParts = array_slice($classNamespaceParts, array_search('Controller', $classNamespaceParts) + 1);

        array_walk($controllerClassNameParts, function(&$part) {
            $part = preg_replace('/Controller$/', '', $part);
        });

        return implode('/', $controllerClassNameParts);
    }
    
    
    /**
     * 
     * @return string
     */
    private function getViewFilename() {
        $routeParts = explode('_', $this->container->get('request')->get('_route'));        
        return $routeParts[count($routeParts) - 1] . '.html.twig';
    }

    
    /**
     * 
     * @return string[]
     */
    private function getClassNamespaceParts() {
        return explode('\\', get_class($this));
    }    
}

