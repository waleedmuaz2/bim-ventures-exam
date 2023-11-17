<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionStoreRequest;
use App\Interfaces\TransactionRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

class TransactionController extends Controller
{
    private $userRepository;
    private $transactionRepository;

    public function __construct(UserRepositoryInterface $userRepository,TransactionRepositoryInterface $transactionRepository)
    {
        $this->userRepository = $userRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = $this->userRepository->usersList();
        return jsonFormat($users,"success",200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionStoreRequest $request)
    {
        $this->transactionRepository->store($request);
        return jsonFormat('',"success",200);
    }

    /**
     * Display a listing of the resource.
     */
    public function transactionList()
    {
        $transactions=$this->transactionRepository->transactionList();
        return jsonFormat($transactions,"success",200);
    }

}
