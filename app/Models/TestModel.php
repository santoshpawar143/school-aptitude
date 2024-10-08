<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use HasFactory;
    protected $table = 'test';
    protected $fillable = [
        'school_id',
        'subject',
        'medium',
        'standard',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_ans',
        'del_status',
        'is_deleted'
    ];
}
