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
carsubj_evalfinals, carsubj_code)
VALUES (
1003,1001,
-1900,39,
2010,'',
'1000/01/01 00:00:00', '1000/01/01 00:00:00',
0, 0,248-3);

-------------------------------------
Inscripcion
-------------------------------------
enroll_id <-- inscripcion
person_id <-- alumno
enroll_date <-- fecha_inscripcion
enroll_obs <-- observacion
enroll_status <-- estado

------------------------------------
inscripcion a materia
------------------------------------
carsub_en_id  <-- serial
enroll_id     <-- inscripcion
carsubj_id  <---
carsub_en_status <--
