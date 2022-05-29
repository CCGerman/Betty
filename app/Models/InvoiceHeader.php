<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHeader extends Model
{
    use HasFactory;

    protected $fillable = ['client_full_name', 'client_document', 'invoice_id'];

    public function address(){
            return $this->morphOne(Address::class, 'addressable');
        }

        public function invoice(){
            return $this->hasOne(Invoice::class);
        }
}
