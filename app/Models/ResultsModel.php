<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultsModel extends Model
{
    use HasFactory;
    protected $table = 'result';
    protected $fillable = [
        'school_id',
        'chapter_id',
        'student_id',
        'subject_id',
        'total_marks',
        'marks_obtained',
        'result',
        'selected_ans',
        'is_deleted'
    ];
}
