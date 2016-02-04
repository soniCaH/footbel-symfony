<?php

namespace KevinVR\FootbelBackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Resource entity.
 *
 * @ORM\Table(name="resource")
 * @ORM\Entity(repositoryClass="KevinVR\FootbelBackendBundle\Repository\ResourceRepository")
 */
class Resource
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ResourceType", inversedBy="resources")
     * @ORM\JoinColumn(name="type", referencedColumnName="id")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="resources")
     * @ORM\JoinColumn(name="season", referencedColumnName="id")
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="resources")
     * @ORM\JoinColumn(name="level", referencedColumnName="id")
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="resources")
     * @ORM\JoinColumn(name="province", referencedColumnName="id")
     */
    private $province;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="checked", type="datetime", nullable=true)
     */
    private $checked;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="queued", type="datetime", nullable=true)
     */
    private $queued;

    /**
     * @var bool
     *
     * @ORM\Column(name="modified", type="boolean")
     */
    private $modified;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=32, nullable=true)
     */
    private $hash;

    /**
     * Resource constructor.
     * @param \KevinVR\FootbelBackendBundle\Entity\ResourceType $type
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     * @param \KevinVR\FootbelBackendBundle\Entity\Level $level
     * @param \KevinVR\FootbelBackendBundle\Entity\Province $province
     * @param string $url
     */
    public function __construct(
      ResourceType $type,
      Season $season,
      Level $level,
      Province $province,
      $url
    ) {
        // Defaults.
        $this->setChecked(null);
        $this->setModified(true);
        $this->setQueued(null);
        $this->setHash(null);

        // Parameters.
        $this->setType($type);
        $this->setSeason($season);
        $this->setLevel($level);
        $this->setProvince($province);
        $this->setUrl($url);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Resource
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get checked
     *
     * @return \DateTime
     */
    public function getChecked()
    {
        return $this->checked;
    }

    /**
     * Set checked
     *
     * @param \DateTime $checked
     *
     * @return Resource
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;

        return $this;
    }

    /**
     * Get queued
     *
     * @return \DateTime
     */
    public function getQueued()
    {
        return $this->queued;
    }

    /**
     * Set queued
     *
     * @param \DateTime $queued
     *
     * @return Resource
     */
    public function setQueued($queued)
    {
        $this->queued = $queued;

        return $this;
    }

    /**
     * Get modified
     *
     * @return boolean
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set modified
     *
     * @param boolean $modified
     *
     * @return Resource
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return Resource
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get type
     *
     * @return \KevinVR\FootbelBackendBundle\Entity\ResourceType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\ResourceType $type
     *
     * @return Resource
     */
    public function setType(
      \KevinVR\FootbelBackendBundle\Entity\ResourceType $type = null
    ) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get season
     *
     * @return \KevinVR\FootbelBackendBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set season
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Season $season
     *
     * @return Resource
     */
    public function setSeason(
      \KevinVR\FootbelBackendBundle\Entity\Season $season = null
    ) {
        $this->season = $season;

        return $this;
    }

    /**
     * Get level
     *
     * @return \KevinVR\FootbelBackendBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set level
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Level $level
     *
     * @return Resource
     */
    public function setLevel(
      \KevinVR\FootbelBackendBundle\Entity\Level $level = null
    ) {
        $this->level = $level;

        return $this;
    }

    /**
     * Get province
     *
     * @return \KevinVR\FootbelBackendBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set province
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Province $province
     *
     * @return Resource
     */
    public function setProvince(
      \KevinVR\FootbelBackendBundle\Entity\Province $province = null
    ) {
        $this->province = $province;

        return $this;
    }
}
