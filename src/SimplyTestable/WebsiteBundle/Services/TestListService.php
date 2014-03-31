<?php

namespace SimplyTestable\WebsiteBundle\Services;

class TestListService extends CoreApplicationService {        
    
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
        
        $url = $this->getUrl('jobs_list', array(
            'limit' =>  $limit,
            'offset' => $offset
        )) . '?' . http_build_query($queryParameters);
        
        $request = $this->httpClientService->getRequest($url);
        
        $this->addAuthorisationToRequest($request);
        
        try {
            return $this->webResourceService->get($request)->getContentObject()->jobs;            
        } catch (\Exception $ex) {
            return array();
        }
        
        return array();
    }
    
}