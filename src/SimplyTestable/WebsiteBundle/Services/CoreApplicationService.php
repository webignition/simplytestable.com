<?php
namespace SimplyTestable\WebsiteBundle\Services;

use SimplyTestable\WebsiteBundle\Model\User;


abstract class CoreApplicationService {    
    
    /**
     *
     * @var \SimplyTestable\WebsiteBundle\Model\User;
     */
    private static $user;
    
    
    /**
     *
     * @var \SimplyTestable\WebsiteBundle\Services\HttpClientService
     */
    protected $httpClientService;
    
    
    /**
     *
     * @var \webignition\WebResource\Service\Service 
     */
    protected $webResourceService;
    
    
    /**
     *
     * @var \SimplyTestable\WebsiteBundle\Services\CoreApplicationUrlService
     */
    private $coreApplicationUrlService;
    
    
    public function __construct(
        \SimplyTestable\WebsiteBundle\Services\CoreApplicationUrlService $coreApplicationUrlService,
        \SimplyTestable\WebsiteBundle\Services\HttpClientService $httpClientService,
        \webignition\WebResource\Service\Service $webResourceService
    ) {
        $this->coreApplicationUrlService = $coreApplicationUrlService;
        $this->httpClientService = $httpClientService;
        $this->webResourceService = $webResourceService;
    } 
    
    
    /**
     * 
     * @param \SimplyTestable\WebsiteBundle\Model\User $user
     */
    public function setUser(User $user) {
        self::$user = $user;
    }
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Model\User
     */
    public function getUser() {
        return self::$user;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function hasUser() {
        return !is_null($this->getUser());
    }
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\CoreApplicationUrlService
     */
    public function getCoreApplicationUrlService() {
        return $this->coreApplicationUrlService;
    }
    
    
    protected function addAuthorisationToRequest(\Guzzle\Http\Message\Request $request) {
        $request->addHeaders(array(
            'Authorization' => 'Basic ' . base64_encode($this->getUser()->getUsername().':'.$this->getUser()->getPassword())
        ));
        
        return $request;                
    }
    
}