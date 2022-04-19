<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['time_start', 'time_end', 'client_id', 'treatment_id', 'worker_id'];

    public function worker(){
        return $this->belongsTo(Worker::class);
    }
    
    public function treatment(){
        return $this->belongsTo(Treatment::class);
    }

    public function getInfo(){
        $this->client = Client::find($this->client_id);
        $this->worker = Worker::find($this->worker_id);
        $this->treatment = Treatment::find($this->treatment_id);
        $this->treatment->getInfo();
    }

    /*
    protected $casts = [
        'time_start' => 'datetime:Y-m-d',
        'time_end' => 'datetime:Y-m-d'
    ];
    */
}
