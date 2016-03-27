<?php

namespace KevinVR\FootbalistoBackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Resource entity.
 *
 * @ORM\Table(name="resource")
 * @ORM\Entity(repositoryClass="KevinVR\FootbalistoBackendBundle\Repository\ResourceRepository")
 */
class Resource implements ResourceInterface
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
     *
     * @Assert\Type(type="KevinVR\FootbalistoBackendBundle\Entity\ResourceType")
     * @Assert\Valid()
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="resources")
     * @ORM\JoinColumn(name="season", referencedColumnName="id")
     *
     * @Assert\Type(type="KevinVR\FootbalistoBackendBundle\Entity\Season")
     * @Assert\Valid()
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="resources")
     * @ORM\JoinColumn(name="level", referencedColumnName="id")
     *
     * @Assert\Type(type="KevinVR\FootbalistoBackendBundle\Entity\Level")
     * @Assert\Valid()
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="resources")
     * @ORM\JoinColumn(name="province", referencedColumnName="id")
     *
     * @Assert\Type(type="KevinVR\FootbalistoBackendBundle\Entity\Province")
     * @Assert\Valid()
     */
    private $province;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @Assert\NotBlank()
     * @Assert\NotNull()
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
     * @var string
     *
     * @ORM\Column(name="csv_path", type="string", length=255, nullable=true)
     */
    private $csv_path;

    /**
     * Resource constructor.
     * @param \KevinVR\FootbalistoBackendBundle\Entity\ResourceType $type
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Level $level
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Province $province
     * @param string $url
     */
    public function __construct(
      ResourceType $type = null,
      Season $season = null,
      Level $level = null,
      Province $province = null,
      $url = null
    ) {
        // Defaults.
        $this->setChecked(null);
        $this->setModified(true);
        $this->setQueued(null);
        $this->setHash(null);
        $this->setCsvPath(null);

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
     * @return \KevinVR\FootbalistoBackendBundle\Entity\ResourceType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\ResourceType $type
     *
     * @return Resource
     */
    public function setType(
      \KevinVR\FootbalistoBackendBundle\Entity\ResourceType $type = null
    ) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get season
     *
     * @return \KevinVR\FootbalistoBackendBundle\Entity\Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set season
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Season $season
     *
     * @return Resource
     */
    public function setSeason(
      \KevinVR\FootbalistoBackendBundle\Entity\Season $season = null
    ) {
        $this->season = $season;

        return $this;
    }

    /**
     * Get level
     *
     * @return \KevinVR\FootbalistoBackendBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set level
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Level $level
     *
     * @return Resource
     */
    public function setLevel(
      \KevinVR\FootbalistoBackendBundle\Entity\Level $level = null
    ) {
        $this->level = $level;

        return $this;
    }

    /**
     * Get province
     *
     * @return \KevinVR\FootbalistoBackendBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set province
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Province $province
     *
     * @return Resource
     */
    public function setProvince(
      \KevinVR\FootbalistoBackendBundle\Entity\Province $province = null
    ) {
        $this->province = $province;

        return $this;
    }


    /**
     * Get (last known) CSV path of the resource.
     *
     * @return string
     */
    public function getCsvPath()
    {
        return $this->csv_path;
    }

    /**
     * Set filepath of the csv file.
     *
     * @param string $csv_path
     *
     * @return Resource
     */
    public function setCsvPath($csv_path)
    {
        $this->csv_path = $csv_path;

        return $this;
    }

    public function save()
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($product);
        $em->flush();

    }


}
