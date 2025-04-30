<?php

namespace App\Models;

use App\Services\ProductService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory,SoftDeletes;


    protected static function boot()
    {
        parent::boot();

        // When ever a user is created
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }

            if (empty($model->created_date)) {
                $model->created_date = Carbon::parse($date ?? now())->format('jS F Y');
            }

            // Generate Slug
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
                ->orWhereHas('categories', function ($userQuery) use ($searchTerm) {
                    $userQuery->where('name', 'like', "%{$searchTerm}%");
                })
                ->orWhere('status', 'like', "%{$searchTerm}%");
        });
    }



    public function detail(){
        return $this->hasOne(ProductDetail::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    // 
    public function category(): Category|null
    {
        return $this->categories()?->first();
    }

    public function related_products()
    {
        return $this->category()?->products()
            ->where('status', true)        // Add status filter
            ->get();
    }

    


    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
    public function images(){
        return $this->hasMany(Image::class);
    }

    // $product->template->first()->structure
    public function template(){
        return $this->belongsToMany(Template::class,'product_template');
    }



    public function hasTemplate(): bool
    {
        return $this->template()->exists();
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    
    public function getTemplateStructure()
    {
        return optional($this->template->first())->structure ?? [];
    }



    public function getActiveStructure(ProductService $productService, Product $product)
    {
        // Retrieve the structure (assuming $this->templateStructure holds the JSON-like structure)
        $structure = $productService->getTemplateStructure($product);

        // Filter out only active elements
        $filteredStructure = array_map(function ($items) {
            return array_filter($items, function ($status) {
                return $status === 'active'; // Keep only active items
            });
        }, $structure);

        return $filteredStructure;
    }





}
