<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediumModel extends Model
{
    use HasFactory;
    protected $table = 'medium';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'name',
        'is_deleted' // Add other attributes as needed
    ];
    public function generateTests()
    {
        return $this->hasMany(GenerateTestModel::class, 'medium');
    }
}
