<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\VisitorRepositoryInterface;
use App\Builders\PaymentBuilder;
use App\Builders\PaymentQueryBuilder;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    private $reviewRepository;
    protected $paymentBuilder;
    private $visitorRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository, PaymentBuilder $paymentBuilder, VisitorRepositoryInterface $visitorRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->paymentBuilder = $paymentBuilder;
        $this->visitorRepository = $visitorRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //weekly review
        $weeklyReviewCount = $this->reviewRepository->weeklyReview();
        $weeklyReviewPercentageChange = $this->reviewRepository->weeklyReviewPercentageChange();
        if ($weeklyReviewPercentageChange > 0) {
            // increased
            $weeklyReviewPercentageChange = "Increased by {$weeklyReviewPercentageChange}%";
        } elseif ($weeklyReviewPercentageChange < 0) {
            // decreased
            $weeklyReviewPercentageChange = "Decreased by " . abs($weeklyReviewPercentageChange) . "%";
        } else {
            // stayed the same
            $weeklyReviewPercentageChange = "No changes";
        }

        //weekly sales
        $weeklySalesTotal = $this->paymentBuilder->weeklySales();
        $weeklySalesPercentageChange = $this->paymentBuilder->weeklySalesPercentageChange();
        if ($weeklySalesPercentageChange > 0) {
            // increased
            $weeklySalesPercentageChange = "Increased by {$weeklySalesPercentageChange}%";
        } elseif ($weeklySalesPercentageChange < 0) {
            // decreased
            $weeklySalesPercentageChange = "Decreased by " . abs($weeklySalesPercentageChange) . "%";
        } else {
            // stayed the same
            $weeklySalesPercentageChange = "No changes";
        }

        //weekly visitor
        $weeklyVisitorCount = $this->visitorRepository->weeklyVisitor();
        $weeklyVisitorPercentageChange = $this->visitorRepository->weeklyVisitorPercentageChange();

        if ($weeklyVisitorPercentageChange > 0) {
            // increased
            $weeklyVisitorPercentageChange = "Increased by {$weeklyVisitorPercentageChange}%";
        } elseif ($weeklyVisitorPercentageChange < 0) {
            // decreased
            $weeklyVisitorPercentageChange = "Decreased by " . abs($weeklyVisitorPercentageChange) . "%";
        } else {
            // stayed the same
            $weeklyVisitorPercentageChange = "No changes";
        }

        return view('admin/admin-index', compact('weeklyReviewCount', 'weeklyReviewPercentageChange', 'weeklySalesTotal', 'weeklySalesPercentageChange', 'weeklyVisitorCount', 'weeklyVisitorPercentageChange'));
        
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
