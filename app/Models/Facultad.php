<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
  protected $table="sistema_Facultades";
  protected $primaryKey = 'cod_factultad';
  protected $keyType = 'string';
  public $unit_id=0;
  public $facu_id=0;
  function carreras()
    {
      return $this->hasMany('App\Models\Carrera','cod_factultad');
    }
}
