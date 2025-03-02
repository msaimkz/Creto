<?php

namespace App\Models;
use App\Models\productimage;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function image(){
        return $this->hasMany(productimage::class);
    }
}
