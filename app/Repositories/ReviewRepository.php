<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class ReviewRepository implements ReviewRepositoryInterface
{

    public function allReview()
    {
        return Comment::where('comments.deleted', 0)
                    ->join('users', 'comments.user_id', '=', 'users.id')
                    ->select('comments.*', 'users.name as user_name', 'users.email as user_email', 'users.image as user_image')
                    ->orderByDesc('comments.created_at')
                    ->get();
    }

    public function storeReview($data)
    {
        return Comment::create($data);
    }

    public function findReview($id)
    {
        return Comment::join('users', 'users.id', '=', 'comments.user_id')
                    ->select('comments.*', 'users.name as user_name', 'users.email as user_email')
                    ->where('comments.id', $id)
                    ->first();
    }

    public function updateReview($data, $id)
    {
        $review = Comment::where('id', $id)->first();
        $review->comment = $data['comment'];
        $review->save();
    }

    public function updateLikes($data, $id)
    {
        $review = Comment::where('id', $id)->first();
        $review->likes = $data;
        $review->save();
    }

    public function destroyReview($id)
    {
        $review = Comment::find($id);
        $review->deleted = 1;
        $review->save();
    }
}
