<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardsModel extends Model
{
    use HasFactory;
    protected $table = 'board';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'name',
        'medium',
        'is_deleted' // Add other attributes as needed
    ];
}
