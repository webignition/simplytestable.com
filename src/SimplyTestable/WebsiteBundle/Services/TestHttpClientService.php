<?php
namespace SimplyTestable\WebsiteBundle\Services;

use Guzzle\Http\Client as HttpClient;

class TestHttpClientService extends HttpClientService {   
    
    public function get($baseUrl = '', $config = null) {
        if (is_null($this->httpClient)) {
            $this->httpClient = new HttpClient($baseUrl, $config);        
        }
        
        return $this->httpClient;
    }
    
    
    /**
     * 
     * @return \Guzzle\Plugin\Mock\MockPlugin
     */
    public function getMockPlugin() {
        if (!$this->hasMockPlugin()) {
            $this->get()->addSubscriber(new \Guzzle\Plugin\Mock\MockPlugin()); 
        }
        
        $beforeSendListeners = $this->get()->getEventDispatcher()->getListeners('request.before_send');
        
        foreach ($beforeSendListeners as $beforeSendListener) {
            if (get_class($beforeSendListener[0]) == 'Guzzle\Plugin\Mock\MockPlugin') {
                return $beforeSendListener[0];
            }
        }
    }
    
    
    /**
     * 
     * @return boolean
     */
    private function hasMockPlugin() {
        $beforeSendListeners = $this->get()->getEventDispatcher()->getListeners('request.before_send');
        
        foreach ($beforeSendListeners as $beforeSendListener) {
            if (get_class($beforeSendListener[0]) == 'Guzzle\Plugin\Mock\MockPlugin') {
                return true;
            }
        }
        
        return false;     
    }    
    
}