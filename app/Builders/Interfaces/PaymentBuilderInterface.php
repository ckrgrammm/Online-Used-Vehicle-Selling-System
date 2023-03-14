<?php

namespace App\Builders;

interface PaymentRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(int $id): Payment;

    public function create(array $data): Payment;

    public function update(int $id, array $data): Payment;

    public function delete(int $id): void;

    public function whereAmountGreaterThan(float $amount): PaymentRepositoryInterface;

    public function whereStatus(string $status): PaymentRepositoryInterface;

    public function orderByDate(string $direction = 'desc'): PaymentRepositoryInterface;
}
