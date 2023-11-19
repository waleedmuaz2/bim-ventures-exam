<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Interfaces\PaymentRepositoryInterface;
use Illuminate\Http\Request;

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
        $paymentLists = $this->paymentRepository->paymentList($id);
        return view('payments.create',compact('transactionId','paymentLists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentStoreRequest $request,$id)
    {
        $message = $this->paymentRepository->store($request,$id);
        if($message->message != "success"){
            return redirect()->back()->with('error',"No enough due amount Pending yet.");
        }
        return redirect()->back()->with('success','Data added Successfully');
    }

}
