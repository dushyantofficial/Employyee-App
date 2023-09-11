<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public $table ="employees";

    protected $fillable = [
      'employee_code',
      'first_name',
      'last_name',
      'joining_date',
      'profile_image'
    ];
}
