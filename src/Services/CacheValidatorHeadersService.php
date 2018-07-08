<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\CacheValidatorHeaders;

class CacheValidatorHeadersService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $entityRepository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $identifier
     *
     * @return CacheValidatorHeaders
     */
    public function get($identifier)
    {
        $cacheValidatorHeader = $this->fetch($identifier);
        if (is_null($cacheValidatorHeader)) {
            $cacheValidatorHeader = $this->create($identifier);
        }

        return $cacheValidatorHeader;
    }

    /**
     * @param CacheValidatorHeaders $cacheValidatorHeaders
     */
    public function store(CacheValidatorHeaders $cacheValidatorHeaders)
    {
        $this->entityManager->persist($cacheValidatorHeaders);
        $this->entityManager->flush();
    }

    public function clear()
    {
        $all = $this->getEntityRepository()->findAll();
        foreach ($all as $cacheValidatorHeaders) {
            $this->entityManager->remove($cacheValidatorHeaders);
        }

        $this->entityManager->flush();
    }

    /**
     * @param string $identifier
     *
     * @return CacheValidatorHeaders
     */
    private function fetch($identifier)
    {
        /* @var CacheValidatorHeaders $cacheValidatorHeaders */
        $cacheValidatorHeaders = $this->getEntityRepository()->findOneBy([
            'identifier' => $identifier
        ]);

        return $cacheValidatorHeaders;
    }

    /**
     * @param string $identifier
     *
     * @return CacheValidatorHeaders
     */
    private function create($identifier)
    {
        $cacheValidatorHeaders = new CacheValidatorHeaders();
        $cacheValidatorHeaders->setIdentifier($identifier);
        $cacheValidatorHeaders->setLastModifiedDate(new \DateTime());

        $this->entityManager->persist($cacheValidatorHeaders);
        $this->entityManager->flush();

        return $cacheValidatorHeaders;
    }

    /**
     * @return EntityRepository
     */
    public function getEntityRepository()
    {
        if (is_null($this->entityRepository)) {
            $this->entityRepository = $this->entityManager->getRepository(CacheValidatorHeaders::class);
        }

        return $this->entityRepository;
    }
}
