<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    use HasFactory;
    protected $table = 'subject';
    protected $fillable = [
        'subject_name',
        'board_array',
        'medium_array',
        'standard_array',
        'school_id',
        'is_deleted'
    ];
    public function generateTests()
    {
        return $this->hasMany(GenerateTestModel::class, 'subject');
    }
}
