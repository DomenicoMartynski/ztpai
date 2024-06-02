<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Roles;
use App\Entity\UserProfile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class SecurityController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request, JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $password = $data['password'];
    
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);
    
        // Check if the user exists and validate the password
        if (!$user || !password_verify($password, $user->getPassword())) {
            return $this->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $jwtManager->create($user);
        $response = new JsonResponse([
            'message' => 'Successfully logged in',
            'token' => $token,
        ], JsonResponse::HTTP_CREATED);

        return $response;

    }

    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $password = $data['password'];
        $username = $data['username'];

        $userRepository = $this->entityManager->getRepository(User::class);
        $checker = $userRepository->findOneBy(['email' => $email]);
        if($checker){
            return $this->json([
                'message' => "The email has already been registered.",
            ], Response::HTTP_UNAUTHORIZED);
        }
        $userProfile = new UserProfile();
        $userProfile->setUsername($username);
        $userProfile->setProfilePicture('profile.png');
        $user = new User();
        $user->setEmail($email);

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setRoles(array('ROLE_USER'));
        $user->setPassword($hashedPassword);
        $user->setUserProfile($userProfile);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $responseData = [
            'message' => 'User registered successfully',
            'userId' => $user->getId()
        ];

        return new JsonResponse($responseData, JsonResponse::HTTP_CREATED);
    }

    #[Route('api/me', name: 'api_me', methods: ['GET'])]
    public function getCurrentUser(): JsonResponse
    {
        $user = $this->security->getUser();

        if (!$user) {
            return $this->json([
                'message' => 'User not found',
            ], Response::HTTP_NOT_FOUND);
        }

        $isAdmin = \in_array('ROLE_ADMIN', $user->getRoles(), true);

        $responseData = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'adminPrivileges' => $isAdmin,
        ];

        return new JsonResponse($responseData, JsonResponse::HTTP_OK);
    }

}
