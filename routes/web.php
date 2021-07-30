<?php
ini_set('max_execution_time', -1);
ini_set('memory_limit', '6000M');
header('Content-type: text/plain; charset=utf-8');
use Illuminate\Support\Facades\Route;
use App\Models\sistemaAlumno;
use App\Models\Professor;
use App\Models\Institucion;
use App\Models\Facultad;
use App\Models\Carrera;
use App\Models\Curso;
use App\Models\Materia;
use App\Models\Inscripcion;
use App\Models\Cuotas;
use App\Models\Calificacion;
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
  //setlocale(LC_ALL, 'es_ES');
  $val=mb_convert_case($val, MB_CASE_TITLE, "UTF-8");
  if (is_null($val))
  {
    return "'--'";
  }
  else
  {
    //echo "entro---"."<br>";
   return   sanit_text($val);

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
      isnulltxt($item->nombre).",".
      isnulltxt($item->apellido).",".
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
      $sql='INSERT INTO contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (2,'.$cnt->alumno.",'teléfono',".isnulltxt($cnt->telefono).');';
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
      $sql='INSERT INTO contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (2,'.$cnt->alumno.",'Celular',".isnulltxt($cnt->celular).');';
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
      $sql='INSERT INTO contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (2,'.$cnt->alumno.",'Email',".isnulltxt($cnt->email).');';
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
      $sql='INSERT INTO contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (3,'.$cnt->alumno.','.isnulltxt($cnt->urg_llamar_a).",".isnulltxt($cnt->urg_telefono).');';
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
      $sql='INSERT INTO contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (4,'.$cnt->alumno.','.isnulltxt($cnt->trabajo).",".isnulltxt($cnt->telef_trabajo).');';
      echo  $sql."\n" ;
    }
  }
})->name('students_laboral');

