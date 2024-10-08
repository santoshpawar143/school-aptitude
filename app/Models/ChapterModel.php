<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterModel extends Model
{
    use HasFactory;
    protected $table = 'chapters';
    protected $fillable = [
        'school_id',
        'teacher_id',
        'chapter_name',
        'questions_array',
        'subject_id',
        'medium_id',
        'standard_id',
        'board_id',
        'is_deleted'
    ];
}
