<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
  protected $table="sistema_Inscripciones";
  protected $primaryKey = 'inscripcion';
  function alumno()
    {
      return $this->belongsTo('App\Models\sistemaAlumno','alumno');
    }
    function curso()
      {
        return $this->belongsTo('App\Models\Curso','cod_curso');
      }
}
