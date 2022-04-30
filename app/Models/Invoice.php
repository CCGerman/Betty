<?php

namespace App\Models;

use App\Models\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, HasCompositePrimaryKey;

    protected $fillable = ['serie', 'number', 'client_id', 'address_id', 'date'];

    protected $primaryKey = ['serie', 'number'];
    public $incrementing = false;

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function serie(){
        return $this->belongsTo(InvoiceSerie::class);
    }

    public function address(){
        return $this->morphOne(Address::class, 'addressable');
    }

    public function invoiceLines(){
        return $this->hasMany(InvoiceLine::class, 'number', 'number')->where('serie', $this->serie);
    }

    public function payments(){
        return $this->hasMany(Payment::class, 'number', 'number')->where('serie', $this->serie);
    }

    public function getBalance(){
        $total = 0;
        $paid = 0;
        $lines = $this->invoiceLines;
        foreach($lines as $line){
            $total += $line->total_amount;
        }
        $payments = $this->payments;
        foreach($payments as $payment){
            $paid += $payment->amount;
        }
        return $total - $paid;
    }

    public function getData(){

        foreach($this->invoiceLines as &$line){
            unset($line->invoice_number);
            unset($line->serie);
        }

        foreach($this->payments as &$payment){
            unset($payment->number);
            unset($payment->serie); 
        }
    }
}


