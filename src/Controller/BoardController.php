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
    public function new(Request $request, EntityManagerInterface $manager): Response
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

    #[Route("/edit/{id<\d+>}", methods: ["GET", "POST"])]
    public function edit(Board $board, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(BoardType::class, $board);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('app_board_edit', [
                'id' => $board->getId(),
            ]);
        }

        return $this->render('board/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

