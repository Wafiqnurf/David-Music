<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'test_id', 'score', 'total_questions', 'correct_answers',
        'video_url', 'admin_review', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answers()
    {
        return $this->hasMany(UserTestAnswer::class);
    }

    public function isPassed()
    {
        return $this->score >= $this->test->passing_score;
    }
}
