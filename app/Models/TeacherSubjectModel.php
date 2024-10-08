<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubjectModel extends Model
{
    use HasFactory;
    protected $table = 'teacher_subject';
    protected $fillable = [
        'teacher_id',
        'school_id',
        'board_array',
        'medium_array',
        'standard_array',
        'subject_array',
        'is_deleted' // Add other attributes as needed
    ];
}
