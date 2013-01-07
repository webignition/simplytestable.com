<?php
namespace SimplyTestable\WebsiteBundle\Services;

class NotFoundRedirectService {    
    
    /**
     *
     * @var array
     */
    private $replacements = array();
    
    /**
     *
     * @var array
     */
    private $notFoundRedirectMap = array();
    
    /**
     *
     * @var string
     */
    private $normalisedRequestUri = '';
    
    /**
     * 
     * @param array $web_client_parameters
     */
    public function __construct($web_client_parameters, $not_found_redirect_map) {
        $this->replacements['web_client'] = $web_client_parameters['urls'];
        $this->notFoundRedirectMap = $not_found_redirect_map;
    }
    
    
    /**
     * 
     * @param string $requestUri
     * @return boolean
     */
    public function hasRedirectFor($requestUri) {
        $this->setNormalisedRequestUri($requestUri);            
        if (isset($this->notFoundRedirectMap[$this->getNormalisedRequestUri()])) {
            return true;
        }
        
        if (isset($this->notFoundRedirectMap[$this->getNormalisedRequestUri().'/'])) {
            return true;
        }
        
        return $this->hasRedirectFor($requestUri.'/');
    }
    
    
    /**
     * 
     * @param string $requestUri
     * @return string
     */
    public function getRedirectFor($requestUri) {        
        if (!$this->hasRedirectFor($requestUri)) {
            return '';
        }
        
        return $this->replaceParameters($this->notFoundRedirectMap[$this->getNormalisedRequestUri()]);
    }
    
    
    private function replaceParameters($parameterisedUrl) {
        $matches = array();        
        preg_match_all('/{{[^}]+}}/', $parameterisedUrl, $matches);
        
        $rawParameters = $matches[0];
        
        $parameters = array();
        $url = $parameterisedUrl;
        
        foreach ($rawParameters as $rawParameter) {
            $rawParameterParts = $this->getRawParameterParts($rawParameter);

            if (!isset($parameters[$rawParameterParts['context']])) {
                $parameters[$rawParameterParts['context']] = array();
            }

            $parameters[$rawParameterParts['context']][] = $rawParameterParts['key'];
        }        
        
        foreach ($parameters as $parameterSetKey => $values) {
            $url = $this->replaceParameterSet($url, $parameterSetKey, $values);
        }
        
        return $url;
    }
    
    
    private function replaceParameterSet($url, $parameterSetKey, $values) {
        foreach ($values as $value) {
            $placeholder = '{{'.$parameterSetKey.'::'.$value.'}}';
            $replacement = $this->replacements[$parameterSetKey][$value];            
            $url = str_replace($placeholder, $replacement, $url);
        }
        
        return $url;
    }
    
    
    private function getRawParameterParts($rawParameter) {
        $rawParameter = str_replace(array('{{', '}}'), '', $rawParameter);
        
        $rawParameterParts = explode('::', $rawParameter);

        return array(
            'context' => $rawParameterParts[0],
            'key' => $rawParameterParts[1]
        );
    }
    
    
    /**
     * 
     * @param string $requestUri
     */
    private function setNormalisedRequestUri($requestUri) {
        if (preg_match('/^\/app_dev.php/', $requestUri) > 0) {
            $requestUri = preg_replace('/^\/app_dev.php/', '', $requestUri);
        }
        
        $this->normalisedRequestUri = $requestUri;
    }
    
    
    /**
     * 
     * @return string
     */
    private function getNormalisedRequestUri() {
        return $this->normalisedRequestUri;
    }
    
}