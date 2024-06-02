<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Games;

class HomeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/api/games/basic/all", name: "api_games", methods: ["GET"])]
    public function getGames(): JsonResponse
    {
        $games = $this->entityManager->getRepository(Games::class)->findAll();
        $gamesData = [];
        $totalScores = 0;
        $reviewCount = 0;
        $overallScore = 0;
        foreach ($games as $game) {
            $genreNames = [];

            foreach ($game->getGameGenres() as $genre) 
                $genreNames[] = $genre->getGenreName();

            foreach ($game->getGamePlatforms() as $platform)
                $platformNames[] = $platform->getPlatformName();

            foreach ($game->getReviews() as $review){
                $totalScores[] = $review->getRatingGiven();
                $reviewCount++;
            }

            if($reviewCount!=0) $overallScore = $totalScores/$reviewCount;
            $gamesData[] = [
                'id' => $game->getId(),
                'name' => $game->getGameName(),
                'score' => $overallScore,
                'genres' => $genreNames,
                'platforms' => $platformNames,
                'image' => $game->getGameCover()
            ];
        }
        return new JsonResponse($gamesData);
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
