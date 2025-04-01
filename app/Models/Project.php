<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
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
        });
    }


    public function corporate() {
        return $this->belongsTo(Corporate::class);
    }


    // This to find the user who created the project
    public function user()
        {
            return $this->hasOneThrough(
                User::class,  // Final model we want
                Corporate::class, // Intermediate model
                'id', // Foreign key in corporates (Corporate's Primary Key)
                'id', // Foreign key in users (User's Primary Key)
                'corporate_id', // Foreign key in projects (Refers to Corporate ID)
                'user_id' // Foreign key in corporates (Refers to User ID)
            );
        }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'corporate_users', 'corporate_id', 'user_id')
    //         ->withPivot('role')
    //         ->withTimestamps();
    // }

}
