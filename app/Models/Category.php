<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected static function booted()
    {
        static::creating(function ($category) {
            $slug = Str::slug("hwllo adl;fkj");
            $exist_cat = Category::where('slug', $slug)->first();
            if($exist_cat){
                $category->slug = $slug . rand(1, 100);
            } else {
                $category->slug = $slug;

            }
        });
    }

}
