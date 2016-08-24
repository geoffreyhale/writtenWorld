<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoleRepository")
 */
class Role
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="Story", mappedBy="roles")
     */
    private $stories;


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
     * Set name
     *
     * @param string $name
     *
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set description
     *
     * @param string $description
     *
     * @return Role
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add story
     *
     * @param \AppBundle\Entity\Story $story
     *
     * @return Role
     */
    public function addStory(\AppBundle\Entity\Story $story)
    {
        $this->stories[] = $story;

        return $this;
    }

    /**
     * Remove story
     *
     * @param \AppBundle\Entity\Story $story
     */
    public function removeStory(\AppBundle\Entity\Story $story)
    {
        $this->stories->removeElement($story);
    }

    /**
     * Get stories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStories()
    {
        return $this->stories;
    }
}
