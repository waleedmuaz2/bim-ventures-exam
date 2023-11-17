<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentStoreRequest;
use App\Interfaces\PaymentRepositoryInterface;

class PaymentController extends Controller
{

    private $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $transactionId = $this->paymentRepository->decryptTransactionId($id);
        return jsonFormat($transactionId,"success",200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentStoreRequest $request,$id)
    {
        $message = $this->paymentRepository->store($request,$id);
        return jsonFormat($message,$message->message,200);
    }

}
