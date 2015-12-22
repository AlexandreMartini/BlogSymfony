<?php
namespace Alex\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
/**
 * Annonce
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Alex\BlogBundle\Entity\AnnonceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Annonce
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;
    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

  /**
   * @ORM\Column(name="published", type="boolean")
   */
  private $published = true;
  
 /**
 * @ORM\Column(name="updated_at", type="datetime", nullable=true)
 */
  private $updatedAt;
  
   /**
   * @ORM\OneToOne(targetEntity="Alex\BlogBundle\Entity\Image", cascade={"persist", "remove"})
   */
  private $image;
  
  /**
   * @ORM\OneToMany(targetEntity="Alex\BlogBundle\Entity\Application", mappedBy="annonce")
   */
  private $applications; // Notez le « s », une annonce est liée à plusieurs candidatures
  
   /**
   * @ORM\ManyToMany(targetEntity="Alex\BlogBundle\Entity\Category", cascade={"persist"})
   */
  private $categories;
  
  /**
   * @ORM\Column(name="nb_applications", type="integer")
   */
  private $nbApplications = 0;

  public function increaseApplication()
  {
    $this->nbApplications++;
  }

  public function decreaseApplication()
  {
    $this->nbApplications--;
  }
  
  function __construct(){
    $this->date = new \DateTime();
    $this->categories = new ArrayCollection();
    $this->applications = new ArrayCollection();
  }
  
  
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Annonce
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Set title
     *
     * @param string $title
     *
     * @return Annonce
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * Set author
     *
     * @param string $author
     *
     * @return Annonce
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }
    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * Set content
     *
     * @param string $content
     *
     * @return Annonce
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Annonce
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set image
     *
     * @param \Alex\BlogBundle\Entity\Image $image
     *
     * @return Annonce
     */
    public function setImage(\Alex\BlogBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Alex\BlogBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add category
     *
     * @param \Alex\BlogBundle\Entity\Category $category
     *
     * @return Annonce
     */
    public function addCategory(\Alex\BlogBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Alex\BlogBundle\Entity\Category $category
     */
    public function removeCategory(\Alex\BlogBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add application
     *
     * @param \Alex\BlogBundle\Entity\Application $application
     *
     * @return Annonce
     */
    public function addApplication(\Alex\BlogBundle\Entity\Application $application)
    {
        $this->applications[] = $application;
         // On lie l'annonce à la candidature
         $application->setAdvert($this);


        return $this;
    }

    /**
     * Remove application
     *
     * @param \Alex\BlogBundle\Entity\Application $application
     */
    public function removeApplication(\Alex\BlogBundle\Entity\Application $application)
    {
        $this->applications->removeElement($application);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Annonce
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

/**
 * @ORM\PreUpdate
 */
  public function updateDate()
  {
    $this->setUpdatedAt(new \Datetime());
  }
}
