<?php

namespace SimplyTestable\WebsiteBundle\Services;

class TestListService extends CoreApplicationService {        
    
    private $finishedStates = array(
        'rejected',
        'failed-no-sitemap',
        'cancelled',
        'completed'
    );
    
    
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
                'new',
                'resolving',
                'resolved',
                'preparing'
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
                
                $test->completion_percent = $this->getCompletionPercent($test);
                
                $tests[$index]->formatted_website = $this->getFormattedUrl($test->website);
            }
            
            return $tests;
        } catch (\Exception $ex) {
            return array();
        }
        
        return array();
    }
    
    
    /**
     * 
     * @param \stdClass $test
     * @return boolean
     */
    private function isFinished(\stdClass $test) {
        return in_array($test->state, $this->finishedStates);
    }
    
    
    /**
     * 
     * @param \stdClass $test
     * @return boolean
     */
    private function isIncomplete(\stdClass $test) {
        return !$this->isFinished($test);
    }
    
    
    /**
     * 
     * @param \stdClass $test
     * @return float
     */
    private function getCompletionPercent(\stdClass $test) {
        if ($this->isFinished($test)) {
            return 100;
        }
        
        $incompleteTaskCount = $this->getIncompleteTaskCount($test);
        if ($incompleteTaskCount == 0) {
            return 0;
        }
        
        return (($test->task_count - $incompleteTaskCount) / $test->task_count) * 100;
        
    }
    
    
    /**
     * 
     * @param \stdClass $test
     * @return int
     */
    private function getIncompleteTaskCount(\stdClass $test) {
        $incompleteTaskStates = array(
            'queued',
            'queued-for-assignment',
            'in-progress'
        );
        
        $count = 0;
        
        foreach ($incompleteTaskStates as $incompleteTaskState) {           
            $count += $test->task_count_by_state->$incompleteTaskState;
        }
        
        return $count;
    }
    
    
    private function getFormattedUrl($url) {
        return str_replace(array(
            'http://',
            'https://'
        ), '', $url);
    }
    
}