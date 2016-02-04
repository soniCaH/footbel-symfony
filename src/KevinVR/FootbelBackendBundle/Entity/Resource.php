<?php

namespace KevinVR\FootbelBackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resource
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
     * @var string
     *
     * @ORM\Column(name="season", type="string", length=10)
     */
    private $season;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=4)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=3, nullable=true)
     */
    private $province;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="checked", type="datetime")
     */
    private $checked;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="queued", type="datetime")
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set season
     *
     * @param string $season
     *
     * @return Resource
     */
    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return string
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return Resource
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set province
     *
     * @param string $province
     *
     * @return Resource
     */
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Resource
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * Get checked
     *
     * @return \DateTime
     */
    public function getChecked()
    {
        return $this->checked;
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
     * Get queued
     *
     * @return \DateTime
     */
    public function getQueued()
    {
        return $this->queued;
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
     * Get modified
     *
     * @return bool
     */
    public function getModified()
    {
        return $this->modified;
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
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
}
