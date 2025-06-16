<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTestAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_test_result_id', 'test_question_id', 'answer', 'is_correct',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }

    public function result()
    {
        return $this->belongsTo(UserTestResult::class, 'user_test_result_id');
    }

    public function question()
    {
        return $this->belongsTo(TestQuestion::class, 'test_question_id');
    }
}
