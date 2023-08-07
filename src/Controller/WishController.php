<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish')]
class WishController extends AbstractController
{
    #[Route('/list', name: '_list')]
    public function wishliste(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(["isPublished" => true],["dateCreated"=>"ASC"]);

        return $this->render('wish/liste.html.twig', [
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

}
