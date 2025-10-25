CREATE DATABASE recursoshumanos;
USE recursoshumanos;

    CREATE TABLE departamentos(
        iddepartamento              INT AUTO_INCREMENT                      PRIMARY KEY,
        departamento                VARCHAR(40)                             NOT NULL,

        CONSTRAINT uk_departamento_depa UNIQUE (departamento)

    )ENGINE = INNODB;


    CREATE TABLE provincias(
        idprovincia                 INT AUTO_INCREMENT                      PRIMARY KEY,
        provincia                   VARCHAR(40)                             NOT NULL,
        iddepartamento              INT                                     NOT NULL,


        CONSTRAINT fk_iddepartemento_prov FOREIGN KEY (iddepartamento) REFERENCES departamentos(iddepartamento),
        CONSTRAINT uk_provincia_prov UNIQUE (provincia)

    )ENGINE = INNODB;


    CREATE TABLE distritos(
        iddistrito                 INT AUTO_INCREMENT                      PRIMARY KEY,
        distrito                   VARCHAR(40)                             NOT NULL,
        idprovincia                INT                                     NOT NULL,

        CONSTRAINT fk_idprovincia_dist FOREIGN KEY (idprovincia) REFERENCES provincias(idprovincia),
        CONSTRAINT uk_distrito_provincia UNIQUE (distrito, idprovincia)

    )ENGINE = INNODB;

    CREATE TABLE sucursales(
        idsucursal                  INT AUTO_INCREMENT                      PRIMARY KEY,
        sucursal                    VARCHAR(40)                             NOT NULL,
        direccion                   VARCHAR(60)                             NOT NULL,
        referencia                  VARCHAR(50)                             NOT NULL,

        iddistrito                  INT                                     NOT NULL,

        CONSTRAINT fk_iddistrito_sucur FOREIGN KEY (iddistrito) REFERENCES distritos(iddistrito)

    )ENGINE = INNODB;


    CREATE TABLE areas(
        idarea                      INT AUTO_INCREMENT                      PRIMARY KEY,
        area                        VARCHAR(40)                             NOT NULL,
        idsucursal                  INT                                     NOT NULL,

        CONSTRAINT fk_idsucursal_area FOREIGN KEY (idsucursal) REFERENCES sucursales(idsucursal),
        CONSTRAINT uk_area_sucursal UNIQUE (area, idsucursal)
    ) ENGINE = INNODB;




    CREATE TABLE cargos(
        idcargo                     INT AUTO_INCREMENT                      PRIMARY KEY,
        cargo                       VARCHAR(40)                             NOT NULL,
        idarea                      INT                                     NOT NULL,

        CONSTRAINT fk_idarea_carg FOREIGN KEY (idarea) REFERENCES areas(idarea),
        CONSTRAINT uk_cargo_area UNIQUE (cargo, idarea)

    )ENGINE = INNODB;

    CREATE TABLE personas(
        idpersona                   INT AUTO_INCREMENT                      PRIMARY KEY,
        apepaterno                  VARCHAR(40)                             NOT NULL,
        apematerno                  VARCHAR(40)                             NOT NULL,
        nombres                     VARCHAR(30)                             NOT NULL,
        fechanac                    DATE                                    NOT NULL,
        genero                      ENUM('M', 'F')                          NOT NULL COMMENT 'M = Masculino ; F = Femenino',
        tipodoc                     ENUM('DNI', 'CEX', 'PASS')              NOT NULL COMMENT 'CEX = Carnet de EXtrangeria ; PASS = Pasaporte',
        numdoc                      VARCHAR(15)                             NOT NULL,
        email						VARCHAR(200)							NULL,
        telefono					CHAR(9)									NULL,
        direccion                   VARCHAR(200)                             NOT NULL,
        referencia                  VARCHAR(255)                             NOT NULL,
        estadocivil                 ENUM('Soltero', 'Casado', 'Divorciado', 'Viudo', 'Separado', 'Conviviente') NOT NULL,
        iddistrito                  INT                                     NOT NULL,

        CONSTRAINT fk_iddistrito_pers FOREIGN KEY (iddistrito) REFERENCES distritos(iddistrito),
        CONSTRAINT uk_numdoc_pers UNIQUE (numdoc)
    )ENGINE = INNODB;
    

    CREATE TABLE contratos(
        idcontrato                  INT AUTO_INCREMENT                      PRIMARY KEY,
        fechainicio                 DATE                                    NOT NULL,
        fechafin                    DATE                                    NULL,
        sueldobase                  DECIMAL(7,2)                            NOT NULL,
        toleranciadiaria            INT                                     NOT NULL,
        toleranciamensual           INT                                     NOT NULL,
        estado 						ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
        idpersona                   INT                                     NOT NULL,
        idcargo                     INT                                     NOT NULL,

        CONSTRAINT fk_idpersona_cont FOREIGN KEY (idpersona) REFERENCES personas(idpersona),
        CONSTRAINT fk_idcargo_cont FOREIGN KEY (idcargo) REFERENCES cargos(idcargo)
    )ENGINE = INNODB;

    CREATE TABLE motivolicencia(
        idmotivolic             INT AUTO_INCREMENT PRIMARY KEY,
        motivo                  VARCHAR(200)
    )ENGINE=INNODB;

    CREATE TABLE licencias (
        idlicencia              INT AUTO_INCREMENT PRIMARY KEY,
        conGoce                 BOOLEAN,
        fechainicio              DATE,
        fechafin                DATE,
        evidencia               VARCHAR(255),
        estado                  ENUM('Aprobado','Pendiente','Rechazado'),
        fechasolicitud          DATE,
        idcontrato              INT NOT NULL,
        idmotivolic             INT NOT NULL,
        CONSTRAINT fk_licencias_ct FOREIGN KEY (idcontrato) REFERENCES contratos(idcontrato),
        CONSTRAINT fk_motivolic_ml FOREIGN KEY (idmotivolic) REFERENCES motivolicencia(idmotivolic)
    )ENGINE=INNODB;
    
    CREATE TABLE horarios(
        idhorario                   INT AUTO_INCREMENT                      PRIMARY KEY,
        dia                         VARCHAR(10)                         NOT NULL,
        entrada                     TIME                                NOT NULL,
        iniciorefrigerio            TIME                                 NULL,
        finrefrigerio               TIME                                 NULL,
        salida                      TIME                                 NULL,
        idcontrato                  INT                                     NOT NULL,

        CONSTRAINT fk_idcontrato_hora FOREIGN KEY (idcontrato) REFERENCES contratos(idcontrato)

    )ENGINE = INNODB;

    CREATE TABLE asistencias(
            idasistencia                INT AUTO_INCREMENT                      PRIMARY KEY,
            diamarcado                         DATE                                 NOT NULL,
            entrada                     TIME                                NULL,
            iniciorefrigerio            TIME                                NULL,
            finrefrigerio               TIME                                NULL,
            salida                      TIME                                NULL,
            tardanza_minutos				INT 											NULL,
            salida_anticipada_minutos	INT 											NULL,
            exceso_refrigerio_minutos	INT 											NULL,
            observacion						VARCHAR(200)								NULL,	
            minnolaborados              INT                                     NULL,
            tipoasistencia              ENUM('con goce','sin goce','permiso','inasistencia','regular')  DEFAULT 'regular',
            idhorario                   INT                                     NOT NULL,

            CONSTRAINT fk_idhorario_asis FOREIGN KEY (idhorario) REFERENCES horarios(idhorario)

        )ENGINE = INNODB;


	
		CREATE TABLE permisos(
            idpermiso			INT AUTO_INCREMENT PRIMARY KEY,
            horainicio			TIME,
            horafin				TIME,
            duracionminutos     INT GENERATED ALWAYS AS (TIMESTAMPDIFF(MINUTE, horainicio, horafin)) STORED,
            motivo				VARCHAR(200),
            fechasolicitud		DATE,
            evidencia           VARCHAR(200),
            idasistencia		INT,
            CONSTRAINT fk_asistencia_pm FOREIGN KEY(idasistencia) REFERENCES asistencias(idasistencia)
        )ENGINE=INNODB;
			
		CREATE TABLE numerocuenta(
		idnumcuenta			INT AUTO_INCREMENT PRIMARY KEY,
		tipomoneda			VARCHAR(30) NOT NULL,
		tipoinstitucion	VARCHAR(100) NOT NULL,
		nombre				VARCHAR(30) NOT NULL,
		numcuenta			VARCHAR(20) NOT NULL,
		cci					VARCHAR(20) NOT NULL,
		fechainicio			DATE NOT NULL,
		fechafin				DATE NULL,
		idpersona			INT NOT NULL,
		CONSTRAINT fk_idpersona_nc FOREIGN KEY (idpersona) REFERENCES personas(idpersona)
		)ENGINE=INNODB;
		
        CREATE TABLE cargafamiliar(
            idcargafamiliar INT AUTO_INCREMENT PRIMARY KEY,
            parentesco ENUM('Hijo','Cónyuge','Padre','Madre','Otro') NOT NULL,
            evidencia VARCHAR(200) NULL,
            idpersona INT NOT NULL,   -- FK a trabajador (titular)
            idhijo INT NOT NULL,      -- FK a persona registrada como hijo/dependiente
            CONSTRAINT fk_idpersona_cf FOREIGN KEY (idpersona) REFERENCES personas(idpersona),
            CONSTRAINT fk_idhijo_cf FOREIGN KEY (idhijo) REFERENCES personas(idpersona)
        ) ENGINE=INNODB;
			
		CREATE TABLE sispensiones(
				idsp								INT AUTO_INCREMENT PRIMARY KEY,
				tiposistema						VARCHAR(150)				NOT NULL,
				nombresistema					VARCHAR(150)				NOT NULL,
				fechaafiliacion				    DATE							NULL,
				fechatermino					DATE 							NULL,
				cuspp							 	VARCHAR(12)					NULL,
				idpersona						INT							NOT NULL,		
		CONSTRAINT fk_idpersona_sis FOREIGN KEY (idpersona) REFERENCES personas(idpersona)		
		)ENGINE = INNODB;
			