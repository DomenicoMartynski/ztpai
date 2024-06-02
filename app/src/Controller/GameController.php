<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Platforms;
use App\Entity\Genres;
use App\Entity\Reviews;
use App\Entity\Games;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
class GameController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/api/platforms", name: "api_platforms", methods: ["GET"])]
    public function getPlatforms(): JsonResponse
    {
        $platforms = $this->entityManager->getRepository(Platforms::class)->findAll();
        $platformsData = [];

        foreach ($platforms as $platform) {
            $platformsData[] = [
                'id' => $platform->getId(),
                'name' => $platform->getPlatformName(),
            ];
        }

        return new JsonResponse($platformsData);
    }

    #[Route("/api/genres", name: "api_genres", methods: ["GET"])]
    public function getGenres(): JsonResponse
    {
        $genres = $this->entityManager->getRepository(Genres::class)->findAll();
        $genresData = [];

        foreach ($genres as $genre) {
            $genresData[] = [
                'id' => $genre->getId(),
                'name' => $genre->getGenreName(),
            ];
        }

        return new JsonResponse($genresData);
    }

    #[Route('/api/add_game', methods: ['POST'])]
    public function add_game(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $date = new DateTime($data['date']);
        $description = $data['description'];
        $platforms = $data['platforms'];
        $genres = $data['genres'];

        
        $game = new Games();
        foreach($genres as $genre => $value){
            $game_genre = $this->entityManager->getRepository(Genres::class)->find($value);
            $game->addGameGenre($game_genre);
        }
        foreach($platforms as $platform => $value){
            $game_platform = $this->entityManager->getRepository(Platforms::class)->find($value);
            $game->addGamePlatform($game_platform);
        }
        // $game_genres->set;
        $game->setGameName($name);
        $game->setReleaseDate($date);
        $game->setDescription($description);
        $game->setGameCover("TBD.png");

        $this->entityManager->persist($game);
        $this->entityManager->flush();

        $responseData = [
            'message' => 'Game added successfully',
        ];

        return new JsonResponse($responseData, JsonResponse::HTTP_CREATED);
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
