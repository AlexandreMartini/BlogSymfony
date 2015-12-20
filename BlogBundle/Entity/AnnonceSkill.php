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
}