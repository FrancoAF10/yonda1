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