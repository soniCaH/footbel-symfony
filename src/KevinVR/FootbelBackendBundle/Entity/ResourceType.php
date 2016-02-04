<?php

namespace KevinVR\FootbelBackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ResourceType
 *
 * @ORM\Table(name="resource_type")
 * @ORM\Entity(repositoryClass="KevinVR\FootbelBackendBundle\Repository\ResourceTypeRepository")
 */
class ResourceType
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Resource", mappedBy="level")
     */
    protected $resources;

    /**
     * ResourceType constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
        $this->resources = new ArrayCollection();
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ResourceType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add resource
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Resource $resource
     *
     * @return ResourceType
     */
    public function addResource(\KevinVR\FootbelBackendBundle\Entity\Resource $resource)
    {
        $this->resources[] = $resource;

        return $this;
    }

    /**
     * Remove resource
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Resource $resource
     */
    public function removeResource(\KevinVR\FootbelBackendBundle\Entity\Resource $resource)
    {
        $this->resources->removeElement($resource);
    }

    /**
     * Get resources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResources()
    {
        return $this->resources;
    }
}
