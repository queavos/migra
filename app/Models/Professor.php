<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
  protected $table="sistema_profesores";
  protected $primaryKey = 'cod_profesor';
}
