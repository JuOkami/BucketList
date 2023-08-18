<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Cassandra\Date;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish')]
class WishController extends AbstractController
{
    #[Route('/list', name: '_list')]
    public function wishliste(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findAllPublished();

        return $this->render('wish/liste.html.twig', [
            'wishes' => $wishes,
            'controller_name' => 'WishController',
        ]);
    }

    #[Route('/listexauce', name: '_listexauce')]
    public function wishlisteexauce(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(['isPublished' => 0], ['dateCreated'=> 'DESC']);

        return $this->render('wish/listeexauce.html.twig', [
            'wishes' => $wishes,
            'controller_name' => 'WishController',
        ]);
    }

    #[Route('/detail/{wish}', name: '_detail')]
    public function wishdetail(Wish $wish): Response
    {
        return $this->render('wish/detail.html.twig', [
            'controller_name' => 'WishController',
            'wish' => $wish
        ]);
    }

    #[Route('/valider/{wish}', name: '_valider')]
    public function wishvalider(
        EntityManagerInterface $entityManager,
        Wish $wish): Response
    {
        if ($wish->isIsPublished()){
            $wish->setIsPublished(false);
        } else {
            $wish->setIsPublished(true);
        }

        $entityManager->persist($wish);
        $entityManager->flush();

        if ($wish->isIsPublished()){
            return $this->redirectToRoute("wish_list");
        } else {
            return $this->redirectToRoute("wish_listexauce");
        }

    }

    #[Route(
        '/creation',
        name: '_creation',
    )]
    public function creation(
        EntityManagerInterface $entityManager,
        Request $requete
    ): Response
    {
        $wish = new Wish();
        $wish->setDateCreated(new \DateTime());
        $wish->setIsPublished(true);

        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm -> handleRequest($requete);

        if($wishForm->isSubmitted() && $wishForm->isValid()){
            $entityManager->persist($wish);
            $entityManager->flush();
            $this->addFlash('success', 'wish ajoutée avec succès');
            return $this->redirectToRoute("wish_detail", ["wish" => $wish->getId()]);
        }

        return $this->render('wish/creation.html.twig', [
            'wishForm' => $wishForm,
            'controller_name' => 'WishController'
        ]);
    }

}
