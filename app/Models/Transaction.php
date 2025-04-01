<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
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

            if (empty($model->tx_ref)) {
                $model->tx_ref = 'TX-'. Str::upper(Str::random(16));
            }

        });
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function($q) use ($searchTerm) {
            $q->where('tx_ref', 'like', "%{$searchTerm}%")
                ->orWhereHas('order', function($userQuery) use ($searchTerm) {
                    $userQuery->where('code', 'like', "%{$searchTerm}%");
                })
                ->orWhere('status', 'like', "%{$searchTerm}%")
                ->orWhere('method', 'like', "%{$searchTerm}%");
        });
    }


    // If transactions are made using banks and they manually upload there file. 
    public function bank(){
        return $this->hasOne(Bank::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }


}
