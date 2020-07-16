<?php

namespace App\Http\Controllers;

use App\Repositories\MiscRepository;
use App\Repositories\ReviewsRepository;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function __construct(ReviewsRepository $reviewsRepository)
    {
        $this->reviewsRepository = $reviewsRepository;
    }

    public function reviews()
    {
        return $this->reviewsRepository->getReviews();
    }

    public function add_review($tekst, $author, $stars)
    {
        $this->reviewsRepository->insert_review($tekst, $author, $stars);
        return $this->reviewsRepository->getReview($author);
    }



}
