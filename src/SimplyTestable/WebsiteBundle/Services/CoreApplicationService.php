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
     * @var array
     */
    private $parameters;
    
    
    public function __construct(
        $parameters,
        \SimplyTestable\WebsiteBundle\Services\HttpClientService $httpClientService,
        \webignition\WebResource\Service\Service $webResourceService
    ) {
        $this->parameters = $parameters;
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
    
    
    protected function getUrl($name = null, $parameters = null) {
        $url = $this->parameters['urls']['base'];
        
        if (!is_null($name)) {
            $url .= $this->parameters['urls'][$name];
        }
        
        if (is_array($parameters)) {
            foreach ($parameters as $parameterName => $parameterValue) {
                $url = str_replace('{'.$parameterName.'}', $parameterValue, $url);
            }
        }
        
        return $url;
    }
    
    
    protected function addAuthorisationToRequest(\Guzzle\Http\Message\Request $request) {
        $request->addHeaders(array(
            'Authorization' => 'Basic ' . base64_encode($this->getUser()->getUsername().':'.$this->getUser()->getPassword())
        ));
        
        return $request;                
    }
    
}