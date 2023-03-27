<?php

namespace App\Builders;

interface PaymentQueryBuilderInterface
{
    public function whereAmountGreaterThan($amount);
    
    public function whereStatus($status);
    
    public function orderByDate($direction = 'desc');
    
    public function get();
    
    public function first();
    
    public function findOrFail($id);
}
