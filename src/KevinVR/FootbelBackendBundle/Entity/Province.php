<?php

namespace KevinVR\FootbelBackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Province
 *
 * @ORM\Table(name="province")
 * @ORM\Entity(repositoryClass="KevinVR\FootbelBackendBundle\Repository\ProvinceRepository")
 */
class Province
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
     * @ORM\Column(name="shorthand", type="string", length=3, unique=true)
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
     * Level constructor.
     */
    public function __construct()
    {
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
     * Set shorthand
     *
     * @param string $shorthand
     *
     * @return Province
     */
    public function setShorthand($shorthand)
    {
        $this->shorthand = $shorthand;

        return $this;
    }

    /**
     * Get shorthand
     *
     * @return string
     */
    public function getShorthand()
    {
        return $this->shorthand;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Province
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

    /**
     * Add resource
     *
     * @param \KevinVR\FootbelBackendBundle\Entity\Resource $resource
     *
     * @return Province
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
