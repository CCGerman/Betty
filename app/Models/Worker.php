<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'last_name_1', 'last_name_2', 'phone', 'note'];

    public function address(){
        return $this->morphOne(Address::class, 'addressable');
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }

}