Route::get('profes/lista', function () {

  //echo "<pre>";
  //echo date_format(Now(), 'Ymd-His');
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
      $sql=' INSERT INTO professors  (person_id,homecity_id,birthplace_id,country_idperson_fname,person_lastname,person_birthdate,person_gender,person_idnumber,person_address,person_bloodtype,person_photo,person_business_name,person_ruc,profe_year_start,profe_observation,profe_status,profe_oldid  ) VALUES ('."      $person_id,      0,      0,      0,"
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

        $sql=' INSERT INTO professors  ( person_id, homecity_id,birthplace_id,country_id,person_fname,person_lastname,person_birthdate,person_gender,person_idnumber,person_address,person_bloodtype,person_photo,person_business_name,person_ruc,profe_year_start,profe_observation,profe_status,profe_oldid) VALUES ( '
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
Route::get('institucion/lista', function () { // INSTITUCION/LISTA
  //echo "<ol type='I'>";
  $folder=date_format(Now(), 'Ymd-His');
  mkdir($folder, 0777, true);
  chdir ($folder);
  echo "carpeta creada ".$folder.PHP_EOL;
  //print_r($datos);
  $i=100;
  $facuid=100;
  $carreid=1000;
  $mate_id=0;
  $seme_id=1;
  $facucar_id=1000;
  $fcaradm_id=1000;
  $tariff_id=1000;
  $carsub_id=1000;
  $units=[];
  $faculties=[];
  $careers=[];
  $semesters=[];
  $subjects=[];
  $facu_careers=[];
  $facucar_adm=[];
  $tariffs=[];
  $carsubjects=[];
  $ins_old_id=0;
  $enrolleds=[];
  $carsub_enrolled=[];
  $subjet_evaluation=[];
  $student_account=[];
  $eval_students=[];
  $seval=1;
  $students=[];
  $contact_persons=[];
  $professors=[];
/// estudiantes
// leyendo profesores
echo "leyendo estudiantes".PHP_EOL;
$lista=App\Models\sistemaAlumno::all();
$result=[];
foreach ($lista as $item) {
  $sql="INSERT INTO students  ( person_id,  homecity_id,   birthplace_id,   country_id,   person_fname,   person_lastname,   person_birthdate,   person_gender,   person_idnumber,   person_address,   person_bloodtype,   person_photo,   person_business_name,   person_ruc,stu_status,   stu_gradyear,   stu_obs,   stu_allergies,   stu_instsupport,school_id,  hstitle_id,stu_status2,  stu_credential,   stu_creddate) VALUES (".
    $item->alumno.","."0,   0,   0, ".
    isnulltxt($item->nombre).",".
    isnulltxt($item->apellido).",".
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
    array_push($students,$sql);

    //echo $sql."\n";
    if ($item->telefono!="")
    {
      //  echo "<li>".$cnt->alumno." - ".$cnt->telefono."</li>";
      $sql='INSERT INTO contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (2,'.$item->alumno.",'teléfono',".isnulltxt($item->telefono).');';
      //echo  $sql."\n" ;
      array_push($contact_persons,$sql);
    }
      if ($item->celular!="")
      {
        $sql='INSERT INTO contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (2,'.$item->alumno.",'Celular',".isnulltxt($item->celular).');';
        array_push($contact_persons,$sql);
      }
      if (($item->urg_llamar_a!="") && ($item->urg_telefono!="")  )
      {
        $sql='INSERT INTO contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (3,'.$item->alumno.','.isnulltxt($item->urg_llamar_a).",".isnulltxt($item->urg_telefono).');';
        array_push($contact_persons,$sql);
      }

        if ($item->email!="")
        {
          $sql='INSERT INTO contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (2,'.$item->alumno.",'Email',".isnulltxt($item->email).');';
          array_push($contact_persons,$sql);
        }
        if (($item->trabajo!="") && ($item->telef_trabajo!="")  )
        {
          $sql='INSERT INTO contact_persons (  cnttype_id,  person_id,  cntper_description,  cntper_data ) VALUES (4,'.$item->alumno.','.isnulltxt($item->trabajo).",".isnulltxt($item->telef_trabajo).');';
          array_push($contact_persons,$sql);
        }
  }
  // leyendo profesores
  echo "fin alumno y contactos".PHP_EOL;
  echo "cantidad de alumnos  cantidad = ".count($students).PHP_EOL;
    echo "cantidad contactos = ".count($contact_persons).PHP_EOL;
///
// leyendo profesores
echo "leyendo profesores".PHP_EOL;
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
    $sql=' INSERT INTO professors  (person_id,homecity_id,birthplace_id,country_idperson_fname,person_lastname,person_birthdate,person_gender,person_idnumber,person_address,person_bloodtype,person_photo,person_business_name,person_ruc,profe_year_start,profe_observation,profe_status,profe_oldid  ) VALUES ('."      $person_id,      0,      0,      0,"
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
    } else {
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

      $sql=' INSERT INTO professors  ( person_id, homecity_id,birthplace_id,country_id,person_fname,person_lastname,person_birthdate,person_gender,person_idnumber,person_address,person_bloodtype,person_photo,person_business_name,person_ruc,profe_year_start,profe_observation,profe_status,profe_oldid) VALUES ( '
        .$profe_oldid.", 0,     0,      0, ".      isnulltxt($person_fname).", ".      isnulltxt($person_lastname).", ".      isnulldate($person_birthdate).", '".      $person_gender."',".   isnulltxt($person_idnumber).", ".      isnulltxt($person_address).", ".      isnulltxt($person_bloodtype).", ".      isnulltxt($person_photo).", ".      isnulltxt($person_business_name).",".      isnulltxt($person_ruc).",".      isnullnum($profe_year_start).",".      isnulltxt($profe_observation)." , ".        isnulltxt($profe_status)." , ".      $profe_oldid.');';
      }
    //  echo   $sql."\n";
      //$professors
      array_push($professors,$sql);
      //echo "</li>";
    }
    // leyendo profesores
    echo "fin lectura profesores".PHP_EOL;
    echo "profesores cantidad = ".count($professors).PHP_EOL;


  // bucle para agregar id auto numerico.
  foreach ($datos as $dato) {
    $i++;
    $dato->newid=$i;
  }
  echo "leyendo instituciones".PHP_EOL;
  $datos= App\Models\Institucion::all();
  $instituciones=$datos;

  foreach ($instituciones as $dato)
  { // comienza instituciones a units
    $sql_insti='INSERT INTO  units(  unit_id, unit_name,unit_code,unit_logo,unit_oldid)VALUES ('.$dato->newid.','.isnulltxt($dato->descripcion).','.isnulltxt($dato->cod_institucion).','.isnulltxt("blank.jpg").','.isnulltxt($dato->cod_institucion).');';
    array_push($units,$sql_insti);
    echo "leyendo facultades de ".isnulltxt($dato->descripcion).PHP_EOL;
    $facus=$dato->facultades;

    if ( count($facus)>0)
    {
      foreach ($facus as $facu)
      { // camienza facultades a faculties
        $facuid++;
        $facu->facu_id=$facuid;
        $facu->unit_id=$dato->newid;
        $sql_facu='INSERT INTO   faculties (facu_id,facu_name,facu_code,facu_unit_id,facu_logo) VALUES ('.$facu->facu_id.','.isnulltxt($facu->descripcion).','.isnulltxt($facu->abreviacion).','.$facu->unit_id.','.isnulltxt("blank.jpg").');';
        array_push($faculties,$sql_facu);
        $carres=$facu->carreras;
        if ( count($carres)>0)
        {
          echo "leyendo carreras de ".isnulltxt($facu->descripcion).PHP_EOL;
          foreach ($carres as $carre)
          { // comienza CARRERA a careers
            $carreid++;
            $carre->carre_id=$carreid;
            $carre->facu_id=$facu->facu_id;
            $carre_sql='INSERT INTO  careers(  career_id,  career_name,  career_code,  career_semsqity,  career_logo, career_pid) VALUES ('.$carre->carre_id.','.isnulltxt($carre->descripcion).','.isnulltxt($carre->cod_carrera).','.'9'.',  '.isnulltxt("blank.jpg").',0);';
            array_push($careers,$carre_sql);
            $cursos=$carre->cursos->sortBy('anio')->sortBy('cod_curso');
            $l_year=0;
            echo "leyendo cursos de ".isnulltxt($carre->descripcion).PHP_EOL;
            foreach ($cursos as $curso) { // comienza curso a carrera
              $intervalo=date_diff(date_create($curso->final),date_create($curso->inicio),true);
              if ($l_year!=$curso->anio)
              {
                $l_year=$curso->anio;
                $carre_chid=++$carreid;
                $facucar_id++;
                $fcaradm_id++;
                $tariff_id++;
                $carre_sql='INSERT INTO  careers(  career_id,  career_name,  career_code,  career_semsqity,  career_logo, career_pid) VALUES ('.$carre_chid.','.isnulltxt($carre->descripcion.' - '.$l_year).','.isnulltxt($carre->cod_carrera).','.'9'.',  '.isnulltxt("blank.jpg").', '.$carre->carre_id.');';
                array_push($careers,$carre_sql);
                $facucarre_sql='INSERT INTO   facu_careers(  facu_career_id,  fcar_name,  career_id,  faculty_id,  tcareer_id) VALUES ('.$facucar_id.', '.isnulltxt($carre->descripcion.' - '.$l_year).', '.$carre_chid.','.$facu->facu_id.', 0 );';
                array_push($facu_careers,$facucarre_sql);
                $fcaradm_sql="INSERT INTO facucar_adm (  fcaradm_id,  facu_career_id,  fcaradm_fee1sem,  fcaradm_fee2sem,  fcaradm_dueday,fcaradm_year) VALUES (".$fcaradm_id.", ".$facucar_id.", ".$curso->cantidad_cuotas.",  ".$curso->cantidad_cuotas.",".'10'.",".isnulltxt($l_year).");";
                array_push($facucar_adm,$fcaradm_sql);
                $tariff_sql="INSERT INTO   tariffs (  tariff_id,  fcaradm_id,  tariff_payamount,  tariff_caryear,  tariff_regamount,  tariff_obs)VALUES (  ".$tariff_id.",  ".$fcaradm_id.",  ".$curso->monto_cuota.",  ".isnulltxt($l_year).",  ".$curso->matricula.","."'exportado'".");";
                array_push($tariffs,$tariff_sql);

              }
              //echo "fin leyendo cursos de ".isnulltxt($carre->descripcion).PHP_EOL;
              $seme_sql='INSERT INTO semesters(sems_id, sems_name,  career_id,  sems_year) VALUES (  '.$seme_id++.','.isnulltxt($curso->descripcion) .','.$carre_chid.','.$l_year.');';
              array_push($semesters,$seme_sql);
              $curMats=$curso->materias;
              echo "leyendo materias de ".isnulltxt($curso->descripcion).PHP_EOL;
              foreach ($curMats as $matCur)
              { //comienza materias a subjects
                $matCur->mate_id=$mate_id++;
                $aux=0;
                if (($dato->cod_institucion)=='UNAE')
                {
                  $aux=substr($matCur->codigo_materia, -2);

                  if (is_int($aux))
                  {
                    $matCur->subj_carord=$aux;
                  }
                  else
                  { $matCur->subj_carord=0; }
                }
                $subjets_sql= "INSERT INTO   subjects(  subj_id,  subj_code,  subj_name,  subj_durationhs,  subj_weeklyhs,  sems_id,  subj_mattertype, subj_carord) VALUES ( ".$matCur->mate_id.", ".isnulltxt($matCur->codigo_materia).', '.isnulltxt($matCur->Descripcion).', '.$matCur->duracion_horas.', '.$matCur->duracion_horas.', '.$seme_id.", '0',".$matCur->subj_carord.");";
                array_push($subjects,$subjets_sql);
                $carsub_id++;
                $carsubs_sql="INSERT INTO careers_subjets (carsubj_id, facucar_id,materia_id, person_id,carsubj_year, carsubj_shift,carsubj_startdate, carsubj_enddate,carsubj_require, carsubj_evalprocess,carsubj_evalfinals, carsubj_code) VALUES (".$carsub_id.",".$facucar_id.",".isnullnum($matCur->mate_id).",".isnullnum($matCur->cod_profesor).",".isnullnum($l_year).",".isnulltxt('').",".isnulldate($matCur->fecha_inicio).", ".isnulldate($matCur->fecha_fin).", 70, 0, 0,".isnulltxt($matCur->codigo_materia).");";
                array_push($carsubjects,$carsubs_sql);
                // recupera inscriptos
                $inscriptos=$curso->inscripciones;
                // inserta inscriptos del curso
                echo "leyendo inscriptos de ".isnulltxt($curso->descripcion).PHP_EOL;
                foreach ($inscriptos as $inscript)
                {
                    if ($ins_old_id != $inscript->alumno)
                    {
                    $ins_old_id= $inscript->alumno;
                    $inscrip_sql  ="INSERT INTO enrolleds(  enroll_id,  person_id,  enrollt_date,  enroll_obs,  enroll_status ) VALUES ( ".isnullnum($inscript->inscripcion).", ".isnullnum($inscript->alumno).",".isnulldate($inscript->fecha_inscripcion).",".isnulltxt($inscript->observacion).",".isnulltxt($inscript->estado).");";
                      array_push($enrolleds,$inscrip_sql);
                    }
                    $subenrroll_sql="INSERT INTO   carsub_enrolled (enroll_id, carsubj_id, carsub_en_status  ) VALUES (".isnullnum($inscript->inscripcion).", ".$carsub_id.", ".isnulltxt($inscript->estado).");";
                    array_push($carsub_enrolled,$subenrroll_sql);
                    //echo $inscript->alumno.",".$inscript->inscripcion."\n";
                  //   $calificALL = Calificacion::where("inscripcion" , $inscript->inscripcion)->where("codigo_materia" ,$matCur->codigo_materia)->get();
                  // //  echo $inscript->inscripcion.PHP_EOL;
                  //   foreach ( $calificALL as $calif)
                  //   {
                  //     echo $calif->fecha." - ".$calif->carlificacion." - ".$calif->fecha." - ".PHP_EOL;
                  //   }

                    // recuperar cuotas
                  //  echo "leyendo cuotas de   ".isnulltxt($inscript->inscripcion).PHP_EOL;
                    $insCuotas=$inscript->cuotas;
                     foreach ($insCuotas as $cuota)
                       {

                         if ($cuota->tipo_movimiento=='C')
                          {
                            $operId=0;
                          } else { $operId=3; }
                          if ( $cuota->id_movimiento==0  ){ $cuoType="Matricula"; } else { $cuoType="Cuota "; }
                          if ($cuota->estado=='P')
                           {
                             $cuoStatus=1;
                           } else { $cuoStatus=0; }

                          $studentAcc_sql="INSERT INTO student_account (person_id, enroll_id,oper_id, staccount_quot_number,staccount_quot_amount, staccount_description,staccount_start_period, staccount_end_period,staccount_expiration, staccount_status,staccount_amount_paid, staccount_type,surcharge)
                          VALUES(".isnullnum($inscript->alumno).", ".isnullnum($inscript->inscripcion).",".$operId.", ".$cuota->id_movimiento.",".$cuota->importe.", ".isnulltxt($cuoType." ".$cuota->id_movimiento).",".isnulldate($matCur->fecha_inicio).", ".isnulldate($matCur->fecha_fin).",".isnulldate($cuota->fec_vence).", ".$cuoStatus.",".isnullnum($cuota->pagado).", ".isnulltxt($cuoType).",".isnullnum($cuota->pagado_mora).");";
                          array_push($student_account,$studentAcc_sql);
                          //echo $studentAcc_sql.PHP_EOL;
                       }
                  //     echo "fin leyendo cuotas de  ".isnulltxt($inscript->inscripcion).PHP_EOL;
                }
                echo "fin leyendo inscriptos de ".isnulltxt($curso->descripcion).PHP_EOL;
                //recuperar examenes
                echo "leyendo examenes de  ".isnulltxt($matCur->Descripcion).PHP_EOL;
                $exams=$matCur->examenes;
                foreach ($exams as $exam)
                {
                  $seval++;
                  if ( ($exam->clasificador >= 1) and ($exam->clasificador <= 3) ) { $examen=1; } else { $examen=0; }
                  if ( ($exam->clasificador >= 1) and ($exam->clasificador <= 9) ) {
                  $subEval_sql='INSERT INTO subject_evaluation (subeval_id,subeval_name, subeval_total,  subeval_date, subeval_exam, subeval_spprice, evaltype_id, carsubj_id, updated_at) VALUES('.$seval.','.isnulltxt($exam->Descripcion).', '.isnullnum($exam->total_puntos).', '.isnulldate($exam->fecha_examen).', '.$examen.', '.isnullnum($exam->Derecho_examen).', '.isnullnum($exam->clasificador).', '.$carsub_id.', '.isnulldate($exam->fecha_modif_web).');';
                  array_push($subjet_evaluation,$subEval_sql);
                  // reculeprar evaluaciones
              //    echo "leyendo calif de  ".isnulltxt($exam->Descripcion).PHP_EOL;
                   $calificALL = Calificacion::where("codigo_materia" ,$exam->codigo_materia)->get();
                   foreach ($calificALL as $calif)
                   {
                     $isAprov=0;
                     if ($calif->codigo_examen<4 ){
                       $isFinal=1;
                       if ($calif->calificacion>2) { $isAprov=1; }
                     } else { $isFinal=0;}
                     $calif_sql="INSERT INTO eval_students(carsub_en_id, subeval_id, evstu_earned, evstu_final, evstu_aprov, evstu_enabled, evstu_paid) VALUES (".$calif->inscripcion.", ".$seval.", ".$calif->calificacion.", ".$isFinal.", ".$isAprov.", 0 , 0 );";
                     array_push($eval_students,$calif_sql);
                   }
                //   echo "fin leyendo calif de  ".isnulltxt($exam->Descripcion).PHP_EOL;
                  }
                }
                echo "fin leyendo examenes de  ".isnulltxt($matCur->Descripcion).PHP_EOL;
              }  //TERMINA materias a subjects
              echo "fin leyendo materias de ".isnulltxt($curso->descripcion).PHP_EOL;
          } // TERMINA  curso a carrera
          if (count($semesters)>=1000){
          echo "leyendo cursos de ".isnulltxt($carre->descripcion).PHP_EOL;
          echo "se escribira 16-semestres".$carre->carre_id.".sql con " .count($semesters)." lineas".PHP_EOL;
          file_put_contents ('16-semestres'.$carre->carre_id.'.sql',implode(PHP_EOL,$semesters));
          echo "se escribio 16-semestres".$carre->carre_id.".sql".PHP_EOL;
          unset($semesters);
          $semesters=[];
          }
          if (count($subjects)>=1000){
          echo "se escribira 17-materias".$carre->carre_id.".sql con " .count($subjects)." lineas".PHP_EOL;
          file_put_contents ('17-materias'.$carre->carre_id.'.sql',implode(PHP_EOL,$subjects));
          echo "se escribio 17-materias".$carre->carre_id.".sql".PHP_EOL;
          unset($subjects);
          $subjects=[];
        }
        if (count($carsubjects)>=1000){
          echo "se escribira 18-carras_materias".$carre->carre_id.".sql con " .count($carsubjects)." lineas".PHP_EOL;
          file_put_contents ('18-carras_materias'.$carre->carre_id.'.sql',implode(PHP_EOL,$carsubjects));
          echo "se escribio 18-carras_materias".$carre->carre_id.".sql".PHP_EOL;
          unset($carsubjects);
          $carsubjects=[];
        }
        if (count($enrolleds)>=1000){
          echo "se escribira 19-inscripciones".$carre->carre_id.".sql con " .count($enrolleds)." lineas".PHP_EOL;
          file_put_contents ('19-inscripciones'.$carre->carre_id.'.sql',implode(PHP_EOL,$enrolleds));
          echo "se escribio 19-inscripciones".$carre->carre_id.".sql".PHP_EOL;
          unset($enrolleds);
          $enrolleds=[];
        }
        if (count($carsub_enrolled)>=1000){
          echo "se escribira 20-incrip_materia".$carre->carre_id.".sql con " .count($carsub_enrolled)." lineas".PHP_EOL;
          file_put_contents ('20-incrip_materia'.$carre->carre_id.'.sql',implode(PHP_EOL,$carsub_enrolled));
          echo "se escribio 20-incrip_materia".$carre->carre_id.".sql".PHP_EOL;
          unset($carsub_enrolled);
          $carsub_enrolled=[];
        }
        if (count($subjet_evaluation)>=1000){
          echo "se escribira 21-subjet_evaluation".$carre->carre_id.".sql con " .count($subjet_evaluation)." lineas".PHP_EOL;
          file_put_contents ('21-subjet_evaluation'.$carre->carre_id.'.sql',implode(PHP_EOL,$subjet_evaluation));
          echo "se escribio 21-subjet_evaluation".$carre->carre_id.".sql".PHP_EOL;
          unset($subjet_evaluation);
          $subjet_evaluation=[];
        }
        if (count($student_account)>=1000){
          echo "se escribira 22-student_account".$carre->carre_id.".sql con " .count($student_account)." lineas".PHP_EOL;
          file_put_contents ('22-student_account'.$carre->carre_id.'.sql',implode(PHP_EOL,$student_account));
          echo "se escribio 22-student_account".$carre->carre_id.".sql".PHP_EOL;
          unset($student_account);
          $student_account=[];
        }
        if (count($eval_students)>=1000){
          echo "se escribira 23-eval_students".$carre->carre_id.".sql con " .count($eval_students)." lineas".PHP_EOL;
          file_put_contents ('23-eval_students'.$carre->carre_id.'.sql',implode(PHP_EOL,$eval_students));
          echo "se escribio 23-eval_students".$carre->carre_id.".sql".PHP_EOL;
          unset($eval_students);
          $eval_students=[];
        }
        } // TERMINA CARRERA a careers
        /// agregar escritura de archivos.
        // echo "se escribira 13-facu_carreras".$carre->carre_id.".sql con " .count($facu_careers)." lineas".PHP_EOL;
        // file_put_contents ('13-facu_carreras'.$carre->carre_id.'.sql',implode(PHP_EOL,$facu_careers));
        // echo "se escribio 13-facu_carreras".$carre->carre_id.".sql".PHP_EOL;
        // unset($facu_careers);

        /// fin escritura de archivos.
      }
    }// camienza facultades a faculties
    // echo "fin leyendo facultades de ".isnulltxt($dato->descripcion).PHP_EOL;
    // echo "se escribira 14-carreras_adm".$carre->carre_id.".sql con " .count($facucar_adm)." lineas".PHP_EOL;
    // file_put_contents ('14-carreras_adm'.$carre->carre_id.'.sql',implode(PHP_EOL,$facucar_adm));
    // echo "se escribio 14-carreras_adm".$carre->carre_id.".sql".PHP_EOL;
    // unset($facucar_adm);
    // echo "se escribira 15-tarifas".$carre->carre_id.".sql con " .count($tariffs)." lineas".PHP_EOL;
    // file_put_contents ('15-tarifas'.$carre->carre_id.'.sql',implode(PHP_EOL,$tariffs));
    // echo "se escribio 15-tarifas".$carre->carre_id.".sql".PHP_EOL;
    // unset($tariffs);


  }
  echo "fin leyendo instituciones".PHP_EOL;
} // camienza inituciones  a  units
// $folder=date_format(Now(), 'Ymd-His');
// mkdir($folder, 0777, true);
// chdir ($folder);

echo "se escribira 07-professors.sql con " .count($professors)." lineas".PHP_EOL;
file_put_contents ('07-professors.sql',implode(PHP_EOL,$professors));
echo "se escribio 07-professors.sql".PHP_EOL;
unset($professors);
echo "se escribira 08-students.sql con " .count($students)." lineas".PHP_EOL;
file_put_contents ('08-students.sql',implode(PHP_EOL,$students));
echo "se escribio 08-students.sql".PHP_EOL;
unset($students);
echo "se escribira 09-contact_persons.sql con " .count($contact_persons)." lineas".PHP_EOL;
file_put_contents ('09-contact_persons.sql',implode(PHP_EOL,$contact_persons));
echo "se escribio 09-contact_persons.sql".PHP_EOL;
unset($contact_persons);
echo "se escribira 10-unidades.sql con " .count($units)." lineas".PHP_EOL;
file_put_contents ('10-unidades.sql',implode(PHP_EOL,$units));
echo "se escribio 10-unidades.sql".PHP_EOL;
unset($units);
echo "se escribira 11-facultades.sql con " .count($faculties)." lineas".PHP_EOL;
file_put_contents ('11-facultades.sql',implode(PHP_EOL,$faculties));
echo "se escribio 11-facultades.sql".PHP_EOL;
unset($faculties);
echo "se escribira 12-carreras.sql con " .count($careers)." lineas".PHP_EOL;
file_put_contents ('12-carreras.sql',implode(PHP_EOL,$careers));
echo "se escribio 12-carreras.sql".PHP_EOL;
unset($careers);

echo "se escribira 13-facu_carreras.sql con " .count($facu_careers)." lineas".PHP_EOL;
file_put_contents ('13-facu_carreras.sql',implode(PHP_EOL,$facu_careers));
echo "se escribio 13-facu_carreras.sql".PHP_EOL;
unset($facu_careers);
echo "se escribira 14-carreras_adm.sql con " .count($facucar_adm)." lineas".PHP_EOL;
file_put_contents ('14-carreras_adm.sql',implode(PHP_EOL,$facucar_adm));
echo "se escribio 14-carreras_adm.sql".PHP_EOL;
unset($facucar_adm);
echo "se escribira 15-tarifas.sql con " .count($tariffs)." lineas".PHP_EOL;
file_put_contents ('15-tarifas.sql',implode(PHP_EOL,$tariffs));
echo "se escribio 15-tarifas.sql".PHP_EOL;
unset($tariffs);
echo "se escribira 16-semestres.sql con " .count($semesters)." lineas".PHP_EOL;
file_put_contents ('16-semestres.sql',implode(PHP_EOL,$semesters));
echo "se escribio 16-semestres.sql".PHP_EOL;
unset($semesters);
echo "se escribira 17-materias.sql con " .count($subjects)." lineas".PHP_EOL;
file_put_contents ('17-materias.sql',implode(PHP_EOL,$subjects));
echo "se escribio 17-materias.sql".PHP_EOL;
unset($subjects);
echo "se escribira 18-carras_materias.sql con " .count($carsubjects)." lineas".PHP_EOL;
file_put_contents ('18-carras_materias.sql',implode(PHP_EOL,$carsubjects));
echo "se escribio 18-carras_materias.sql".PHP_EOL;
unset($carsubjects);
echo "se escribira 19-inscripciones.sql con " .count($enrolleds)." lineas".PHP_EOL;
file_put_contents ('19-inscripciones.sql',implode(PHP_EOL,$enrolleds));
echo "se escribio 19-inscripciones.sql".PHP_EOL;
unset($enrolleds);
echo "se escribira 20-incrip_materia.sql con " .count($carsub_enrolled)." lineas".PHP_EOL;
file_put_contents ('20-incrip_materia.sql',implode(PHP_EOL,$carsub_enrolled));
echo "se escribio 20-incrip_materia.sql".PHP_EOL;
unset($carsub_enrolled);
echo "se escribira 21-subjet_evaluation.sql con " .count($subjet_evaluation)." lineas".PHP_EOL;
file_put_contents ('21-subjet_evaluation.sql',implode(PHP_EOL,$subjet_evaluation));
echo "se escribio 21-subjet_evaluation.sql".PHP_EOL;
unset($subjet_evaluation);
echo "se escribira 22-student_account.sql con " .count($student_account)." lineas".PHP_EOL;
file_put_contents ('22-student_account.sql',implode(PHP_EOL,$student_account));
echo "se escribio 22-student_account.sql".PHP_EOL;
unset($student_account);
echo "se escribira 23-eval_students.sql con " .count($eval_students)." lineas".PHP_EOL;
file_put_contents ('23-eval_students.sql',implode(PHP_EOL,$eval_students));
echo "se escribio 23-eval_students.sql".PHP_EOL;
unset($eval_students);

echo "-- FIN --".PHP_EOL;

})->name('insti_lista'); // INSTITUCION/LISTA
