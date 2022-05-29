<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    use HasFactory;

    protected $fillable = ['billable_id', 'discount', 'quantity', 'invoice_id'];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function updateData(){
        $this->unity_amount = Billable::find($this->billable_id)->price;
        $unity_with_discount = $this->unity_amount * ( $this->discount / 100 );
        $this->total_amount = ($this->unity_amount - $unity_with_discount) * $this->quantity;
    }

}
