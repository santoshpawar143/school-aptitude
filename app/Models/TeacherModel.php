<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherModel extends Model
{
    use HasFactory;
    protected $table = 'teacher';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'school_id',
        'teacher_no',
        'teacher_name',
        'board_id',
        'medium_id',
        'standard_id',
        'subject_id',
        'user_id',
        'del_status',
        'is_deleted' // Add other attributes as needed
    ];
}
