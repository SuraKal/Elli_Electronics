<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory,SoftDeletes;
    protected static function boot()
    {
        parent::boot();

        // Automatically generate UUID when creating a new user
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
            if (empty($model->created_date)) {
                $model->created_date = Carbon::parse($date ?? now())->format('jS F Y');
            }
            
            if (empty($model->code)) {
                $model->code = Str::upper(Str::random(8));
            }

            // 'code' => $this->faker->unique()->word()
        });
    }
}
