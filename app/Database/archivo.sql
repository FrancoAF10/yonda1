CREATE TABLE terminacionescontrato (
   idterminacion   INT AUTO_INCREMENT PRIMARY KEY,
   motivo          VARCHAR(150) 									NOT NULL,
   descripcion		 VARCHAR(255) 									NOT NULL,
	gravedad 		 ENUM('Leve', 'Moderado', 'Grave') 		NOT NULL,
   evidencia       VARCHAR(255) 									NULL,
   fecharegistro  TIMESTAMP DEFAULT 							NOW(),
   idcontrato      INT 												NOT NULL,

   CONSTRAINT fk_suspension_contrato FOREIGN KEY (idcontrato) REFERENCES contratos(idcontrato)
   
)ENGINE=INNODB;
DROP TABLE terminacionescontrato;

SELECT * FROM terminacionescontrato;


ALTER TABLE terminacionescontrato
ADD COLUMN descripcion VARCHAR(255) NOT NULL AFTER motivo;


SELECT * FROM contratos;

SELECT * FROM terminacionescontrato;






DELIMITER $$

CREATE PROCEDURE sp_insertar_terminacion (
    IN p_motivo VARCHAR(150),
    IN p_descripcion VARCHAR(255),
    IN p_gravedad ENUM('Leve','Moderado','Grave'),
    IN p_evidencia VARCHAR(255),
    IN p_idcontrato INT
)
BEGIN
    INSERT INTO terminacionescontrato (motivo, descripcion, gravedad, evidencia, idcontrato)
    VALUES (p_motivo, p_descripcion, p_gravedad, p_evidencia, p_idcontrato);
END$$

DELIMITER ;


-- procedmiento para crear y actualizar, actualizar el estado del contrato y insertar el dato en la tabla de terminacionescontrato
-- DELIMITER $$

-- CREATE PROCEDURE sp_registrar_terminacion (
--     IN p_motivo VARCHAR(150),
--     IN p_descripcion VARCHAR(255),
--     IN p_gravedad ENUM('Leve','Moderado','Grave'),
--     IN p_evidencia VARCHAR(255),
--     IN p_idcontrato INT
-- )
-- BEGIN
--     -- 1. Insertar en tabla de terminaciones
--     INSERT INTO terminacionescontrato (motivo, descripcion, gravedad, evidencia, idcontrato)
--     VALUES (p_motivo, p_descripcion, p_gravedad, p_evidencia, p_idcontrato);

--     -- 2. Actualizar estado del contrato
--     UPDATE contratos
--     SET estado = 'Inactivo'
--     WHERE idcontrato = p_idcontrato;
-- END$$

-- DELIMITER ;






DELIMITER $$

CREATE PROCEDURE sp_registrar_terminacion (
    IN p_motivo VARCHAR(150),
    IN p_descripcion VARCHAR(255),
    IN p_gravedad ENUM('Leve','Moderado','Grave'),
    IN p_evidencia VARCHAR(255),
    IN p_idcontrato INT
)
BEGIN
    -- 1. Insertar en la tabla terminacionescontrato
    INSERT INTO terminacionescontrato (
        motivo,
        descripcion,
        gravedad,
        evidencia,
        idcontrato
    )
    VALUES (
        p_motivo,
        p_descripcion,
        p_gravedad,
        p_evidencia,
        p_idcontrato
    );

    -- 2. Actualizar estado del contrato
    UPDATE contratos
    SET estado = 'Inactivo'
    WHERE idcontrato = p_idcontrato;
END$$

DELIMITER ;


-- CALL sp_registrar_terminacion(
--     'Bajo rendimiento',
--     'El trabajador no alcanzó los objetivos del último trimestre',
--     'Moderado',
--     'reporte.pdf',
--     3
-- );


-- agregar campo de "estado" para contratos
ALTER TABLE contratos
ADD COLUMN estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo' NOT NULL AFTER toleranciamensual;
