<?php

use Illuminate\Support\Facades\Route;
use App\Models\sistemaAlumno;
use App\Models\Professor;
use App\Models\Institucion;
use App\Models\Facultad;
use App\Models\Carrera;
use App\Models\Curso;
use App\Models\Materia;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* funciones extra*/






/*      */
function isnulltxt($val)
{
  if (is_null($val))
  {
    return "'--'";
  }
    else
    {
      return sanit_text($val);
    }
}
function isnullnum($val)
{
  if (is_null($val))
  {
    return -1900;
  }
    else
    {
      $val=str_replace(".", "", $val);
      $val=str_replace(",", "", $val);
      $val=str_replace(" ", "", $val);
      $val=str_replace("DNI", "", $val);
      $val=str_replace("=", "", $val);
      $val=str_replace(":", "", $val);
      return $val;
    }
}
function isnulldate($val)
{
  if (is_null($val))
  {
    return "'1000/01/01 00:00:00'";
  }
    else
    {
      return "'".$val."'";
    }
}
function sanit_text($val)
    {
      $val=str_ireplace ("'"," ",$val);
      $val=str_ireplace ('"'," ",$val);
      return "'".$val."'";
    }
Route::get('/', function () {
    return view('welcome');
});
Route::get('students/lista', function () {
    echo "<pre>";
    $lista=App\Models\sistemaAlumno::all();
    //$sql="SELECT alumno as person_id, apellido as person_lastname, nombre as person_fname, fecha_nac as person_birthday,
    //observacion as stu_status, sexo as person_gender, direccion as person_address,grupo_sangre as person_bloodtype,
    //alergias as stu_allergies,	estado_civil as person_civstate, observacion as stu_obs, cedula as person_idnumber,
    // anio_egreso as stu_gradyear, institucion_apoyo as stu_instsupport,  credencial as stu_credential,
    //credencial_fecha as stu_creddate    FROM public.sistema_alumno";
    //$lista=DB::select($sql);
    $result=[];
    foreach ($lista as $item) {
      //print_r($item);
      // code...
      $sql="INSERT INTO students  ( person_id,  homecity_id,   birthplace_id,   country_id,   person_fname,   person_lastname,   person_birthdate,   person_gender,   person_idnumber,   person_address,   person_bloodtype,   person_photo,   person_business_name,   person_ruc,stu_status,   stu_gradyear,   stu_obs,   stu_allergies,   stu_instsupport,school_id,  hstitle_id,stu_status2,  stu_credential,   stu_creddate) VALUES (".
      $item->alumno.","."0,   0,   0, ".
    sanit_text($item->nombre).",".
    sanit_text($item->apellido).",".
    isnulldate($item->fecha_nac).",".
    isnulltxt($item->sexo).",".
    isnulltxt($item->cedula).",".
    isnulltxt($item->direccion).",".
    isnulltxt($item->grupo_sangre).",".
    "'-','-','-',".
    isnulltxt($item->observacion).",".
    isnullnum($item->anio_egreso).",".
    isnulltxt($item->observacion).",".
    isnulltxt($item->alergias).",".
    isnulltxt($item->institucion_apoyo).",".
    "0,0,'-',".
    isnullnum($item->stu_credential).",".
    isnulldate($item->stu_creddate).");";
    echo $sql."\n";
    //array_push($result,$sql);
    }
    //print_r($result);
/*    foreach ($$result as $item) {
      echo $item."\n";

    }*/
})->name('students_list');
Route::get('students/telefonos', function () {
    echo "<pre>";
    //$contactos= DB::table('sistema_Alumno')->select('alumno', 'telefono')->where('telefono','<>', '');
    $contactos= App\Models\sistemaAlumno::all();
    foreach ($contactos as $cnt) {
      if ($cnt->telefono!="")
      {
    //  echo "<li>".$cnt->alumno." - ".$cnt->telefono."</li>";
        $sql='INSERT INTO public.contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (2,'.$cnt->alumno.",'teléfono',".isnulltxt($cnt->telefono).');';
      echo  $sql."\n" ;
      }
    }

})->name('students_telef');
Route::get('students/celular', function () {
  echo "<pre>";
  $contactos= App\Models\sistemaAlumno::all();
  foreach ($contactos as $cnt) {
  if ($cnt->celular!="")
  {
    $sql='INSERT INTO public.contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (2,'.$cnt->alumno.",'Celular',".isnulltxt($cnt->celular).');';
  echo  $sql."\n" ;
  }
}




})->name('students_celu');
Route::get('students/email', function () {
echo "<pre>";
$contactos= App\Models\sistemaAlumno::all();
foreach ($contactos as $cnt) {
if ($cnt->email!="")
{
$sql='INSERT INTO public.contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (2,'.$cnt->alumno.",'Email',".isnulltxt($cnt->email).');';
echo  $sql."\n" ;
}
}
})->name('students_email');

