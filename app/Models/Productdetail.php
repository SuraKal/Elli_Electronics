<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productdetail extends Model
{
    /** @use HasFactory<\Database\Factories\ProductdetailFactory> */
    use HasFactory;


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
