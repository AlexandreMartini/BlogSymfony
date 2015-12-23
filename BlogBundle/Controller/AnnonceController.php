<?php

// src/Alex/BlogBundle/Controller/AnnonceController.php

namespace Alex\BlogBundle\Controller;

use Alex\BlogBundle\Entity\Annonce;
use Alex\BlogBundle\Entity\AnnonceSkill;
use Alex\BlogBundle\Entity\Image;
use Alex\BlogBundle\Entity\Application;
use Alex\BlogBundle\Form\AnnonceType;
use Alex\BlogBundle\Form\AnnonceEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnnonceController extends Controller
{
public function indexAction($page)
  {
    if ($page < 1) {
      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    }
  // Ici je fixe le nombre d'annonces par page à 3
    // Mais bien sûr il faudrait utiliser un paramètre, et y accéder via $this->container->getParameter('nb_per_page')
    $nbPerPage = 3;

    // On récupère notre objet Paginator
    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('AlexBlogBundle:Annonce')
      ->getAdverts($page, $nbPerPage)
    ;

    // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
    $nbPages = ceil(count($listAdverts)/$nbPerPage);

    // Si la page n'existe pas, on retourne une 404
    if ($page > $nbPages) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }

    // On donne toutes les informations nécessaires à la vue
    return $this->render('AlexBlogBundle:Annonce:index.html.twig', array(
      'listAdverts' => $listAdverts,
      'nbPages'     => $nbPages,
      'page'        => $page
    ));

    // Pour récupérer la liste de toutes les annonces : on utilise findAll()
    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('AlexBlogBundle:Annonce')
      ->findAll() ;    

    // Et modifiez le 2nd argument pour injecter notre liste
    return $this->render('AlexBlogBundle:Annonce:index.html.twig', array(
      'listAdverts' => $listAdverts));
  }

  public function viewAction($id)
  {
      $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em
      ->getRepository('AlexBlogBundle:Annonce')
      ->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On récupère maintenant la liste des Compétences
    $listAdvertSkills = $em
      ->getRepository('AlexBlogBundle:AnnonceSkill')
      ->findByAdvert($advert);


    return $this->render('AlexBlogBundle:Annonce:view.html.twig', array(
      'advert'           => $advert,
      'listAdvertSkills' => $listAdvertSkills ));
  }
  
  public function menuAction($limit = 3)
  {
     $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('AlexBlogBundle:Annonce')
      ->findBy(
        array(),                 // Pas de critère
        array('date' => 'desc'), // On trie par date décroissante
        $limit,                  // On sélectionne $limit annonces
        0                        // À partir du premier
    );

    return $this->render('AlexBlogBundle:Annonce:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }


  public function addAction(Request $request)
  {
    $advert = new Annonce();
    $form = $this->createForm(new AnnonceType(), $advert);

    if ($form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      return $this->redirect($this->generateUrl('alex_blog_view', array('id' => $advert->getId())));
    }

    return $this->render('AlexBlogBundle:Annonce:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  public function editAction($id, Request $request)
  {
  
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('AlexBlogBundle:Annonce')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }
    $form = $this->createForm(new AnnonceEditType(), $advert);

    if ($form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre annonce
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirect($this->generateUrl('alex_blog_view', array('id' => $advert->getId())));
    }

    return $this->render('AlexBlogBundle:Annonce:edit.html.twig', array(
      'form'   => $form->createView(),
      'advert' => $advert // Je passe également l'annonce à la vue si jamais elle veut l'afficher
    ));
  }
  
  public function deleteAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('AlexBlogBundle:Annonce')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

     // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->createFormBuilder()->getForm();

    if ($form->handleRequest($request)->isValid()) {
      $em->remove($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");

      return $this->redirect($this->generateUrl('alex_blog_home'));
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('AlexBlogBundle:Annonce:delete.html.twig', array(
      'advert' => $advert,
      'form'   => $form->createView()
    ));
  }
}