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
use App\Entity\User;
use App\Entity\Roles;
use App\Entity\UserProfile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use DateTime;


class ReviewController extends AbstractController
{
    private $entityManager;
    private $security;
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/api/review_game', name: 'app_review', methods: ['POST'])]
    public function addReview(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $reviewer = $this->security->getUser();
        $gameId = $data['game_id'];
        //find if the review on this game has already been done by this user, based on id game and id of the user.
        $comment = $data['review_comment'];
        $rating = (int)$data['rating_given'];
        // Fetch the game entity
        $game = $this->entityManager->getRepository(Games::class)->find($gameId);

        if (!$game) {
            return new JsonResponse(['error' => 'Game not found'], 404);
        }
        // Check if the review already exists
        $existingReview = $this->entityManager->getRepository(Reviews::class)->findOneBy([
            'Reviewer' => $reviewer,
            'ReviewedGame' => $game
        ]);
        if ($existingReview) {
            // Update the existing review
            $existingReview->setRatingGiven($rating);
            $existingReview->setUserComment($comment);
            $existingReview->setModifiedAt(new \DateTimeImmutable());

            $this->entityManager->persist($existingReview);
            $message = 'Review updated successfully';
        } else {
            // Create a new review
            $review = new Reviews();
            $review->setReviewer($reviewer);
            $review->setReviewedGame($game);
            $review->setRatingGiven($rating);
            $review->setUserComment($comment);
            $review->setModifiedAt(new \DateTimeImmutable());

            $this->entityManager->persist($review);
            $message = 'Review added successfully';
        }

        $this->entityManager->flush();
        return new JsonResponse(['status' => 'Review added succesfully'], JsonResponse::HTTP_CREATED);
    }
}
