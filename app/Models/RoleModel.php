<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;
    protected $table = 'role';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'role_name',
        'is_deleted' // Add other attributes as needed
    ];
    
    public function users()
    {
        return $this->hasMany(User::class, 'role', 'id');
    }
}
