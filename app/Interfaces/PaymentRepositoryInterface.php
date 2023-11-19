<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface PaymentRepositoryInterface
{
    /**
     * Decode TransactionId.
     * @param $id
     * @return string
     */
    public function decryptTransactionId($id): string;

    /**
     * Store Payment.
     * @param $request
     * @param $id
     * @return object
     */
    public function store($request,$id):object;


    /**
     * List Payment.
     * @param $id
     * @return object
     */
    public function paymentList($id):object;
}
