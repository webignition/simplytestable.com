<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use webignition\Http\Client\Client as HttpClient;
use webignition\NormalisedUrl\NormalisedUrl;


class CoreApplicationProxyController extends Controller
{  
    private $allowedHosts = array('app.simplytestable.com');
    
    
    public function indexAction()
    {
        $requestedUrl = $this->getRequest()->get('url');
        if (is_null($requestedUrl)) {
            return new Response('', 404);
        }
        
        $normalisedUrl = new NormalisedUrl($requestedUrl);
        if (!in_array($normalisedUrl->getHost(), $this->allowedHosts)) {
            return new Response('', 404);
        }
        
        $url = str_replace(' ', '%20', (string)$normalisedUrl);
        
        $httpRequest = $this->getAuthorisedHttpRequest($url);        
        $httpResponse = $this->getHttpClient()->getResponse($httpRequest);
        
        if ($httpResponse->getResponseCode() != 200) {
            return new Response('', 503);
        }
        
        return new Response($httpResponse->getBody(), 200, array(
            'content-type' => $httpResponse->getHeader('content-type')
        ));
    }
    
    
    /**
     *
     * @return HttpClient 
     */
    private function getHttpClient() {
        return $this->get('simplytestable.services.httpClient');
    }
    
    
    protected function getAuthorisedHttpRequest($url = '', $request_method = HTTP_METH_GET, $options = array()) {
        $httpRequest = new \HttpRequest($url, $request_method, $options);
        $httpRequest->addHeaders(array(
            'Authorization' => 'Basic ' . base64_encode('public:public')
        ));
        
        return $httpRequest;
    }    
}
