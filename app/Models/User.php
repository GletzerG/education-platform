<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
<<<<<<< HEAD
use App\Models\Activity;



=======
use App\Models\ClassModel;
>>>>>>> af063c86745e52bad4de680d83007a922d6f50b7

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'name', 
    'email', 
    'password', 
    'phone', 
    'location', 
    'bio', 
    'avatar', 
    'skills'
    ];

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function isMentor()
    {
        return $this->role === 'mentor';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }

    public function isGuru()
    {
        return $this->role === 'guru';
    }
    public function canUploadVideo()
    {
        return $this->isMentor() && $this->is_verified;
    }
<<<<<<< HEAD

    public function getSkillsListAttribute()
    {
        return $this->skills ?? [];
    }

    public function activities()
{
    return $this->hasMany(Activity::class, 'user_id');
}
=======
    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'mentor_id');
    }
>>>>>>> af063c86745e52bad4de680d83007a922d6f50b7
}
