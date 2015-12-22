<?php
// src/OC/PlatformBundle/Entity/Application.php

namespace Alex\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alex\BlogBundle\Entity\ApplicationRepository")
 */
class Application
{
  /**
   * @ORM\ManyToOne(targetEntity="Alex\BlogBundle\Entity\Annonce", inversedBy="applications")
   * @ORM\JoinColumn(nullable=false)
   */
  private $advert;

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="author", type="string", length=255)
   */
  private $author;

  /**
   * @ORM\Column(name="content", type="text")
   */
  private $content;

  /**
   * @ORM\Column(name="date", type="datetime")
   */
  private $date;
  
  public function __construct()
  {
    $this->date = new \Datetime();
  }

  public function getId()
  {
    return $this->id;
  }

  public function setAuthor($author)
  {
    $this->author = $author;

    return $this;
  }

  public function getAuthor()
  {
    return $this->author;
  }

  public function setContent($content)
  {
    $this->content = $content;

    return $this;
  }

  public function getContent()
  {
    return $this->content;
  }

  public function setDate($date)
  {
    $this->date = $date;

    return $this;
  }

  public function getDate()
  {
    return $this->date;
  }

    /**
     * Set advert
     *
     * @param \Alex\BlogBundle\Entity\Annonce $advert
     *
     * @return Application
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
}
