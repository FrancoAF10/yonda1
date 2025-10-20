-- versión 3
-- Procedimiento para registrar la asistencia diaria, validar si el trabajador tiene contrato vigente, si labora el dia actual
use recursoshumanos;
DROP PROCEDURE IF EXISTS spu_test1;
DELIMITER //
CREATE PROCEDURE spu_test1()
BEGIN
    DECLARE _fechaFinContrato DATE;
    DECLARE _idcontrato INT;
    DECLARE _diaSemana VARCHAR(10);
    DECLARE _idhorario INT;
    DECLARE _marcacionAsistencia INT;

    DECLARE _horaIniRef TIME;
    DECLARE _horaFinRef TIME;

    -- Configuración idioma en español
    SET lc_time_names = 'es_ES'; 

    -- 1. Último contrato vigente de la persona
    SELECT idcontrato, fechafin 
    INTO _idcontrato, _fechaFinContrato
    FROM contratos 
    WHERE idpersona = 4
    ORDER BY idcontrato DESC 
    LIMIT 1;

    -- 2. Validamos si el contrato está vigente
    IF (_fechaFinContrato >= CURDATE() OR _fechaFinContrato IS NULL) THEN
        
        -- 3. Obtener día actual y horario
        SET _diaSemana = DATE_FORMAT(CURDATE(), '%W'); 

        SELECT idhorario, iniciorefrigerio, finrefrigerio
        INTO _idhorario, _horaIniRef, _horaFinRef
        FROM horarios
        WHERE idcontrato = _idcontrato
          AND dia = _diaSemana
        LIMIT 1;

        -- 4. Validar si tiene horario
        IF _idhorario IS NULL THEN
            SELECT 'Ud. no tiene asistencia el día de hoy';
        ELSE
            -- 5. Verificar si ya tiene  asistencia hoy
            SELECT COUNT(*)
            INTO _marcacionAsistencia
            FROM asistencias
            WHERE idhorario = _idhorario
              AND diamarcado = CURDATE();

            -- 6. Primera marcación: ENTRADA
            IF _marcacionAsistencia = 0 THEN
                INSERT INTO asistencias(diamarcado, entrada, idhorario)
                VALUES (CURDATE(), CURTIME(), _idhorario);
                SELECT 'Se registró la entrada';

            ELSE
                -- 7. en caso de que en el horario no haya refrigerio
                IF _horaIniRef IS NULL AND _horaFinRef IS NULL THEN
                   
                   IF (SELECT salida FROM asistencias WHERE idhorario = _idhorario 
                        AND diamarcado = CURDATE()) IS NULL THEN
                       
                       UPDATE asistencias
                       SET salida = CURTIME()
                       WHERE idhorario = _idhorario 
                         AND diamarcado = CURDATE();
                       
                       SELECT 'Se registró la salida';
                   ELSE
                       SELECT 'Ya completó todas las marcaciones de hoy';
                   END IF;

                ELSE
                -- 8. En caso de que en el horario haya refrigerio
                   IF (SELECT iniciorefrigerio FROM asistencias WHERE idhorario = _idhorario 
                         AND diamarcado = CURDATE()) IS NULL THEN
                       
                       UPDATE asistencias
                       SET iniciorefrigerio = CURTIME()
                       WHERE idhorario = _idhorario 
                         AND diamarcado = CURDATE();
                       
                       SELECT 'Se registró inicio refrigerio';

                   ELSEIF (SELECT finrefrigerio FROM asistencias WHERE idhorario = _idhorario 
                             AND diamarcado = CURDATE()) IS NULL THEN
                       
                       UPDATE asistencias
                       SET finrefrigerio = CURTIME()
                       WHERE idhorario = _idhorario 
                         AND diamarcado = CURDATE();
                       
                       SELECT 'Se registró fin refrigerio';

                   ELSEIF (SELECT salida FROM asistencias WHERE idhorario = _idhorario 
                             AND diamarcado = CURDATE()) IS NULL THEN
                       
                       UPDATE asistencias
                       SET salida = CURTIME()
                       WHERE idhorario = _idhorario 
                         AND diamarcado = CURDATE();
                       
                       SELECT 'Se registró la salida';

                   ELSE
                       SELECT 'Ya completó todas las marcaciones de hoy';
                   END IF;
                END IF;
            END IF;
        END IF;

    ELSE
        SELECT 'Contrato vencido';
    END IF;
