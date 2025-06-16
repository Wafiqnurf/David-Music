<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'icon', 'image', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_courses')
            ->withPivot('enrolled_at', 'status')
            ->withTimestamps();
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function enrollments()
    {
        return $this->hasMany(UserCourse::class);
    }
}
