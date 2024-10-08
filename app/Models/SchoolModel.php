<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolModel extends Model
{
    use HasFactory;
    protected $table = 'schools';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'school_name',
        'address',
        'board_array',
        'medium_array',
        'standard_array',
        'logo',
        'is_deleted' 
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'school_id', 'id');
    }
}
