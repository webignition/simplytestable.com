<?php

namespace SimplyTestable\WebsiteBundle\Tests;
use SimplyTestable\WebsiteBundle\Model\User;
use Symfony\Component\BrowserKit\Cookie;

abstract class BaseSimplyTestableTestCase extends BaseTestCase {
    
    const DEFAULT_CONTROLLER_NAME = 'SimplyTestable\WebsiteBundle\Controller\DefaultController';    
    
    
    public function setUp() {
        parent::setUp();
        
        $user = new User();        
        $user->setUsername('public');
        $user->setPassword('public');
        $this->setUser($user);
        
        //$this->clear
    }
    
    
    /**
     *
     * @var User
     */
    private $user;
    
    
    /**
     * 
     * @param \SimplyTestable\WebsiteBundle\Model\User $user
     */
    protected function setUser(User $user) {
        $this->user = $user;
    }
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Model\User
     */
    protected function getUser() {
        return $this->user;
    }




    /**
     * 
     * @return boolean
     */
    protected function hasUser() {
        return !is_null($this->user);
    }

    
    /**
     *
     * @param string $methodName
     * @param array $postData
     * @param array $queryData
     * @return \SimplyTestable\WebsiteBundle\Controller\DefaultController
     */
    protected function getDefaultController($methodName, $postData = array(), $queryData = array()) {
        return $this->getController(self::DEFAULT_CONTROLLER_NAME, $methodName, $postData, $queryData);
    }
   
   
    /**
     * 
     * @param string $controllerName
     * @param string $methodName
     * @return Symfony\Bundle\FrameworkBundle\Controller\Controller
     */
    protected function getController($controllerName, $methodName, array $postData = array(), array $queryData = array()) {   
        $cookieData = array();
        if ($this->hasUser()) {
            $cookieData['simplytestable-user'] = $this->getUserSerializerService()->serializeToString($this->user);
        }
        
        return $this->createController($controllerName, $methodName, $postData, $queryData, $cookieData);
    }

    
    /**
     * 
     * @param string $url
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function getCrawler($url, $method = 'GET') {            
        /* @var $this->client \Symfony\Bundle\FrameworkBundle\Client */
        
        if ($this->hasUser()) {
            $cookie = new Cookie(
                    'simplytestable-user',
                    $this->getUserSerializerService()->serializeToString($this->user)
            );
            
            $this->client->getCookieJar()->set($cookie);
        }
        
        $crawler = $this->client->request($method, $url);        
        return $crawler;
    }    
    
    
    /**
     *
     * @return \SimplyTestable\WebsiteBundle\Services\TestHttpClientService
     */
    protected function getHttpClientService() {
        return $this->container->get('simplytestable.services.httpclientservice');
    }
    
    /**
     *
     * @return \SimplyTestable\WebsiteBundle\Services\TestListService
     */    
    protected function getTestListService() {
        return $this->container->get('simplytestable.services.testListService');
    } 

}
