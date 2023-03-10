<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class ReviewRepository implements ReviewRepositoryInterface
{

    public function allReview()
    {
        return Comment::orderByDesc('created_at')->get();
    }

    public function storeReview($data)
    {
        return Comment::create($data);
    }

    public function findReview($id)
    {
        return Comment::find($id);
    }

    public function updateReview($data, $id)
    {
        $review = Comment::where('id', $id)->first();
        $review->user_id = $data['user_id'];
        $review->rating = $data['rating'];
        $review->review = $data['review'];
        $review->dateTime = $data['dateTime'];
        $review->save();
    }

    public function destroyReview($id)
    {
        $review = Comment::find($id);
        $review->delete();
    }
}
