<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSerie extends Model
{
    use HasFactory;

    protected $fillable = ['serie', 'description'];

    protected $primaryKey = 'serie';

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function getNumber(){
        
        $lastInvoice = Invoice::where('serie', $this->serie)
            ->orderByDesc('number')->first();

        $lastNumber = ($lastInvoice) ? $lastInvoice->number +1 : 1 ;
        
        $this->last_number = $lastNumber;
        $this->save();

        return $lastNumber;
    }

}
