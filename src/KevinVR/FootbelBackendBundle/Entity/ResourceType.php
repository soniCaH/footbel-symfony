<?php

namespace KevinVR\FootbelBackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="shorthand", type="string", length=10, unique=true)
     */
    private $shorthand;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="Resource", mappedBy="level")
     */
    protected $resources;

    /**
     * ResourceType constructor.
     * @param string $shorthand
     * @param string $label
     */
    public function __construct($shorthand = null, $label = null)
    {
        $this->setShorthand($shorthand);
        $this->setLabel($label);
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
    public function getShorthand()
    {
        return $this->shorthand;
    }

    /**
     * Set name
     *
     * @param string $shorthand
     *
     * @return ResourceType
     */
    public function setShorthand($shorthand)
    {
        $this->shorthand = $shorthand;

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

    /**
     * Set label
     *
     * @param string $label
     *
     * @return ResourceType
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}
