<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * Store User.
     * @param $data
     * @return object
     */

    public function store($data): object
    {
        try {
            return Transaction::create([
                'amount' => $data['amount'],
                'payer' => $data['payer'],
                'due_on' => $data['due_on'],
                'vat' => $data['vat'],
                'is_vat_inclusive' => ($data['is_vat_inclusive'] == 'yes') ? 1 : "0",
            ]);
        } catch (\Exception $e) {
            abort(500);
        }

    }

    /**
     * Get Transaction.
     * @return array
     */
    public function transactionList(): array
    {
        try {
            $user = auth()->user();
            $trans = Transaction::with('user');
            if (in_array('customer', $user->getRoleNames()->toArray())) {
                $trans = $trans->where('payer', $user->id);
            }
            $trans = $trans->get();
            $data = [];
            $i = 1;
            foreach ($trans as $tran) {
                $data[] = [
                    'id' => encrypt($tran->id),
                    'sr_no' => $i++,
                    'amount' => (double)$tran->amount_calculated,
                    'due_amount' => (double)$tran->due_amount,
                    'payer' => $tran->user->email,
                    'due_on' => $tran->due_on,
                    'vat' => $tran->vat,
                    'is_vat_inclusive' => ($tran->is_vat_inclusive == 1) ? "Yes" : "No",
                    'status' => $tran->status,
                ];
            }
            return $data;
        } catch (\Exception $e) {
            abort(500);
        }
    }


}
