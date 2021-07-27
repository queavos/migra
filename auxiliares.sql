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

 "sistema_Calificaciones" (
   inscripcion NUMERIC(8,0), //  enroll_id
   codigo_materia VARCHAR(10), // codigo_materia
   codigo_examen NUMERIC(8,0), // codigo_examen
   fecha TIMESTAMP WITHOUT TIME ZONE,
   calificacion NUMERIC(5,2), cakuf
   acta VARCHAR(15),
   fecha_alta TIMESTAMP WITHOUT TIME ZONE,
   usuario_alta VARCHAR(32),
   fecha_modif TIMESTAMP WITHOUT TIME ZONE,
   usuario_modif VARCHAR(32),
   calificacion_final NUMERIC(1,0),
   fecha_modif_web TIMESTAMP WITHOUT TIME ZONE,
   usuario_modif_web VARCHAR(32)
 )
 WITH (oids = false);

 "INSERT INTO public.eval_students
 (carsub_en_id, subeval_id, evstu_earned, evstu_final, evstu_aprov, evstu_enabled, evstu_paid)
 VALUES(".carsub_en_id.", ".subeval_id.", ".evstu_earned.", ".evstu_final.", ".evstu_aprov.", ".evstu_enabled.", ".evstu_paid.");";














-------------
"sistema_Cuotas" (
  Inscripcion NUMERIC(8,0),  // enroll_id
  id_movimiento NUMERIC(2,0), //
  tipo_movimiento VARCHAR(1), // oper_id
  fec_vence TIMESTAMP WITHOUT TIME ZONE, //
  fecha_pago TIMESTAMP WITHOUT TIME ZONE,
  recibo NUMERIC(10,0),
  importe NUMERIC(8,0),
  adicional NUMERIC(8,0),
  descuento NUMERIC(8,0),
  pagado NUMERIC(8,0),
  beca NUMERIC(8,0),
  cod_examen VARCHAR(10),
  estado VARCHAR(1),
  factura VARCHAR(15),
  fecha_alta TIMESTAMP WITHOUT TIME ZONE,
  usuario_alta VARCHAR(32),
  fecha_modif TIMESTAMP WITHOUT TIME ZONE,
  usuario_modif VARCHAR(32),
  mora NUMERIC(8,0),
  pagado_mora NUMERIC(8,0),
  fecha_pago_mora TIMESTAMP WITHOUT TIME ZONE,
  promo NUMERIC(10,0),
  descuento_automatico NUMERIC(10,0)
-------------
student_account (
   staccount_id         serial               not null,
   person_id            int4                 null,
   oper_id              int4                 null, //tipo_movimiento
   enroll_id            int4                 null, //Inscripcion
   staccount_quot_number int2                 not null, //id_movimiento
   staccount_quot_amount float8               not null, // importe
   staccount_description varchar(255)         not null, // ""
   staccount_start_period date                 not null, //
   staccount_end_period date                 not null,   //
   staccount_expiration date                 not null, // fec_vence
   staccount_status     bool                 not null, // if p = else =f
   staccount_amount_paid float8               null, //pagado
   staccount_type       varchar(50)          null,
-----------
"INSERT INTO student_account
(person_id, enroll_id,
  oper_id, staccount_quot_number,
  staccount_quot_amount, staccount_description,
  staccount_start_period, staccount_end_period,
  staccount_expiration, staccount_status,
  staccount_amount_paid, staccount_type,
  surcharge)
VALUES(".person_id.", ".enroll_id.",
  ".oper_id.", ".staccount_quot_number.",
  ".staccount_quot_amount.", ".staccount_description.",
  ".staccount_start_period.", ".staccount_end_period.",
  ".staccount_expiration.", ".staccount_status.",
  ".staccount_amount_paid.", ".staccount_type.",".surcharge.");";

--
INSERT INTO student_account (person_id, enroll_id,oper_id, staccount_quot_number,staccount_quot_amount, staccount_description,staccount_start_period, staccount_end_period,staccount_expiration, staccount_status,staccount_amount_paid, staccount_type,surcharge)
                          VALUES(4009, 7010,3, 0,0, 'Matricula 0','1000/01/01 00:00:00', '1000/01/01 00:00:00','2010-01-01 00:00:00', 0,0, 'Matricula',0);
