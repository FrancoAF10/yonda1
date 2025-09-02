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
        iddistrito                 	INT AUTO_INCREMENT                      PRIMARY KEY,
        distrito                    VARCHAR(40)                             NOT NULL,
        idprovincia                 INT                                     NOT NULL,

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
        direccion                   VARCHAR(40)                             NOT NULL,
        referencia                  VARCHAR(30)                             NOT NULL,
        estadocivil                 ENUM('Soltero', 'Casado', 'Divorciado', 'Viudo', 'Separado', 'Conviviente')                              NOT NULL,
        iddistrito                  INT                                     NOT NULL,

        CONSTRAINT fk_iddistrito_pers FOREIGN KEY (iddistrito) REFERENCES distritos(iddistrito),
        CONSTRAINT uk_numdoc_pers UNIQUE (numdoc)


    )ENGINE = INNODB;



    CREATE TABLE contratos(
        idcontrato                  INT AUTO_INCREMENT                      PRIMARY KEY,
        fechainicio                 DATE                                    NOT NULL,
        fechafin                    DATE                                    NULL,
        sueldobase                  DECIMAL(7.2)                            NOT NULL,
        toleranciadiaria            INT                                     NOT NULL,
        toleranciamensual           INT                                     NOT NULL,
        idpersona                   INT                                     NOT NULL,
        idcargo                     INT                                     NOT NULL,

        CONSTRAINT fk_idpersona_cont FOREIGN KEY (idpersona) REFERENCES personas(idpersona),
        CONSTRAINT fk_idcargo_cont FOREIGN KEY (idcargo) REFERENCES cargos(idcargo)

    )ENGINE = INNODB;
    CREATE TABLE horarios(
        idhorario                   INT AUTO_INCREMENT                     	PRIMARY KEY,
        dia                         VARCHAR(10)                         	NOT NULL,
        entrada                     TIME                                	NOT NULL,
        iniciorefrigerio            TIME                                 	NULL,
        finrefrigerio               TIME                                 	NULL,
        salida                      TIME                                 	NULL,
        idcontrato                  INT                                     	NOT NULL,

        CONSTRAINT fk_idcontrato_hora FOREIGN KEY (idcontrato) REFERENCES contratos(idcontrato)

    )ENGINE = INNODB;

    CREATE TABLE asistencias(
        idasistencia                INT AUTO_INCREMENT                      PRIMARY KEY,
        diamarcado                         DATE                                 NOT NULL,
        entrada                     TIME                                	NULL,
        iniciorefrigerio            TIME                                	NULL,
        finrefrigerio               TIME                                	NULL,
        salida                      TIME                                	NULL,
        minnolaborados              INT                                     	NULL,
        tipoasistencia              ENUM('con goce','sin goce','permiso','inasistencia','regular')  DEFAULT 'regular',
        idhorario                   INT                                     NOT NULL,

        CONSTRAINT fk_idhorario_asis FOREIGN KEY (idhorario) REFERENCES horarios(idhorario)

    )ENGINE = INNODB;
    
    CREATE TABLE tipolicencias(
    idtipolicencia          		INT AUTO_INCREMENT                          PRIMARY KEY,
    nombretipo              		VARCHAR(30)                                 NOT NULL,
    descripcion             		VARCHAR(255)                                NOT NULL,
    diasmaximo              		INT                                         NOT NULL,
    horasmaximo             		INT                                         NOT NULL,
    idasistencia           			INT                                         NOT NULL,

    CONSTRAINT fk_idasistencia FOREIGN KEY (idasistencia) REFERENCES asistencias(idasistencia)
    
	 )ENGINE = INNODB;


	CREATE TABLE permisosalida(
	    idpermisosalida             INT                                     PRIMARY KEY,
	    fechasolicitud              DATETIME DEFAULT NOW()                  NOT NULL,
	    fechapermiso                DATETIME DEFAULT NOW()                  NOT NULL,
	    horasalida                  TIME                                    NOT NULL,
	    horaretorno                 TIME                                    NULL,
	    motivo                      VARCHAR(50)                             NOT NULL,
	    estado                      BOOLEAN DEFAULT FALSE                   NOT NULL,
	    idtipopermiso               INT                                     NOT NULL,
	
	    CONSTRAINT fk_idtipopermiso_perm FOREIGN KEY (idtipopermiso) REFERENCES tipopermiso(idtipopermiso)
	)ENGINE = INNODB;
	
	
	CREATE TABLE usuarios(
	    idusuario                    INT AUTO_INCREMENT                      PRIMARY KEY,
	    nombreusuario                VARCHAR(20)                             NOT NULL,
	    claveacceso                  VARCHAR(255)                            NOT NULL,
		 idcontrato                  INT                                     NOT NULL,
	
	    CONSTRAINT fk_idcontrato_usua FOREIGN KEY (idcontrato) REFERENCES contratos(idcontrato),
	    CONSTRAINT uk_nombreusuario_usua UNIQUE (nombreusuario)
	)ENGINE = INNODB;
	
	CREATE TABLE cargafamiliar(
	    idcarga                 	  INT AUTO_INCREMENT                      PRIMARY KEY,
	    parentesco                 	  VARCHAR(50)                             NOT NULL,
	    idpersona                     INT                                     NOT NULL,
	    idcontrato                    INT                                     NOT NULL,
	
	    CONSTRAINT fk_idpersona_carg FOREIGN KEY (idpersona) REFERENCES personas(idpersona),
	    CONSTRAINT fk_idcontrato_carg FOREIGN KEY (idcontrato) REFERENCES contratos(idcontrato)
	
	)ENGINE = INNODB;
	
	CREATE TABLE feriados (
    idferiado 						INT AUTO_INCREMENT PRIMARY KEY,
    aniocurso 						YEAR NOT NULL,
    mes 							TINYINT UNSIGNED NOT NULL CHECK (mes BETWEEN 1 AND 12),
    dia 							TINYINT UNSIGNED NOT NULL CHECK (dia BETWEEN 1 AND 31)
	)ENGINE=InnoDB;


	CREATE TABLE laboraferiado(
		idlaboraferiado				INT AUTO_INCREMENT PRIMARY KEY,
		idferiado					INT,
		idcontrato					INT,
		CONSTRAINT fk_feriado_pk FOREIGN KEY (idferiado) REFERENCES feriados(idferiado),
   	CONSTRAINT fk_contrato_pk FOREIGN KEY (idcontrato) REFERENCES contratos(idcontrato)
	)ENGINE=INNODB;

	CREATE TABLE sispensiones(
		idsp						INT PRIMARY KEY AUTO_INCREMENT,
		sistemapensiones			VARCHAR(10),
		nombre						VARCHAR(20),
		pctjaportetrabajador		DECIMAL(4,2),
		pctjcomision				DECIMAL(4,2),
		pctjseguro					DECIMAL(4,2),
		pctjaporteempleador			DECIMAL(4,2),
		fechainicio					DATE NOT NULL,
		fechafin					DATE NULL
	)ENGINE=INNODB;
	
	CREATE TABLE historial_pensiones(
	idhistorial						INT PRIMARY KEY AUTO_INCREMENT,
	cussp							VARCHAR(12),
	fechainicio						DATE,
	fechafin						DATE,
	idpersona						INT,
	idsp							INT,
	CONSTRAINT fk_idpersona_fk FOREIGN KEY (idpersona) REFERENCES personas(idpersona),
	CONSTRAINT fk_idsp_fk FOREIGN KEY (idsp) REFERENCES sispensiones(idsp)
	)ENGINE=INNODB;