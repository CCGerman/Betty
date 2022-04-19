<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['payment_method_id', 'amount', 'number', 'serie', 'client_id'];

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'number', 'number')->where('serie', $this->serie);
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function getInfo(){
        $this->invoice = $this->invoice;
        $this->payment_method = $this->paymentMethod;
        $this->client = $this->client;
    }

}
