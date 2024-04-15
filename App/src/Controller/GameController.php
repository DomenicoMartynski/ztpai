<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GameController extends AbstractController
{
    #[Route('/add_game', name: 'app_addgame')]
    public function add_game(): Response
    {
        return $this->render('game/add_game.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
    #[Route('/gamedetails', name: 'app_gamedetails')]
    public function gamedetails(): Response
    {
        return $this->render('game/gamedetails.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
    #[Route('/search', name: 'app_search')]
    public function search(): Response
    {
        return $this->render('game/search.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
    #[Route('/category', name: 'app_category')]
    public function category(): Response
    {
        return $this->render('game/category.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}
