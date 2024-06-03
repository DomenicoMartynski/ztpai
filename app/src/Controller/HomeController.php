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
    #[Route("/api/games/basic/featured", name: "api_featured_games", methods: ["GET"])]
    public function getFeaturedGames(): JsonResponse
    {
        $games = $this->entityManager->getRepository(Games::class)->findAll();
        $filteredGames = [];
        $totalScore = 0;
        $reviewCount = 0;
        $overallScore = 0;
        foreach ($games as $game) {
            $genreNames = [];
            $platformNames = [];
            foreach ($game->getGameGenres() as $genre) 
                $genreNames[] = $genre->getGenreName();

            foreach ($game->getGamePlatforms() as $platform)
                $platformNames[] = $platform->getPlatformName();

            foreach ($game->getReviews() as $review){
                $totalScore += $review->getRatingGiven();
                $reviewCount++;
            }

            if($reviewCount!=0) $overallScore = $totalScore/$reviewCount;
            $filteredGames[] = [
                'id' => $game->getId(),
                'name' => $game->getGameName(),
                'score' => $overallScore,
                'genres' => $genreNames,
                'platforms' => $platformNames,
                'image' => $game->getGameCover()
            ];
        }
        usort($filteredGames, function($a, $b) {
            return $b['id'] <=> $a['id'];
        });

        $featuredGames = array_slice($filteredGames, 0, 9);

        return new JsonResponse($featuredGames);
    }
    #[Route("/api/games/basic/worst", name: "api_worst_games", methods: ["GET"])]
    public function getWorstGames(): JsonResponse
    {
        $games = $this->entityManager->getRepository(Games::class)->findAll();
        $filteredGames = [];
        foreach ($games as $game) {
            $totalScore = 0;
            $reviewCount = 0;
            $overallScore = 0;
            foreach ($game->getGameGenres() as $genre) 
                $genreNames[] = $genre->getGenreName();

            foreach ($game->getGamePlatforms() as $platform)
                $platformNames[] = $platform->getPlatformName();

            foreach ($game->getReviews() as $review){
                $totalScore += $review->getRatingGiven();
                $reviewCount++;
            }

            if($reviewCount!=0) $overallScore = $totalScore/$reviewCount;
            
            if ($reviewCount > 5 && $overallScore < 2.0) {
                $filteredGames[] = [
                    'id' => $game->getId(),
                    'name' => $game->getGameName(),
                    'score' => $overallScore,
                    'genres' => $genreNames,
                    'platforms' => $platformNames,
                    'image' => $game->getGameCover()
                ];
            }
        }
        usort($filteredGames, function($a, $b) {
            return $a['score'] <=> $b['score'];
        });
    
        $worstGames = array_slice($filteredGames, 0, 9);

        return new JsonResponse($worstGames);
    }

    #[Route("/api/games/basic/best", name: "api_best_games", methods: ["GET"])]
    public function getBestGames(): JsonResponse
    {
        $games = $this->entityManager->getRepository(Games::class)->findAll();
        $filteredGames = [];

        foreach ($games as $game) {
            $totalScore = 0;
            $reviewCount = 0;
            $overallScore = 0;
            foreach ($game->getGameGenres() as $genre) 
                $genreNames[] = $genre->getGenreName();

            foreach ($game->getGamePlatforms() as $platform)
                $platformNames[] = $platform->getPlatformName();

            foreach ($game->getReviews() as $review){
                $totalScore += $review->getRatingGiven();
                $reviewCount++;
            }

            if($reviewCount!=0) $overallScore = $totalScore/$reviewCount;
            
            if ($reviewCount > 5 && $overallScore > 4.5) {
                $filteredGames[] = [
                    'id' => $game->getId(),
                    'name' => $game->getGameName(),
                    'score' => $overallScore,
                    'genres' => $genreNames,
                    'platforms' => $platformNames,
                    'image' => $game->getGameCover()
                ];
            }
        }
        usort($filteredGames, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
    
        $bestGames = array_slice($filteredGames, 0, 9);

        return new JsonResponse($bestGames);
    }


    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
