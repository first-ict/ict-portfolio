<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;
    Protected $guarded = [];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
