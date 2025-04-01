<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Corporate extends Model
{
    /** @use HasFactory<\Database\Factories\CorporateFactory> */
    use HasFactory,SoftDeletes;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

        protected static function boot()
    {
        parent::boot();

        // Automatically generate UUID when creating a new user
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'corporate_users')->withTimestamps();
    // }
    public function projects(){
        return $this->hasMany(Project::class);
    }
}