END //
DELIMITER ;



CALL spu_test1();


-- procedimiento para registrar al empleado
DELIMITER //
CREATE PROCEDURE sp_registrar_empleado(
    -- Datos personales
    IN p_apepaterno VARCHAR(40),
    IN p_apematerno VARCHAR(40),
    IN p_nombres VARCHAR(30),
    IN p_fechanac DATE,
    IN p_genero ENUM('M','F'),
    IN p_estadocivil ENUM('Soltero','Casado','Divorciado','Viudo','Separado','Conviviente'),
    IN p_tipodoc ENUM('DNI','CEX','PASS'),
    IN p_numdoc VARCHAR(15),
    IN p_direccion VARCHAR(40),
    IN p_referencia VARCHAR(30),
    IN p_telefono CHAR(9),
    IN p_email VARCHAR(200),
    IN p_iddistrito INT,

    -- Datos laborales
    IN p_idsucursal INT,
    IN p_idarea INT,
    IN p_idcargo INT,
    IN p_fechainicio DATE,
    IN p_fechafin DATE,
    IN p_sueldobase DECIMAL(7,2),
    IN p_toleranciadiaria INT,
    IN p_toleranciamensual INT
)
BEGIN
    -- Insertar persona
    INSERT INTO personas(
        apepaterno, apematerno, nombres, fechanac, genero, estadocivil,
        tipodoc, numdoc, direccion, referencia, telefono, email, iddistrito
    ) VALUES (
        p_apepaterno, p_apematerno, p_nombres, p_fechanac, p_genero, p_estadocivil,
        p_tipodoc, p_numdoc, p_direccion, p_referencia, p_telefono, p_email, p_iddistrito
    );

    -- Obtener ID de persona recién insertada
    SET @last_idpersona = LAST_INSERT_ID();

    -- Insertar contrato
    INSERT INTO contratos(
        fechainicio, fechafin, sueldobase, toleranciadiaria, toleranciamensual,
        idpersona, idcargo
    ) VALUES (
        p_fechainicio, p_fechafin, p_sueldobase, p_toleranciadiaria, p_toleranciamensual,
        @last_idpersona, p_idcargo
    );

END //

DELIMITER ;


