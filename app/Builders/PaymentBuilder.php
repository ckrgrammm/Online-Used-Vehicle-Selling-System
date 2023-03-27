<?php
namespace App\Builders;

use App\Models\Payment;


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
}
