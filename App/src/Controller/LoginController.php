<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Users;
use App\Entity\Roles;
use App\Entity\UserProfile;

class LoginController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/login', name: 'app_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $responseData = [];
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $password = $data['password'];

        $user = $this->entityManager->getRepository(Users::class)->findOneBy(array('email' => $email));

        if($user){
            $responseData = [
                'message' => 'The account doesnt exist'
            ];
        }
        if($user->getPassword() != $password){
            $responseData = [
                'message' => 'Incorrect password'
            ];
        }else{
            $responseData = [
                'message' => 'Successfully logged in',
                'userId' => $user->getId()
            ];
        }
        return new JsonResponse($responseData, JsonResponse::HTTP_CREATED);

    }

    #[Route('/api/register', name: 'app_register_post', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $password = $data['password'];
        $username = $data['username'];

        
        $userProfile = new UserProfile();
        $userProfile->setUsername($username);
        $userProfile->setProfilePicture('profile.png');

        $user = new Users();
        $user->setEmail($email);
        $user->setPassword($password);
        $user->addUserRole($this->entityManager->getRepository(Roles::class)->find(1));
        $user->setUserProfile($userProfile);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $responseData = [
            'message' => 'User registered successfully',
            'userId' => $user->getId()
        ];

        return new JsonResponse($responseData, JsonResponse::HTTP_CREATED);
    }

}
