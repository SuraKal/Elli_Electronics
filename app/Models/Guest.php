<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guest extends Model
{
    /** @use HasFactory<\Database\Factories\GuestFactory> */
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

            if (empty($model->identifier)) {
                $getIdentifier = rand(100000000, 999999999); // Convert from hex to decimal
                $model->identifier = 'User_' . $getIdentifier;
            }
        });

        
    }

    public function shipping(){
        return $this->hasOne(Shipping::class);
    }

}
