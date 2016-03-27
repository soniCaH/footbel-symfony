<?php

namespace KevinVR\FootbalistoBackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Season
 *
 * @ORM\Table(name="season")
 * @ORM\Entity(repositoryClass="KevinVR\FootbalistoBackendBundle\Repository\SeasonRepository")
 */
class Season
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
     * @Assert\NotBlank()
     * @ORM\Column(name="shorthand", type="string", length=4, unique=true)
     */
    private $shorthand;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * @ORM\OneToMany(targetEntity="Resource", mappedBy="season")
     */
    protected $resources;

    /**
     * Season constructor.
     * @param string    $shorthand
     * @param string    $label
     * @param \DateTime $start
     * @param \DateTime $end
     */
    public function __construct($shorthand = null, $label = null, \DateTime $start = null, \DateTime $end = null)
    {
        $this->setShorthand($shorthand);
        $this->setLabel($label);
        $this->setStart($start);
        $this->setEnd($end);
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
     * Get shorthand
     *
     * @return string
     */
    public function getShorthand()
    {
        return $this->shorthand;
    }

    /**
     * Set shorthand
     *
     * @param string $shorthand
     *
     * @return Season
     */
    public function setShorthand($shorthand)
    {
        $this->shorthand = $shorthand;

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
     * Set label
     *
     * @param string $label
     *
     * @return Season
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Season
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Season
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Add resource
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Resource $resource
     *
     * @return Season
     */
    public function addResource(\KevinVR\FootbalistoBackendBundle\Entity\Resource $resource)
    {
        $this->resources[] = $resource;

        return $this;
    }

    /**
     * Remove resource
     *
     * @param \KevinVR\FootbalistoBackendBundle\Entity\Resource $resource
     */
    public function removeResource(\KevinVR\FootbalistoBackendBundle\Entity\Resource $resource)
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
