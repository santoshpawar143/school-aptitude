<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsModel extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $fillable = [
        'school_id',
        'teacher_id',
        'chapter_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_ans',
        'is_deleted'
    ];
}
