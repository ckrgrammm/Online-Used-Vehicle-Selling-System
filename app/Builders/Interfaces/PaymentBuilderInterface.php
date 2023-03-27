<?php

namespace App\Builders;

interface PaymentBuilderInterface
{
    public function create($data);
    
    public function readAll();
    
    public function readById($id);
    
    public function update($id, $data);
    
    public function delete($id);
}
