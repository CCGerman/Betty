<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billable extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'active'];

    public function billable(){
        return $this->morphTo();
    }
}