-- Procedimiento almacenado modificado para INSERTAR en la tabla planillas
DELIMITER $$
CREATE PROCEDURE spu_generar_boletas_pago(
    IN p_anio INT,
    IN p_mes INT
)
BEGIN
    DECLARE v_rmv DECIMAL(10,2) DEFAULT 930.00;
    DECLARE v_dias_mes INT;
    DECLARE v_fecha_inicio_mes DATE;
    DECLARE v_fecha_fin_mes DATE;
    DECLARE v_dias_habiles INT;

    -- Fechas del mes
    SET v_fecha_inicio_mes = STR_TO_DATE(CONCAT(p_anio, '-', LPAD(p_mes,2,'0'), '-01'), '%Y-%m-%d');
    SET v_fecha_fin_mes = LAST_DAY(v_fecha_inicio_mes);
    SET v_dias_mes = DAY(v_fecha_fin_mes);

    -- Días hábiles (lunes a sábado)
    WITH RECURSIVE dias AS (
        SELECT v_fecha_inicio_mes AS fecha
        UNION ALL
        SELECT DATE_ADD(fecha, INTERVAL 1 DAY)
        FROM dias
        WHERE fecha < v_fecha_fin_mes
    )
    SELECT COUNT(*) INTO v_dias_habiles
    FROM dias
    WHERE DAYOFWEEK(fecha) BETWEEN 2 AND 7;

    -- Eliminar planillas previas
    DELETE FROM planillas WHERE mes = p_mes AND anio = p_anio;

    -- Insertar boletas
    INSERT INTO planillas (
        mes, anio, rmv, numero, dni, colaborador, area, cargo, fecha_ingreso,
        dias_mes, dias_remunerados, dias_falta, horas_extra_25, horas_extra_35,
        remuneracion_basica, descuento_faltas, neto_descuento_faltas,
        tiene_asignacion_familiar, asignacion_familiar,
        monto_horas_extra_25, monto_horas_extra_35, total_conceptos_remunerativos,
        feriados, movilidad, total_remuneracion_mensual, total_remuneracion_computable,
        essalud_vida, otros_conceptos, sistema_pensiones, onp_afp,
        aporte_obligatorio, prima_seguro, comision_flujo, total_aporte,
        impuesto_renta, prestamos, adelantos, descuento_judicial, total_descuentos,
        neto_pagar, aporte_empleador_675, aporte_empleador_225, aporte_empleador_075
    )
    SELECT 
        p_mes, p_anio, v_rmv,
        ROW_NUMBER() OVER (ORDER BY p.idpersona) AS numero,
        p.numdoc AS dni,
        CONCAT(p.apepaterno, ' ', p.apematerno, ' ', p.nombres) AS colaborador,
        a.area,
        c.cargo,
        ct.fechainicio AS fecha_ingreso,
        v_dias_mes,
        COUNT(DISTINCT asi.diamarcado) AS dias_remunerados,
        SUM(CASE WHEN asi.tipoasistencia = '-' THEN 1 ELSE 0 END) AS dias_falta,

        -- Horas extras
        (SUM(
            CASE 
                WHEN TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.entrada), CONCAT(asi.diamarcado,' ',asi.salida))
                   - TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.iniciorefrigerio), CONCAT(asi.diamarcado,' ',asi.finrefrigerio)) > 480
                THEN LEAST(
                    TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.entrada), CONCAT(asi.diamarcado,' ',asi.salida))
                    - TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.iniciorefrigerio), CONCAT(asi.diamarcado,' ',asi.finrefrigerio)) - 480,
                    120
                )
                ELSE 0
            END
        ) / 60) AS horas_extra_25,

        (SUM(
            CASE 
                WHEN TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.entrada), CONCAT(asi.diamarcado,' ',asi.salida))
                   - TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.iniciorefrigerio), CONCAT(asi.diamarcado,' ',asi.finrefrigerio)) > 600
                THEN TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.entrada), CONCAT(asi.diamarcado,' ',asi.salida))
                   - TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.iniciorefrigerio), CONCAT(asi.diamarcado,' ',asi.finrefrigerio)) - 600
                ELSE 0
            END
        ) / 60) AS horas_extra_35,

        -- Sueldo base y descuentos por faltas
        ct.sueldobase,
        (ct.sueldobase / v_dias_habiles) * SUM(CASE WHEN asi.tipoasistencia='-' THEN 1 ELSE 0 END) AS descuento_faltas,
        ct.sueldobase - ((ct.sueldobase / v_dias_habiles) * SUM(CASE WHEN asi.tipoasistencia='-' THEN 1 ELSE 0 END)) AS neto_descuento_faltas,

        -- Asignación familiar
        CASE WHEN EXISTS (SELECT 1 FROM cargafamiliar cf WHERE cf.idpersona=p.idpersona) THEN 'Sí' ELSE 'No' END,
        CASE WHEN EXISTS (SELECT 1 FROM cargafamiliar cf WHERE cf.idpersona=p.idpersona) THEN v_rmv*0.10 ELSE 0 END,

        -- Monto horas extra
        ((ct.sueldobase / 30 / 8) * 1.25) *
        (SUM(
            CASE 
                WHEN TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.entrada), CONCAT(asi.diamarcado,' ',asi.salida))
                   - TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.iniciorefrigerio), CONCAT(asi.diamarcado,' ',asi.finrefrigerio)) > 480
                THEN LEAST(
                    TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.entrada), CONCAT(asi.diamarcado,' ',asi.salida))
                    - TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.iniciorefrigerio), CONCAT(asi.diamarcado,' ',asi.finrefrigerio)) - 480,
                    120
                )
                ELSE 0
            END
        ) / 60) AS monto_horas_extra_25,

        ((ct.sueldobase / 30 / 8) * 1.35) *
        (SUM(
            CASE 
                WHEN TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.entrada), CONCAT(asi.diamarcado,' ',asi.salida))
                   - TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.iniciorefrigerio), CONCAT(asi.diamarcado,' ',asi.finrefrigerio)) > 600
                THEN TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.entrada), CONCAT(asi.diamarcado,' ',asi.salida))
                   - TIMESTAMPDIFF(MINUTE, CONCAT(asi.diamarcado,' ',asi.iniciorefrigerio), CONCAT(asi.diamarcado,' ',asi.finrefrigerio)) - 600
                ELSE 0
            END
        ) / 60) AS monto_horas_extra_35,

        -- Total conceptos remunerativos
        ct.sueldobase
        - ((ct.sueldobase/v_dias_habiles)*SUM(CASE WHEN asi.tipoasistencia='-' THEN 1 ELSE 0 END))
        + CASE WHEN EXISTS (SELECT 1 FROM cargafamiliar cf WHERE cf.idpersona=p.idpersona) THEN v_rmv*0.10 ELSE 0 END
        + COALESCE(SUM(0),0), -- las horas extra ya están calculadas arriba

           -- Feriados trabajados
        COALESCE((SELECT COUNT(*) 
            FROM feriados f
            WHERE STR_TO_DATE(CONCAT(f.aniocurso, '-', f.mes, '-', f.dia), '%Y-%m-%d')
                BETWEEN v_fecha_inicio_mes AND v_fecha_fin_mes), 0) AS feriados,

        -- Movilidad del mes
        COALESCE((SELECT m.monto FROM movilidad m WHERE m.idpersona=p.idpersona AND m.anio=p_anio AND m.mes=p_mes),0) AS movilidad,

        -- Total remuneración mensual = básicos + asignaciones + movilidad + feriados
        ct.sueldobase
        + CASE WHEN EXISTS (SELECT 1 FROM cargafamiliar cf WHERE cf.idpersona=p.idpersona) THEN v_rmv*0.10 ELSE 0 END
        + COALESCE((SELECT m.monto FROM movilidad m WHERE m.idpersona=p.idpersona AND m.anio=p_anio AND m.mes=p_mes),0),

        -- Total remuneración computable (simplificado, mismo que mensual)
        ct.sueldobase
        + CASE WHEN EXISTS (SELECT 1 FROM cargafamiliar cf WHERE cf.idpersona=p.idpersona) THEN v_rmv*0.10 ELSE 0 END,

        'EsSalud' AS essalud_vida,
        '' AS otros_conceptos,
        sp.sistemapensiones,
        sp.nombre,

        -- Aportes AFP/ONP
        (ct.sueldobase * (sp.pctjaportetrabajador/100)) AS aporte_obligatorio,
        (ct.sueldobase * (sp.pctjseguro/100)) AS prima_seguro,
        (ct.sueldobase * (sp.pctjcomision/100)) AS comision_flujo,

        (ct.sueldobase * ((sp.pctjaportetrabajador+sp.pctjseguro+sp.pctjcomision)/100)) AS total_aporte,

        -- Impuesto a la renta (simplificado Perú)
        CASE 
            WHEN (ct.sueldobase*12) > (7*(SELECT uit FROM parametros_renta WHERE anio=p_anio))
            THEN ct.sueldobase*0.08
            ELSE 0
        END AS impuesto_renta,

        -- Prestamos (cuotas del mes)
        COALESCE((SELECT SUM(pd.monto_cuota) FROM prestamos_detalle pd 
                  INNER JOIN prestamos pr ON pr.idprestamo=pd.idprestamo
                  WHERE pr.idpersona=p.idpersona AND pd.anio=p_anio AND pd.mes=p_mes AND pd.pagado=0),0) AS prestamos,

        -- Adelantos del mes
        COALESCE((SELECT SUM(ad.monto) FROM adelantos ad WHERE ad.idpersona=p.idpersona 
                  AND YEAR(ad.fecha)=p_anio AND MONTH(ad.fecha)=p_mes),0) AS adelantos,

        -- Descuentos judiciales
        COALESCE((SELECT CASE 
                    WHEN dj.porcentaje IS NOT NULL THEN (ct.sueldobase*(dj.porcentaje/100))
                    WHEN dj.monto_fijo IS NOT NULL THEN dj.monto_fijo
                    ELSE 0 END
                  FROM descuentos_judiciales dj 
                  WHERE dj.idpersona=p.idpersona AND dj.activo=1
                  LIMIT 1),0) AS descuento_judicial,

        -- Total descuentos
        (ct.sueldobase * ((sp.pctjaportetrabajador+sp.pctjseguro+sp.pctjcomision)/100))
        + CASE WHEN (ct.sueldobase*12) > (7*(SELECT uit FROM parametros_renta WHERE anio=p_anio)) THEN ct.sueldobase*0.08 ELSE 0 END
        + COALESCE((SELECT SUM(pd.monto_cuota) FROM prestamos_detalle pd 
                    INNER JOIN prestamos pr ON pr.idprestamo=pd.idprestamo
                    WHERE pr.idpersona=p.idpersona AND pd.anio=p_anio AND pd.mes=p_mes AND pd.pagado=0),0)
        + COALESCE((SELECT SUM(ad.monto) FROM adelantos ad WHERE ad.idpersona=p.idpersona 
                    AND YEAR(ad.fecha)=p_anio AND MONTH(ad.fecha)=p_mes),0)
        + COALESCE((SELECT CASE 
                    WHEN dj.porcentaje IS NOT NULL THEN (ct.sueldobase*(dj.porcentaje/100))
                    WHEN dj.monto_fijo IS NOT NULL THEN dj.monto_fijo
                    ELSE 0 END
                  FROM descuentos_judiciales dj WHERE dj.idpersona=p.idpersona AND dj.activo=1 LIMIT 1),0),

        -- Neto a pagar
        (ct.sueldobase
         + CASE WHEN EXISTS (SELECT 1 FROM cargafamiliar cf WHERE cf.idpersona=p.idpersona) THEN v_rmv*0.10 ELSE 0 END
         + COALESCE((SELECT m.monto FROM movilidad m WHERE m.idpersona=p.idpersona AND m.anio=p_anio AND m.mes=p_mes),0))
        -
        ((ct.sueldobase * ((sp.pctjaportetrabajador+sp.pctjseguro+sp.pctjcomision)/100))
        + CASE WHEN (ct.sueldobase*12) > (7*(SELECT uit FROM parametros_renta WHERE anio=p_anio)) THEN ct.sueldobase*0.08 ELSE 0 END
        + COALESCE((SELECT SUM(pd.monto_cuota) FROM prestamos_detalle pd 
                    INNER JOIN prestamos pr ON pr.idprestamo=pd.idprestamo
                    WHERE pr.idpersona=p.idpersona AND pd.anio=p_anio AND pd.mes=p_mes AND pd.pagado=0),0)
        + COALESCE((SELECT SUM(ad.monto) FROM adelantos ad WHERE ad.idpersona=p.idpersona 
                    AND YEAR(ad.fecha)=p_anio AND MONTH(ad.fecha)=p_mes),0)
        + COALESCE((SELECT CASE 
                    WHEN dj.porcentaje IS NOT NULL THEN (ct.sueldobase*(dj.porcentaje/100))
                    WHEN dj.monto_fijo IS NOT NULL THEN dj.monto_fijo
                    ELSE 0 END
                  FROM descuentos_judiciales dj WHERE dj.idpersona=p.idpersona AND dj.activo=1 LIMIT 1),0)),

        -- Aportes empleador
        (ct.sueldobase*(sp.pctjaporteempleador/100)) AS aporte_empleador_675,
        (ct.sueldobase*0.0225) AS aporte_empleador_225,
        (ct.sueldobase*0.0075) AS aporte_empleador_075

    FROM contratos ct
    INNER JOIN personas p ON p.idpersona=ct.idpersona
    INNER JOIN cargos c ON c.idcargo=ct.idcargo
    INNER JOIN areas a ON a.idarea=c.idarea
    LEFT JOIN horarios h ON h.idcontrato=ct.idcontrato
    LEFT JOIN asistencias asi ON asi.idhorario=h.idhorario
        AND YEAR(asi.diamarcado)=p_anio AND MONTH(asi.diamarcado)=p_mes
    LEFT JOIN historial_pensiones hp ON hp.idpersona=p.idpersona
    LEFT JOIN sispensiones sp ON sp.idsp=hp.idsp

    WHERE (ct.fechafin IS NULL OR ct.fechafin>=v_fecha_inicio_mes)
      AND ct.fechainicio<=v_fecha_fin_mes

    GROUP BY p.idpersona, p.numdoc, p.apepaterno, p.apematerno, p.nombres,
             a.area, c.cargo, ct.sueldobase, ct.idcontrato,
             sp.sistemapensiones, sp.nombre, sp.pctjaportetrabajador,
             sp.pctjseguro, sp.pctjcomision, sp.pctjaporteempleador;

    -- Mostrar planilla generada
    SELECT * FROM planillas WHERE mes=p_mes AND anio=p_anio ORDER BY numero;

