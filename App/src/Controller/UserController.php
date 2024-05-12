<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Users;
use App\Entity\UserProfile;
use App\Repository\UsersRepository;

class UserController extends AbstractController
{
    public function __construct(UsersRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    #[Route('/profile', methods: ['GET'])]
    public function index(SerializerInterface $serializer): Response
    {
        // Find the first user in the database
        $user = $this->userRepository->findOneBy([]);

        if (!$user) {
            // Handle the case when no user is found (optional)
            return $this->json(['message' => 'No user found']);
        }
        $jsonContent = $serializer->serialize($user, 'json');
        // Return the user as JSON response

        return new Response($jsonContent, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }
}
        //tak wrzucasz do bazy danych
        // $testProfile = new UserProfile();
        // $testProfile->setUsername('Nig');
        // $testProfile->setProfilePicture('ger.png');
        // $test = new Users();
        // $test->setEmail('email');
    // $test->setPassword('password');
        // $test->setUserProfile($testProfile);
        // $entityManager->persist($test);
        // $entityManager->flush();
        // private $userRepository;
        

        //tak ogarniasz wyciaganie z bazy danych do jsona
        // public function __construct(UsersRepository $userRepository)
        // {
        //     $this->userRepository = $userRepository;
        // }
        // 
        // #[Route('/profile', methods: ['GET'])]
        // public function index(SerializerInterface $serializer): Response
        // {
        //     // Find the first user in the database
        //     $user = $this->userRepository->findOneBy([]);
    
        //     if (!$user) {
        //         // Handle the case when no user is found (optional)
        //         return $this->json(['message' => 'No user found']);
        //     }
        //     $jsonContent = $serializer->serialize($user, 'json');
        //     // Return the user as JSON response

        //     return new Response($jsonContent, Response::HTTP_OK, [
        //         'Content-Type' => 'application/json'
        //     ]);
        // }