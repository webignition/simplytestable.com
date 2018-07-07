<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Model\CacheValidatorIdentifier;

/**
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="CacheValidatorHeaders",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="identifier_idx", columns={"identifier"})
 *     }
 * )
 */
class CacheValidatorHeaders
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var CacheValidatorIdentifier
     * @ORM\Column(type="string", nullable=false)
     */
    private $identifier;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $lastModifiedDate;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return CacheValidatorHeaders
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return CacheValidatorIdentifier
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set lastModifiedDate
     *
     * @param DateTime $lastModifiedDate
     *
     * @return CacheValidatorHeaders
     */
    public function setLastModifiedDate(DateTime $lastModifiedDate)
    {
        $this->lastModifiedDate = $lastModifiedDate;

        return $this;
    }

    /**
     * Get lastModifiedDate
     *
     * @return DateTime
     */
    public function getLastModifiedDate()
    {
        return $this->lastModifiedDate;
    }

    /**
     * Get eTag
     *
     * @return string
     */
    public function getETag()
    {
        return md5($this->getIdentifier());
    }
}