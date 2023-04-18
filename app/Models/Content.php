<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    protected $guarded = [];

    use HasFactory, SoftDeletes;


    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }

}
