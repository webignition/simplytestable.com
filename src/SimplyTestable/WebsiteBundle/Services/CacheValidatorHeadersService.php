<?php
namespace SimplyTestable\WebsiteBundle\Services;

use Doctrine\ORM\EntityManager;
use SimplyTestable\WebsiteBundle\Entity\CacheValidatorHeaders;


class CacheValidatorHeadersService {    
    
    const ENTITY_NAME = 'SimplyTestable\WebsiteBundle\Entity\CacheValidatorHeaders';      
    
    /**
     *
     * @var EntityManager 
     */
    private $entityManager;    
    

    /**
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    private $entityRepository;    

    
    /**
     *
     * @param EntityManager $entityManager 
     */
    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    
    /**
     *
     * @param string $identifier
     * @return \SimplyTestable\WebsiteBundle\Entity\CacheValidatorHeaders 
     */
    public function get($identifier) {        
        $cacheValidatorHeader = $this->fetch($identifier);
        if (is_null($cacheValidatorHeader)) {
            $cacheValidatorHeader = $this->create($identifier);
        }
        
        return $cacheValidatorHeader;
    }
    
    
    /**
     *
     * @param CacheValidatorHeaders $cacheValidatorHeaders 
     */
    public function store(CacheValidatorHeaders $cacheValidatorHeaders) {
        $this->entityManager->persist($cacheValidatorHeaders);
        $this->entityManager->flush();
    }
    
    
    public function clear() {
        $all = $this->getEntityRepository()->findAll();
        foreach ($all as $cacheValidatorHeaders) {
            $this->entityManager->remove($cacheValidatorHeaders);
        }
        
        $this->entityManager->flush();
    }
    
    
    /**
     *
     * @param string $identifier
     * @return \SimplyTestable\WebsiteBundle\Entity\CacheValidatorHeaders 
     */    
    private function fetch($identifier) {
        return $this->getEntityRepository()->findOneBy(array(
            'identifier' => $identifier
        ));        
    }
    
    
    /**
     *
     * @param string $identifier
     * @return \SimplyTestable\WebsiteBundle\Entity\CacheValidatorHeaders 
     */
    private function create($identifier) {
        $cacheValidatorHeaders = new CacheValidatorHeaders();
        $cacheValidatorHeaders->setIdentifier($identifier);
        $cacheValidatorHeaders->setLastModifiedDate(new \DateTime());
        
        $this->entityManager->persist($cacheValidatorHeaders);
        $this->entityManager->flush();
        
        return $cacheValidatorHeaders;
    }
    
    
    /**
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository() {
        if (is_null($this->entityRepository)) {
            $this->entityRepository = $this->entityManager->getRepository(self::ENTITY_NAME);
        }
        
        return $this->entityRepository;
    }
    
}