/*
carsubj_id  <<--  $carsub_id
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
*/
"INSERT INTO public.careers_subjets(carsubj_id, facucar_id,materia_id, person_id,carsubj_year, carsubj_shift,carsubj_startdate, carsubj_enddate,carsubj_require, carsubj_evalprocess,carsubj_evalfinals, carsubj_code) VALUES (".$carsub_id.",".$facucar_id.",".isnullnum($matCur->materia_id).",".isnullnum($matCur->cod_profesor).",".isnullnum($l_year).",".isnulltxt('').",".   isnulldate($matCur->fecha_inicio).", ".isnulldate($matCur->fecha_fin).",    0, 0,".isnullnum($matCur->codigo_materia).");";
