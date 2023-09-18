<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employee';
    protected $fillable = [
        'id',
        'user_id',
        'ip_adress' ,
        'checked_in_at' ,
        'checked_out_at',
        'created_at' ,
        'updated_at'
    ];
}
