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

    #[Route("/api/games/basic/all", name: "api_games", methods: ["GET"])]
    public function getGames(): JsonResponse
    {
        $games = $this->entityManager->getRepository(Games::class)->findAll();
        $gamesData = [];
        foreach ($games as $game) {
            $totalScore = 0;
            $reviewCount = 0;
            $overallScore = 0;
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

    #[Route('/api/games/{id}', name: 'api_games_basic', methods: ['GET'])]
    public function getGameDetails(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $game = $entityManager->getRepository(Games::class)->find($id);
        $totalScore = 0;
        $reviewCount = 0;
        $overallScore = 0;
        if (!$game) {
            return new JsonResponse(['error' => 'Game not found'], JsonResponse::HTTP_NOT_FOUND);
        }
        #$image = $set->getImage();
        foreach ($game->getGameGenres() as $genre) 
            $genreNames[] = $genre->getGenreName();

        foreach ($game->getGamePlatforms() as $platform)
            $platformNames[] = $platform->getPlatformName();

        foreach ($game->getReviews() as $review){
            $totalScore += $review->getRatingGiven();
            $reviewCount++;
        }
        if($reviewCount!=0) $overallScore = $totalScore/$reviewCount;
        $releaseDateString = $game->getReleaseDate()->format('Y-m-d');
        $responseData = [
            'id' => $game->getId(),
            'name' => $game->getGameName(),
            'description' => $game->getDescription(),
            'date' => $releaseDateString,
            'score' => $overallScore,
            'platforms' => $platformNames,
            'genres' => $genreNames,
            'reviews' => []
        ];

        foreach ($game->getReviews() as $review) {
            $responseData['reviews'][] = [
                'id' => $review->getId(),
                'reviewer' => $review->getReviewer(),
                'rating' => $review->getRatingGiven(),
                'comment' => $review->getUserComment()
            ];
        }

        return new JsonResponse($responseData, JsonResponse::HTTP_OK);
    }

    #[Route('/api/games/platform/{id}', name: 'api_platform_games_basic', methods: ['GET'])]
    public function getGamesByPlatformId(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $platform = $entityManager->getRepository(Platforms::class)->find($id);
        
        if (!$platform) {
            return new JsonResponse(['message' => 'Platform not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $response = [
            'platform_name' => $platform->getPlatformName(),
            'gamelist' => []
        ];
    
        $games = $platform->getGames();
        $gamesData = [];
    
        foreach ($games as $game) {
            $genreNames = [];
            $platformNames = [];
            $totalScore = 0;
            $reviewCount = 0;
            $overallScore = 0;
    
            foreach ($game->getGameGenres() as $genre) {
                $genreNames[] = $genre->getGenreName();
            }
    
            foreach ($game->getGamePlatforms() as $gamePlatform) {
                $platformNames[] = $gamePlatform->getPlatformName();
            }
    
            foreach ($game->getReviews() as $review) {
                $totalScore += $review->getRatingGiven();
                $reviewCount++;
            }
    
            if ($reviewCount > 0) {
                $overallScore = $totalScore / $reviewCount;
            }
    
            $gamesData[] = [
                'id' => $game->getId(),
                'name' => $game->getGameName(),
                'score' => $overallScore,
                'platforms' => $platformNames,
                'genres' => $genreNames,
                'image' => $game->getGameCover()
            ];
        }
    
        $response['gamelist'] = $gamesData;
    
        return new JsonResponse($response);
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

    #[Route('/api/add_game', name: "api_add_game", methods: ['POST'])]
    public function add_game(Request $request): JsonResponse
    {
        $data = $request->request->all();

        $name = $data['name'];
        $date = new DateTime($data['date']);
        $description = $data['description'];
        $platforms = json_decode($data['platforms'], true);
        $genres = json_decode($data['genres'], true);

        $game = new Games();

        foreach($genres as $genre => $value){
            $game_genre = $this->entityManager->getRepository(Genres::class)->find($value);
            if($game_genre) $game->addGameGenre($game_genre);
        }
        foreach($platforms as $platform => $value){
            $game_platform = $this->entityManager->getRepository(Platforms::class)->find($value);
            if($game_platform) $game->addGamePlatform($game_platform);
        }
        #get the image
        $image = $request->files->get('image');
        if (!$image) $imageName = 'noimage.png';
        else {
            $imageName = md5(uniqid()).'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('img_path'), // Ensure 'img_path' is set in your parameters.yml or services.yaml
                $imageName
            );
        }
        $game->setGameCover($imageName);
        // $game_genres->set;
        $game->setGameName($name);
        $game->setReleaseDate($date);
        $game->setDescription($description);

        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Image uploaded successfully', 'gameID' => $game->getId()], JsonResponse::HTTP_CREATED);
    }

}
