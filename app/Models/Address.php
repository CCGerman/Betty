<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['address_1', 'address_2', 'city', 'postalcode', 'country'];

    protected $hidden = ['addressable_id', 'addressable_type'];

    public function addressable(){
        return $this->morphTo();
    }
}
