<?php

namespace SimplyTestable\WebsiteBundle\Services;

class TestListService extends CoreApplicationService {        
    
    /**
     *
     * @var type 
     */
    private $webClientUrlService;
    
    
    public function __construct(
        \SimplyTestable\WebsiteBundle\Services\CoreApplicationUrlService $coreApplicationUrlService,
        \SimplyTestable\WebsiteBundle\Services\HttpClientService $httpClientService,
        \webignition\WebResource\Service\Service $webResourceService,
        \SimplyTestable\WebsiteBundle\Services\WebClientUrlService $webClientUrlService
    ) {
        parent::__construct($coreApplicationUrlService, $httpClientService, $webResourceService);
        $this->webClientUrlService = $webClientUrlService;
    }     
    
    public function getTests($limit = 3, $offset = 0) {
        $queryParameters = array(
            'exclude-types' => array(
                'crawl'
            ),
            'exclude-states' => array(
                'rejected',
                'failed-no-sitemap',
                'cancelled'
            )
        );
        
        $url = $this->getCoreApplicationUrlService()->getUrl('jobs_list', array(
            'limit' =>  $limit,
            'offset' => $offset
        )) . '?' . http_build_query($queryParameters);
        
        $request = $this->httpClientService->getRequest($url);
        
        $this->addAuthorisationToRequest($request);
        
        try {
            $tests = $this->webResourceService->get($request)->getContentObject()->jobs;
            
            foreach ($tests as $index => $test) {
                $tests[$index]->results_url = $this->webClientUrlService->getUrl('test_results', array(
                    'website' => $test->website,
                    'testId' => $test->id
                ));              
                
                $tests[$index]->progress_url = $this->webClientUrlService->getUrl('test_progress', array(
                    'website' => $test->website,
                    'testId' => $test->id
                )); 
                
                $tests[$index]->formatted_website = $this->getFormattedUrl($test->website);
            }
            
            return $tests;
        } catch (\Exception $ex) {
            return array();
        }
        
        return array();
    }
    
    
    private function getFormattedUrl($url) {
        return str_replace(array(
            'http://',
            'https://'
        ), '', $url);
    }
    
}