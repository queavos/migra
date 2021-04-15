INSERT INTO   public.tariffs (  tariff_id,  fcaradm_id,  tariff_payamount,  tariff_caryear,  tariff_regamount,  tariff_obs)VALUES (  ?tariff_id,  ?fcaradm_id,  ?tariff_payamount,  ?tariff_caryear,  ?tariff_regamount,  ?tariff_obs);


carsubj_id  <<--  serial
facucar_id  <<--  $facucar_id
materia_id  <<-- $matCur->materia_id
person_id  <<--  $matCur->cod_profesor
carsubj_year <<-- $l_year
carsubj_shift <<-- ""
carsubj_startdate <<-- $matCur->fecha_inicio
carsubj_enddate <<--    $matCur->fecha_fin
carsubj_require  <<-- 70
carsubj_evalprocess <<-- 0
carsubj_evalfinals <<-- 0
carsubj_code <<-- $matCur->codigo_materia

INSERT INTO public.careers_subjets(
  carsubj_id, facucar_id,
  materia_id, person_id,
  carsubj_year, carsubj_shift,
  carsubj_startdate, carsubj_enddate,
  carsubj_require, carsubj_evalprocess,
  carsubj_evalfinals, carsubj_code
) VALUES (
  10866,1483,
  9865,33,
  2018,'',
  '1000/01/01 00:00:00', '1000/01/01 00:00:00',
  0, 0,'MFOR15');

-------------------------------------
Inscripcion
-------------------------------------
enroll_id <-- inscripcion
person_id <-- alumno
enroll_date <-- fecha_inscripcion
enroll_obs <-- observacion
enroll_status <-- estado
INSERT INTO   enrolleds(  enroll_id,  person_id,  enrollt_date,  enroll_obs,  enroll_status ) VALUES (  ?enroll_id,  ?person_id,  ?enrollt_date,  ?enroll_obs, ?enroll_status);



------------------------------------
inscripcion a materia
------------------------------------
carsub_en_id  <-- serial
enroll_id     <-- inscripcion
carsubj_id  <---
carsub_en_status <-- "true"
INSERT INTO   carsub_enrolled (enroll_id, carsubj_id, carsub_en_status  )  VALUES (
  enroll_id,
  carsubj_id,
  carsub_en_status
 );

 --------------
Anotaciones
 ---------------
 "sistema_Examenes" (
   codigo_examen NUMERIC(8,0), ->> nros sin sentido
   codigo_materia VARCHAR(10), ->> codigo_materia
   "Descripcion" VARCHAR(60), ->> descripcion
   "Derecho_examen" NUMERIC(10,0), ->> costo derecho de examen
   clasificador VARCHAR(2), -> tipo de evaluacion
   fecha_examen TIMESTAMP WITHOUT TIME ZONE,
   total_puntos NUMERIC(3,0), ->total de puntos
   usuario_modif_web VARCHAR(32),
   fecha_modif_web TIMESTAMP WITHOUT TIME ZONE
 )
