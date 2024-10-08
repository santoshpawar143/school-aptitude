<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardModel extends Model
{
    use HasFactory;
    protected $table = 'standards';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'name',
        'is_deleted' // Add other attributes as needed
    ];
    // Define the relationship with GenerateTestModel
    public function generateTests()
    {
        return $this->hasMany(GenerateTestModel::class, 'standard');
    }
}
