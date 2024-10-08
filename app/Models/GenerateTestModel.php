<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateTestModel extends Model
{
    use HasFactory;
    protected $table = 'generate_test';
    protected $fillable = [
        'school_id',
        'test_name',
        'questions',
        'test_code',
        'status',
        'subject',
        'medium',
        'standard',
        'is_deleted'
    ];
    public function standard()
    {
        return $this->belongsTo(StandardModel::class, 'standard');
    }

    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'subject');
    }

    public function medium()
    {
        return $this->belongsTo(MediumModel::class, 'medium');
    }
}
