<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['stock'];

    public function bill(){
        return $this->morphOne(Billable::class, 'billable');
    }

    public function image(){
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getInfo(){
        
        $billable = $this->bill;
        $this->name = $billable->name;
        $this->price = $billable->price;
        $this->description = $billable->description;
        unset($this->bill);

        $this->image = $this->image;
    }
}
