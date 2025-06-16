<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'full_name', 'nickname', 'phone',
        'gender', 'birth_place', 'birth_date', 'address', 'profile_photo', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'birth_date'        => 'date',
        ];
    }

    // Existing many-to-many relationship
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'user_courses')
            ->withPivot('enrolled_at', 'status')
            ->withTimestamps();
    }

    // New relationship untuk akses data enrollment dengan mudah
    public function userCourses()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function testResults()
    {
        return $this->hasMany(UserTestResult::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
}
