<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsModel extends Model
{
    use HasFactory;
    protected $table = 'student';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'school_id',
        'roll_no',
        'student_name',
        'board_id',
        'medium_id',
        'standard_id',
        'del_status',
        'user_id',
        'is_deleted' // Add other attributes as needed
    ];
}