END$$

DELIMITER ;

DELIMITER $$  
CREATE PROCEDURE spu_generar_tareo_dinamico(IN p_anio INT, IN p_mes INT)
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE dias_mes INT;
    DECLARE sql_interno LONGTEXT DEFAULT '';
    DECLARE sql_final LONGTEXT DEFAULT '';
    DECLARE col_dia VARCHAR(10);

    -- días del mes pedido
    SET dias_mes = DAY(LAST_DAY(STR_TO_DATE(CONCAT(p_anio, '-', p_mes, '-01'), '%Y-%m-%d')));

    -- SELECT interno: genera d1..dN (valores mostrados para cada día)
    SET sql_interno = CONCAT('
        SELECT
            p.idpersona,
            CONCAT(p.apepaterno, '' '', p.apematerno, '' '', p.nombres) AS colaborador,
            ar.area,
            ca.cargo');

    SET i = 1;
    WHILE i <= dias_mes DO
        SET col_dia = LPAD(i, 2, '0');
        SET sql_interno = CONCAT(sql_interno,
            ', MAX(
                CASE
                    WHEN DAY(asi.diamarcado) = ', i, ' THEN asi.tipoasistencia
                    ELSE
                        CASE
                            WHEN STR_TO_DATE(CONCAT(', p_anio, ', ''-'', ', p_mes, ', ''-'', ', i, '), ''%Y-%m-%d'') > CURDATE()
                                THEN NULL
                            ELSE ''-''
                        END
                END
            ) AS d', i);
        SET i = i + 1;
    END WHILE;

    -- FROM / JOIN y GROUP BY (el interno no calcula faltas totales)
    SET sql_interno = CONCAT(sql_interno, '
        FROM personas p
        JOIN contratos co ON co.idpersona = p.idpersona
        JOIN cargos ca ON ca.idcargo = co.idcargo
        JOIN areas ar ON ar.idarea = ca.idarea
        LEFT JOIN horarios h ON h.idcontrato = co.idcontrato
        LEFT JOIN asistencias asi ON asi.idhorario = h.idhorario
            AND YEAR(asi.diamarcado) = ', p_anio, '
            AND MONTH(asi.diamarcado) = ', p_mes, '
        GROUP BY p.idpersona, colaborador, ar.area, ca.cargo
    ');

    -- SELECT externo: toma las columnas d1..dN y calcula totales por fila usando IF(...)
    SET sql_final = 'SELECT base.*,'; 

    -- dias_trabajados = suma de dX = "X"
    SET i = 1;
    SET sql_final = CONCAT(sql_final, ' (');
    WHILE i <= dias_mes DO
        SET sql_final = CONCAT(sql_final, 'IF(d', i, ' = ''X'', 1, 0)');
        IF i < dias_mes THEN SET sql_final = CONCAT(sql_final, ' + '); END IF;
        SET i = i + 1;
    END WHILE;
    SET sql_final = CONCAT(sql_final, ') AS dias_trabajados,');

    -- dias_descanso = dX = "O"
    SET i = 1;
    SET sql_final = CONCAT(sql_final, ' (');
    WHILE i <= dias_mes DO
        SET sql_final = CONCAT(sql_final, 'IF(d', i, ' = ''O'', 1, 0)');
        IF i < dias_mes THEN SET sql_final = CONCAT(sql_final, ' + '); END IF;
        SET i = i + 1;
    END WHILE;
    SET sql_final = CONCAT(sql_final, ') AS dias_descanso,');

    -- falta_injustificada = dX = "-"
    SET i = 1;
    SET sql_final = CONCAT(sql_final, ' (');
    WHILE i <= dias_mes DO
        SET sql_final = CONCAT(sql_final, 'IF(d', i, ' = ''-'', 1, 0)');
        IF i < dias_mes THEN SET sql_final = CONCAT(sql_final, ' + '); END IF;
        SET i = i + 1;
    END WHILE;
    SET sql_final = CONCAT(sql_final, ') AS falta_injustificada,');

    -- feriado_laborado = dX = "D"
    SET i = 1;
    SET sql_final = CONCAT(sql_final, ' (');
    WHILE i <= dias_mes DO
        SET sql_final = CONCAT(sql_final, 'IF(d', i, ' = ''D'', 1, 0)');
        IF i < dias_mes THEN SET sql_final = CONCAT(sql_final, ' + '); END IF;
        SET i = i + 1;
    END WHILE;
    SET sql_final = CONCAT(sql_final, ') AS feriado_laborado,');

    -- descanso_feriado_laborado = dX = "T"
    SET i = 1;
    SET sql_final = CONCAT(sql_final, ' (');
    WHILE i <= dias_mes DO
        SET sql_final = CONCAT(sql_final, 'IF(d', i, ' = ''T'', 1, 0)');
        IF i < dias_mes THEN SET sql_final = CONCAT(sql_final, ' + '); END IF;
        SET i = i + 1;
    END WHILE;
    SET sql_final = CONCAT(sql_final, ') AS descanso_feriado_laborado,');

    -- feriado_no_laborado = dX = "FN"
    SET i = 1;
    SET sql_final = CONCAT(sql_final, ' (');
    WHILE i <= dias_mes DO
        SET sql_final = CONCAT(sql_final, 'IF(d', i, ' = ''FN'', 1, 0)');
        IF i < dias_mes THEN SET sql_final = CONCAT(sql_final, ' + '); END IF;
        SET i = i + 1;
    END WHILE;
    SET sql_final = CONCAT(sql_final, ') AS feriado_no_laborado,');

    -- licencia_sin_goce = dX = "LS"
    SET i = 1;
    SET sql_final = CONCAT(sql_final, ' (');
    WHILE i <= dias_mes DO
        SET sql_final = CONCAT(sql_final, 'IF(d', i, ' = ''LS'', 1, 0)');
        IF i < dias_mes THEN SET sql_final = CONCAT(sql_final, ' + '); END IF;
        SET i = i + 1;
    END WHILE;
    SET sql_final = CONCAT(sql_final, ') AS licencia_sin_goce,');

    -- licencia_con_goce = dX = "LC"
    SET i = 1;
    SET sql_final = CONCAT(sql_final, ' (');
    WHILE i <= dias_mes DO
        SET sql_final = CONCAT(sql_final, 'IF(d', i, ' = ''LC'', 1, 0)');
        IF i < dias_mes THEN SET sql_final = CONCAT(sql_final, ' + '); END IF;
        SET i = i + 1;
    END WHILE;
    SET sql_final = CONCAT(sql_final, ') AS licencia_con_goce,');

    -- dias_remunerados = suma de tipos remunerados: X + O + D + FN + T + LC
    SET i = 1;
    SET sql_final = CONCAT(sql_final, ' (');
    WHILE i <= dias_mes DO
        SET sql_final = CONCAT(sql_final,
            'IF(d', i, ' IN (''X'',''O'',''D'',''FN'',''T'',''LC''), 1, 0)');
        IF i < dias_mes THEN SET sql_final = CONCAT(sql_final, ' + '); END IF;
        SET i = i + 1;
    END WHILE;
    SET sql_final = CONCAT(sql_final, ') AS dias_remunerados');

    -- finalizar: FROM (sql_interno) base
    SET sql_final = CONCAT(sql_final, ' FROM (', sql_interno, ') base');

    -- Ejecutar SQL dinámico
    SET @sql_to_run := sql_final;
    PREPARE stmt FROM @sql_to_run;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

DELIMITER ;


DELIMITER //
CREATE PROCEDURE sp_mostrar_asistencia (
    IN p_fechaInicio DATE,
    IN p_fechaFin DATE,
    IN p_dni VARCHAR(15)
)
BEGIN
    SELECT 
        p.idpersona,
        p.apepaterno,
        p.apematerno,
        p.nombres,
        p.numdoc AS dni,
        ar.area,
        cg.cargo,
        h.dia,
        a.diamarcado,
        a.entrada,
        a.iniciorefrigerio,
        a.finrefrigerio,
        a.salida,
        a.tardanza_minutos,
        a.salida_anticipada_minutos,
        a.exceso_refrigerio_minutos,
        a.minnolaborados,
        a.observacion
    FROM asistencias a
    JOIN horarios h ON a.idhorario = h.idhorario
    JOIN contratos c ON h.idcontrato = c.idcontrato
    JOIN personas p ON c.idpersona = p.idpersona
    JOIN cargos cg ON c.idcargo = cg.idcargo
    JOIN areas ar ON cg.idarea = ar.idarea
    WHERE 
        (p_fechaInicio IS NULL OR p_fechaFin IS NULL OR a.diamarcado BETWEEN p_fechaInicio AND p_fechaFin)
        AND (p_dni IS NULL OR p.numdoc = p_dni)
    ORDER BY a.diamarcado DESC;
END //
DELIMITER ;
