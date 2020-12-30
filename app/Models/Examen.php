<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
  protected $table="sistema_Examenes";
  protected $primaryKey = 'codigo_examen';
  function materia()
    {
      return $this->belongsTo('App\Models\Materia','codigo_materia');
    }
}
