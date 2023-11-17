<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    use HasFactory;

    protected $table="transactions";
    protected $fillable=['amount','payer','due_on','vat','is_vat_inclusive'];

    /**
     * Relation with Payment
     */
    public function payments(){
        return $this->hasMany(Payment::class,'transaction_id','id');
    }

    /**
     * Relation with User
     */
    public function user(){
        return $this->hasOne(User::class,'id','payer');
    }

    /**
     * Accessor Get Status Attribute
     */
    public function getStatusAttribute(): string
    {
        $currentDate = Carbon::now();
        $totalPaidAmount = $this->payments->sum('amount');
        $dueDate = Carbon::parse($this->due_on);
        if ($totalPaidAmount >= $this->amount) {
            return 'Paid';
        } elseif ($dueDate->lt($currentDate) && $totalPaidAmount > 0) {
            return 'Overdue';
        } elseif ($dueDate->lt($currentDate)) {
            return 'Overdue';
        } else {
            return 'Outstanding';
        }
    }

    /**
     * Accessor Get AmountCalculated Attribute
     */
    public function getAmountCalculatedAttribute():float
    {
        if ($this->is_vat_inclusive == 0) {
            return $this->amount+(($this->vat/100)*$this->amount);
        }
        return $this->amount;
    }

    /**
     * Accessor Get DueAmount Attribute
     */
    public function getDueAmountAttribute():float {
        $totalPaidAmount = $this->payments->sum('amount');
        return $this->amount_calculated - $totalPaidAmount;
    }

}
