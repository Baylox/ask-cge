<?php

namespace App\Controller;

use App\Entity\Board;
use App\Form\BoardType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/board')]
final class BoardController extends AbstractController
{
    #[Route('/new', methods:['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $board = new Board();
        $form = $this->createForm(BoardType::class, $board);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($board);
            $manager->flush();

            return $this->redirectToRoute('app_board_new');
    }



        return $this->render('board/new.html.twig',[
            'form' => $form,
        ]);
    }
}
