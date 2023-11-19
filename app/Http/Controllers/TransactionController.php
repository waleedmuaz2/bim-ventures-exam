<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Interfaces\TransactionRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Brian2694\Toastr\Facades\Toastr;

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
        return view('transactions.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionStoreRequest $request)
    {
        $this->transactionRepository->store($request);
        return redirect()->to(route('transaction..create'))->with('success','Data added Successfully');
    }

    /**
     * Display a listing of the resource.
     */
    public function transactionList()
    {
        $transactions=$this->transactionRepository->transactionList();
        return view('home',compact('transactions'));
    }

}
