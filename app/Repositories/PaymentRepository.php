<?php

namespace App\Repositories;

use App\Interfaces\PaymentRepositoryInterface;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;

class PaymentRepository implements PaymentRepositoryInterface
{
    /**
     * Decode TransactionId.
     * @param $id
     * @return string
     */

    public function decryptTransactionId($id): string
    {
        try{
            return ($this->transCheck(decrypt($id)))?$id:false;
        }catch (\Exception $e){
            abort(404);
        }
    }

    /**
     * Store Payment.
     * @param $request
     * @param $id
     * @return object
     */
    public function store($request,$id):object{
        try {
            $transId = decrypt($id);
            $transaction = Transaction::with('payments')->find($transId);
            $dueAmount = ($transaction->amount_calculated-$transaction->payments->sum('amount'));
            if($dueAmount < $request->amount){
                return (object)[
                    'message'=>'No due amount Pending yet.'
                ];
            }
             Payment::create([
                'transaction_id'=>decrypt($id),
                'amount'=>$request->amount,
                'paid_on'=>$request->paid_on,
                'details'=>isset($request->details)? $request->details : "",
            ]);
            return (object)[
                'message'=>'success'
            ];
        }catch (\Exception $e){
            abort(500);
        }

    }


    /**
     * Check Trans.
     * @param $request
     * @return object
     */
    public function transCheck($id){
        try{
            return (Transaction::find($id)->exists());
        }catch (\Exception $e){
            abort(500);
        }
    }

}
