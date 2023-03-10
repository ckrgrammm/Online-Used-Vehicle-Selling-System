<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Session;
use App\Models\Comment;


class ReviewControlller extends Controller
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if($request->post('rating_data')){
            $data = [
                'user_id' => '2',
                'rating' => $request->post('rating_data'),
                'review' => $request->post('review'),
                'dateTime' => time()
            ];
            $this->reviewRepository->storeReview($data);
	        echo "Your Review & Rating Successfully Submitted";
        }

        if($request->post('action'))
        {
            $average_rating = 0;
            $total_review = 0;
            $five_star_review = 0;
            $four_star_review = 0;
            $three_star_review = 0;
            $two_star_review = 0;
            $one_star_review = 0;
            $total_user_rating = 0;
            $review_content = array();

            $result = $this->reviewRepository->allReview();

            foreach($result as $row)
            {
                $review_content[] = array(
                    'user_id'		=>	$row["user_id"],
                    'user_review'	=>	$row["user_review"],
                    'rating'		=>	$row["user_rating"],
                    'datetime'		=>	date('l jS, F Y h:i:s A', $row["datetime"])
                );

                if($row["user_rating"] == '5')
                {
                    $five_star_review++;
                }

                if($row["user_rating"] == '4')
                {
                    $four_star_review++;
                }

                if($row["user_rating"] == '3')
                {
                    $three_star_review++;
                }

                if($row["user_rating"] == '2')
                {
                    $two_star_review++;
                }

                if($row["user_rating"] == '1')
                {
                    $one_star_review++;
                }

                $total_review++;

                $total_user_rating = $total_user_rating + $row["user_rating"];

            }

            $average_rating = $total_user_rating / $total_review;

            $output = array(
                'average_rating'	=>	number_format($average_rating, 1),
                'total_review'		=>	$total_review,
                'five_star_review'	=>	$five_star_review,
                'four_star_review'	=>	$four_star_review,
                'three_star_review'	=>	$three_star_review,
                'two_star_review'	=>	$two_star_review,
                'one_star_review'	=>	$one_star_review,
                'review_data'		=>	$review_content
            );

            echo json_encode($output);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
