<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTemplate extends Model
{
    protected $table = 'product_template';
    // protected $table = 'product_template';
    /** @use HasFactory<\Database\Factories\ProductTemplateFactory> */
    use HasFactory;

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function template(){
        return $this->belongsTo(Template::class);
    }
}
