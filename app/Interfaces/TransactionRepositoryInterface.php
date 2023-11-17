<?php

namespace App\Interfaces;


interface TransactionRepositoryInterface
{
    /**
     * Store User.
     * @param $data
     * @return object
     */
    public function store($data): object;

    /**
     * Get Transaction.
     * @return array
     */
    public function transactionList(): array;
}
