USE recursoshumanos;


-- Vista para mostrar las asistencias

CREATE VIEW mostrar_asistencia AS 
 SELECT 
    PS.idpersona,
    CONCAT(PS.apepaterno,' ', PS.apematerno, ' ', PS.nombres) AS 'Apellidos y Nombres',
    AR.area,
    CR.cargo,
    HR.dia,
    ASI.diamarcado,
    ASI.entrada,
    ASI.iniciorefrigerio,
    ASI.finrefrigerio,
    ASI.salida
FROM areas AR
INNER JOIN cargos CR      ON AR.idarea = CR.idarea
INNER JOIN contratos CT   ON CR.idcargo = CT.idcargo
INNER JOIN personas PS    ON CT.idpersona = PS.idpersona
INNER JOIN horarios HR    ON CT.idcontrato = HR.idcontrato
LEFT JOIN asistencias ASI ON HR.idhorario = ASI.idhorario
WHERE ASI.diamarcado = CURDATE(); 

-- Vista para mostrar a las trabajadores

CREATE VIEW mostrar_personas AS 
		 SELECT 
		    PS.idpersona,
		    PS.apepaterno,
			PS.apematerno,
			PS.nombres,
		    PS.fechanac,
		    PS.genero,
		    PS.estadocivil,
		    PS.tipodoc,
		    PS.numdoc,
			PS.direccion,
			PS.referencia,
			PS.telefono,
			PS.email,

			-- ubicación de la persona
			DP_P.departamento as DepartamentoP,
			PV_P.provincia as ProvinciaP,
			DT_p.distrito as DistritoP,

			-- ubicación de la sucursal
			SC.sucursal,
			DP_S.departamento as DepartamentoS,
			PV_S.provincia as ProvinciaS,
			DT_S.distrito as DistritoS,

		    AR.area,
		    CR.cargo,
			CT.fechainicio,
			CT.fechafin,
			CT.sueldobase,
			CT.toleranciadiaria,
			CT.toleranciamensual
	FROM contratos CT
	INNER JOIN personas PS    ON CT.idpersona = PS.idpersona
	INNER JOIN cargos CR      ON CT.idcargo = CR.idcargo
	INNER JOIN areas AR   ON CR.idarea = AR.idarea
	INNER JOIN sucursales SC   ON AR.idsucursal = SC.idsucursal
			-- ubicación de la persona
	INNER JOIN distritos DT_P    ON PS.iddistrito = DT_P.iddistrito
	INNER JOIN provincias PV_P   ON DT_P.idprovincia = PV_P.idprovincia
	INNER JOIN departamentos DP_P ON PV_P.iddepartamento = DP_P.iddepartamento
			-- ubicación de la sucursal
	INNER JOIN distritos DT_S    ON SC.iddistrito = DT_S.iddistrito
	INNER JOIN provincias PV_S   ON DT_S.idprovincia = PV_S.idprovincia
	INNER JOIN departamentos DP_S ON PV_S.iddepartamento = DP_S.iddepartamento;

