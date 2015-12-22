<?php
// src/Alex\BlogBundle/Entity/AdvertSkill.php

namespace Alex\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alex\BlogBundle\Entity\AnnonceSkillRepository")
 */
class AnnonceSkill
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="level", type="string", length=255)
   */
  private $level;

  /**
   * @ORM\ManyToOne(targetEntity="Alex\BlogBundle\Entity\Annonce")
   * @ORM\JoinColumn(nullable=false)
   */
  private $advert;

  /**
   * @ORM\ManyToOne(targetEntity="Alex\BlogBundle\Entity\Skill")
   * @ORM\JoinColumn(nullable=false)
   */
  private $skill;
  
  // ... vous pouvez ajouter d'autres attributs bien sûr

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
     * Set level
     *
     * @param string $level
     *
     * @return AnnonceSkill
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
     * Set advert
     *
     * @param \Alex\BlogBundle\Entity\Annonce $advert
     *
     * @return AnnonceSkill
     */
    public function setAdvert(\Alex\BlogBundle\Entity\Annonce $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \Alex\BlogBundle\Entity\Annonce
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * Set skill
     *
     * @param \Alex\BlogBundle\Entity\Skill $skill
     *
     * @return AnnonceSkill
     */
    public function setSkill(\Alex\BlogBundle\Entity\Skill $skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return \Alex\BlogBundle\Entity\Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }
}