Route::get('students/urgencias', function () {
echo "<pre>";
$contactos= App\Models\sistemaAlumno::all();
foreach ($contactos as $cnt) {
if (($cnt->urg_llamar_a!="") && ($cnt->urg_telefono!="")  )
{
$sql='INSERT INTO public.contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (3,'.$cnt->alumno.','.isnulltxt($cnt->urg_llamar_a).",".isnulltxt($cnt->urg_telefono).');';
echo  $sql."\n" ;
}

}
})->name('students_urgencia');
Route::get('students/laboral', function () {
echo "<pre>";
$contactos= App\Models\sistemaAlumno::all();
foreach ($contactos as $cnt) {
if (($cnt->trabajo!="") && ($cnt->telef_trabajo!="")  )
{
  $sql='INSERT INTO public.contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (4,'.$cnt->alumno.','.isnulltxt($cnt->trabajo).",".isnulltxt($cnt->telef_trabajo).');';
echo  $sql."\n" ;
}
}
})->name('students_laboral');

Route::get('profes/lista', function () {
//echo "<pre>";
$datos= App\Models\Professor::all();
foreach ($datos as $dato) {
    $import=sistemaAlumno::where('cedula',"=",isnullnum($dato->ci))->first();
    if (($import)) {
    //print_r($import);
    $person_id=$import->alumno;
    $person_fname=$import->nombre;
    $person_lastname=$import->apellido;
    $person_birthdate=$import->fecha_nac;
    $person_gender=$import->sexo;
    $person_idnumber=$import->cedula;
    $person_address=$import->direccion;
    $person_bloodtype=$import->grupo_sangre;
    $person_photo="-";
    $person_business_name=$import->apellido.", ".$import->nombre."'";
    $person_ruc=$import->cedula;
    $profe_year_start=$dato->anio_ejercicio;
    $profe_observation=$dato->email.", \n".$dato->celular;
    $profe_status="";
    $profe_oldid=$dato->cod_profesor;
    //echo "<li>";
    //print_r($import);
    $sql=' INSERT INTO public.professors  (
      person_id,
      homecity_id,
      birthplace_id,
      country_id,
      person_fname,
      person_lastname,
      person_birthdate,
      person_gender,
      person_idnumber,
      person_address,
      person_bloodtype,
      person_photo,
      person_business_name,
      person_ruc,
      profe_year_start,
      profe_observation,
      profe_status,
      profe_oldid
    ) VALUES ('."      $person_id,      0,      0,      0,"
      .      isnulltxt($person_fname).","
      .      isnulltxt($person_lastname).","
      .      isnulldate($person_birthdate).","
      .      isnulltxt($person_gender).", "
      .      isnulltxt($person_idnumber).","
      .      isnulltxt($person_address).","
      .    isnulltxt($person_bloodtype).","
      .isnulltxt($person_photo).","
      .      isnulltxt($person_business_name).","
      .      isnulltxt($person_ruc).","
      .      isnullnum($profe_year_start).","
      .      isnulltxt($profe_observation).","
      .      isnulltxt($profe_status).","
      .      $profe_oldid.');';
    //echo $import->first()->alumno;
    //echo "<li>";

    } else {
    //$person_id=$import->alumno;
    $l_name=strtok($dato->nombre, ',');
    $f_name=strtok(',');
    $person_lastname=$l_name;
    $person_fname=$f_name;
    $person_birthdate=$dato->fecha_nac;
    $person_gender='';
    $person_idnumber=$dato->ci;
    $person_address="-";
    $person_bloodtype="-";
    $person_photo="-";
    $person_business_name=$l_name.", ".$f_name;
    $person_ruc=$dato->ci;
    $profe_year_start=$dato->anio_ejercicio;
    $profe_observation=$dato->email.", \n".$dato->celular;
    $profe_status="";
    $profe_oldid=0;

    $sql=' INSERT INTO public.professors  ( person_id, homecity_id,birthplace_id,country_id,person_fname,person_lastname,person_birthdate,person_gender,person_idnumber,person_address,person_bloodtype,person_photo,person_business_name,person_ruc,profe_year_start,profe_observation,profe_status,profe_oldid) VALUES ( '
      .$profe_oldid.", 0,     0,      0, ".      isnulltxt($person_fname).", ".      isnulltxt($person_lastname).", ".      isnulldate($person_birthdate).", '".      $person_gender."',".   isnulltxt($person_idnumber).", ".      isnulltxt($person_address).", ".      isnulltxt($person_bloodtype).", ".      isnulltxt($person_photo).", ".      isnulltxt($person_business_name).",".      isnulltxt($person_ruc).",".      isnullnum($profe_year_start).",".      isnulltxt($profe_observation)." , ".        isnulltxt($profe_status)." , ".      $profe_oldid.');';
    }
    echo   $sql."\n";
    //echo "</li>";
}

//echo "</ol>";
/*



//print_r($dato);
foreach ($contactos as $cnt) {
if (($cnt->trabajo!="") && ($cnt->telef_trabajo!="")  )
{
echo  $sql='INSERT INTO public.contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (4,'.$cnt->alumno.','.isnulltxt($cnt->trabajo).",".isnulltxt($cnt->telef_trabajo).");\n";
}
}
*/
})->name('profes_lista');

