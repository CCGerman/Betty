<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'last_name_1', 'last_name_2', 'phone', 'note', 'active', 'email'];

    public function address(){
        return $this->morphOne(Address::class, 'addressable');
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

}
