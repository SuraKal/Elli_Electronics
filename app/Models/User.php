<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    
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

        });
    }


    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
                ->orWhereHas('roles', function ($roleQuery) use ($searchTerm) {
                    $roleQuery->where('name', 'like', "%{$searchTerm}%"); // Check role names
                })
                ->orWhere('status', 'like', "%{$searchTerm}%");
        });
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function role()
    {
        return $this->roles()->first()->name;
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function hasAnyRole(array $roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    public function corporate() {
        return $this->hasMany(Corporate::class);
    }

    // public function corporates()
    // {
    //     return $this->belongsToMany(Corporate::class, 'corporate_user')->withTimestamps();
    // }

    public function projects()
    {
        return $this->hasManyThrough(
            Project::class,   // Final model (Projects)
            Corporate::class, // Intermediate model (Corporates)
            'user_id',        // Foreign key in corporates (links corporates to users)
            'corporate_id',   // Foreign key in projects (links projects to corporates)
            'id',             // Local key in users (User's primary key)
            'id'              // Local key in corporates (Corporate's primary key)
        );
    }


    public function shipping(){
        return $this->hasOne(Shipping::class);
    }

}