/*  */
Route::get('institucion/lista', function () {
echo "<ol type='I'>";
$datos= App\Models\Institucion::all();
//print_r($datos);
$i=100;
$facuid=100;
$carreid=1000;
$mate_id=0;
$seme_id=1;
// bucle para agregar id auto numerico.
foreach ($datos as $dato) {
    $i++;
    $dato->newid=$i;
}
$instituciones=$datos;
foreach ($instituciones as $dato) {
    //echo $dato->newid." - ".$dato->cod_institucion." - ".$dato->descripcion."<br>";
  //  echo "<h1>--".$dato->descripcion."</h1>";
    echo "<p>";
//    echo $sql_insti='INSERT INTO  public.units(  unit_id, unit_name,unit_code,unit_logo,unit_oldid)VALUES ('.$dato->newid.','.isnulltxt($dato->descripcion).','.isnulltxt($dato->cod_institucion).','.isnulltxt("blank.jpg").','.isnulltxt($dato->cod_institucion).');';
    echo "</p>";
  //  echo $sql_insti."<br>";
    $facus=$dato->facultades;

    if ( count($facus)>0)
    {
    foreach ($facus as $facu) {
      $facuid++;
      $facu->facu_id=$facuid;
      $facu->unit_id=$dato->newid;
  //    echo "<h2>--".$facu->descripcion."</h2>";
      echo "<p>";
    // echo $sql_facu='INSERT INTO   public.faculties (facu_id,facu_name,facu_code,facu_unit_id,facu_logo) VALUES ('.$facu->facu_id.','.isnulltxt($facu->descripcion).','.isnulltxt($facu->abreviacion).','.$facu->unit_id.','.isnulltxt("blank.jpg").');';
      echo "</p>";
    //  echo $sql_facu."<br>";
      $carres=$facu->carreras;
      if ( count($carres)>0)
      {
      foreach ($carres as $carre) {
      $carreid++;
      $carre->carre_id=$carreid;
      $carre->facu_id=$facu->facu_id;
      //$carre_sql='INSERT INTO  public.careers(  career_id,  career_name,  career_code,  career_semsqity,  career_logo) VALUES ('.$carre->carre_id.','.isnulltxt($carre->descripcion).','.isnulltxt($carre->cod_carrera).','.'9'.',  '.isnulltxt("blank.jpg").');';
    //  echo $carre_sql."<br>";
       $cursos=$carre->cursos->sortBy('anio')->sortBy('cod_curso');
       //print_r ($cursos);
//       echo "<h3>--".$carre->descripcion."</h3>";
       //echo "<ul>";
       $l_year=0;
       foreach ($cursos as $curso) {
         $intervalo=date_diff(date_create($curso->final),date_create($curso->inicio),true);
         if ($l_year!=$curso->anio)
         {
         $l_year=$curso->anio;
//         echo "<h4>--".$carre->descripcion." - ".$l_year."</h4>";
    //     echo $carre_sql='INSERT INTO  public.careers(  career_id,  career_name,  career_code,  career_semsqity,  career_logo) VALUES ('.$carre->carre_id.','.isnulltxt($carre->descripcion.' - '.$l_year).','.isnulltxt($carre->cod_carrera).','.'9'.',  '.isnulltxt("blank.jpg").');';
         }
//         echo "<h5>--";
      //   echo $curso->descripcion." - ". $intervalo->days."\n";
  //       echo "</h5>";
         echo "<p>";
      //   echo 'INSERT INTO semesters(sems_id, sems_name,  career_id,  sems_year) VALUES (  '.$seme_id++.','.isnulltxt($curso->descripcion) .','.$carre->carre_id.','.$l_year.');';
    //     echo "</p>";
         $curMats=$curso->materias;
/* materias por cursos primera vuelta.*/
         foreach ($curMats as $matCur) {
           $matCur->mate_id=$mate_id++;
           $aux=0;
         //   echo "<br />-entro-unit-<br />";
         // echo $dato->cod_institucion;
         // echo "<br />";
           if (($dato->cod_institucion)=='UNAE')
                {
              //    echo "<br />-entro-<br />";
             $aux=substr($matCur->codigo_materia, -2);
            //    echo "<br />";
                if (is_int($aux))
                {
                  $matCur->subj_carord=$aux;
                }
                else
                { $matCur->subj_carord=0; }
                }
  //         echo "<h6>--".$matCur->codigo_materia." - ".$matCur->Descripcion." - ".$matCur->duracion_horas."</h6>";
           echo "<p>";
      //     echo 'INSERT INTO   public.subjects(  subj_id,  subj_code,  subj_name,  subj_durationhs,  subj_weeklyhs,  sems_id,  subj_mattertype, subj_carord) VALUES ( '.$matCur->mate_id.', '.isnulltxt($matCur->codigo_materia).', '.isnulltxt($matCur->Descripcion).', '.$matCur->duracion_horas.', '.$matCur->duracion_horas.', '.$seme_id.", '0',".$matCur->subj_carord.");";
           //echo $matCur->codigo_materia." - ".$matCur->Descripcion." - ".$matCur->duracion_horas;
           echo "</p>";
         }

/*  */
/* segunda vuelta de materias.
          echo "<ol>";
          foreach ($curMats as $matCur) {
            //$matCur->$mate_id++;
            echo "<li>";
            echo $matCur->mate_id." - ".$matCur->Descripcion." - ".$matCur->duracion_horas;
            echo "</li>";
          }
           echo "</ol>";
  */
         echo "</p>";
       }
       //echo "</ul>";
      }
    }
    }
}
}



/*
  echo "<li>";
  echo $dato->cod_institucion." - ".$dato->descripcion;
  $facus=$dato->facultades;
  if ( count($facus)>0)
  {
  echo "<ol type='A'>";
  foreach ($facus as $facu) {
    echo "<li>";
    echo $facu->abreviacion." - ".$facu->descripcion;
    $carres=$facu->carreras;
    if ( count($carres)>0)
    {
    echo "<ol type='1'>";
    foreach ($carres as $carre) {
    echo "<li>";
    echo $carre->cod_carrera." - ".$carre->descripcion;
    $cursos=$carre->cursos;
    if ( count($cursos)>0)
    {
    echo "<ol type='a'>";
    foreach ($cursos as $curso) {
    echo "<li>";
    echo $curso->anio." - ".$curso->descripcion;

    echo "</li>";
    }
    echo "</ol>";
    }
    echo "</li>";

    }
    echo "</ol>";
    }
    echo "</li>";
  }
  echo "</ol>";
  }

  echo "</li>";

}*/

echo "</ol>";
})->name('insti_lista');
