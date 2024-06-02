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
