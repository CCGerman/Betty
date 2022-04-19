<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'description'];

    public function imageable(){
        return $this->morphTo();
    }

    public function image(){
        return $this->morphMany(Image::class, 'imageable');
    }
}
