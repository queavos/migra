<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
  protected $table="sistema_Cursos";
  protected $primaryKey = 'cod_curso';
  function materias()
    {
      return $this->hasMany('App\Models\Materia', 'cod_curso' );
    }
    function inscripciones()
      {
        return $this->hasMany('App\Models\Inscripcion', 'cod_curso' );
      }
      
}
