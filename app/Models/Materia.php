<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
  protected $table="sistema_Materias";
  protected $primaryKey = 'codigo_materia';
  protected $keyType = 'string';
  public $mate_id=0;
  public $subj_carord=0;
  function profesor()
    {
      return $this->belongsTo('App\Models\Profesor','cod_profesor');
    }
    function curso()
      {
        return $this->belongsTo('App\Models\Curso','cod_curso');
      }
    function examenes()
      {
        return $this->hasMany('App\Models\Examen');
      }

}
