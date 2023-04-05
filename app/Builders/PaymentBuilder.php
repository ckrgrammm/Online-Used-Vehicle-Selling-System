<?php
namespace App\Builders;
use App\Builders\Interfaces\PaymentBuilderInterface;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PaymentBuilder implements PaymentBuilderInterface
{
    private $queryBuilder;

    public function __construct(PaymentQueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function create($data)
    {
        return Payment::create($data);
    }

    public function readAll()
    {
        return $this->queryBuilder->get();
    }

    public function readById($id)
    {
        return $this->queryBuilder->findOrFail($id);
    }

    public function update($id, $data)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($data);
        return $payment;
    }

    public function delete($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->deleted = 1;
        $payment->update();
    }

    public function weeklySales($weeksAgo = 0)
    {
        $startDate = Carbon::now()->subWeeks($weeksAgo)->startOfWeek();
        $endDate = Carbon::now()->subWeeks($weeksAgo)->endOfWeek();
    
        $weeklySalesTotal = DB::table('payments')
        ->join('orders', 'payments.order_id', '=', 'orders.id')
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->where('payments.deleted', 0)
        ->where('products.deleted', 1)
        ->where('orders.status', 'Paid')
        ->whereBetween('payments.created_at', [$startDate, $endDate])
        ->selectRaw('SUM(payments.total_charge - products.price) as weekly_sales_total')
        ->first()
        ->weekly_sales_total;
    
        return $weeklySalesTotal;
    }

    public function weeklySalesPercentageChange()
    {
        // Get the current week's SalesTotal
        $currentSalesTotal = $this->weeklySales();

        // Get the previous week's SalesTotal
        $previousSalesTotal = $this->weeklySales(1);

        // Calculate the percentage change in review count
        $percentageChange = 0;
        if ($previousSalesTotal > 0) {
            $percentageChange = (($currentSalesTotal - $previousSalesTotal) / $previousSalesTotal) * 100;
        }

        return round($percentageChange, 2);
    }
}
