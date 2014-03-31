<?php

namespace SimplyTestable\WebsiteBundle\Services;

class ParameterisedUrlService { 
    
    private $urls;
    
    public function __construct($urls) {
        $this->urls = $urls;
    }
    
    
    public function getUrl($name = null, $parameters = null) {
        $url = $this->urls['base'];
        
        if (!is_null($name)) {
            $url .= $this->urls[$name];
        }
        
        if (is_array($parameters)) {
            foreach ($parameters as $parameterName => $parameterValue) {
                $url = str_replace('{'.$parameterName.'}', $parameterValue, $url);
            }
        }
        
        return $url;
    }    
    
}