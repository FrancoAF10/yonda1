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

-- Vista para mostrar personas
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
	    DP_P.departamento AS DepartamentoP,
	    PV_P.provincia    AS ProvinciaP,
	    DT_P.distrito     AS DistritoP,
	
	    -- ubicación de la sucursal
	    SC.sucursal,
	    DP_S.departamento AS DepartamentoS,
	    PV_S.provincia    AS ProvinciaS,
	    DT_S.distrito     AS DistritoS,
	
	    AR.area,
	    CR.cargo,
	    CT.fechainicio,
	    CT.fechafin,
	    CT.sueldobase,
	    CT.toleranciadiaria,
	    CT.toleranciamensual,
		CT.estado
	FROM contratos CT
	INNER JOIN (
	    SELECT idpersona, MAX(fechainicio) AS fechainicio_max
	    FROM contratos
	    WHERE fechafin >= CURDATE()        -- solo contratos vigentes
	    GROUP BY idpersona
	) ult ON CT.idpersona = ult.idpersona AND CT.fechainicio = ult.fechainicio_max
	INNER JOIN personas PS    ON CT.idpersona = PS.idpersona
	INNER JOIN cargos CR      ON CT.idcargo = CR.idcargo
	INNER JOIN areas AR       ON CR.idarea = AR.idarea
	INNER JOIN sucursales SC  ON AR.idsucursal = SC.idsucursal
	
	-- ubicación de la persona
	INNER JOIN distritos DT_P    ON PS.iddistrito = DT_P.iddistrito
	INNER JOIN provincias PV_P   ON DT_P.idprovincia = PV_P.idprovincia
	INNER JOIN departamentos DP_P ON PV_P.iddepartamento = DP_P.iddepartamento
	
	-- ubicación de la sucursal
	INNER JOIN distritos DT_S    ON SC.iddistrito = DT_S.iddistrito
	INNER JOIN provincias PV_S   ON DT_S.idprovincia = PV_S.idprovincia
	INNER JOIN departamentos DP_S ON PV_S.iddepartamento = DP_S.iddepartamento
	WHERE estado = 'Activo';
	


-- ==========================================
-- Vista: mostrar_areas
-- ==========================================

CREATE VIEW mostrar_areas AS
SELECT 
    AR.area,
    COUNT(AR.area) AS 'Numero de personas'
FROM contratos CT
JOIN personas PS ON CT.idpersona = PS.idpersona
JOIN cargos CA ON CT.idcargo = CA.idcargo
LEFT JOIN areas AR ON ca.idarea = AR.idarea
GROUP BY AR.area;


-- ==========================================
-- Vista: mostrar_cargos
-- ==========================================

CREATE VIEW mostrar_cargos AS
SELECT 
    CA.cargo,
    COUNT(AR.area) AS 'Numero de personas cargos'
FROM contratos CT
JOIN personas PS ON CT.idpersona = PS.idpersona
JOIN cargos CA ON CT.idcargo = ca.idcargo
LEFT JOIN areas AR ON CA.idarea = AR.idarea
GROUP BY CA.cargo
ORDER BY 'Numero de personas cargos' ASC;

-- ==========================================
-- Vista: historial_contratos_vencidos
-- ==========================================

CREATE VIEW historial_contratos_vencidos AS
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
    DP1.departamento AS departamento_persona,
    PV1.provincia    AS provincia_persona,
    DT1.distrito     AS distrito_persona,
    SC.sucursal,
    DP2.departamento AS departamento_sucursal,
    PV2.provincia    AS provincia_sucursal,
    DT2.distrito     AS distrito_sucursal,
    AR.area,
    CR.cargo,
    CT.fechainicio,
    CT.fechafin,
    CT.sueldobase,
    CT.toleranciadiaria,
    CT.toleranciamensual
FROM contratos CT
JOIN personas PS       ON CT.idpersona = PS.idpersona
JOIN cargos CR         ON CT.idcargo = CR.idcargo
JOIN areas AR          ON CR.idarea = AR.idarea
JOIN sucursales SC     ON AR.idsucursal = SC.idsucursal

-- distrito/provincia/departamento de la persona
JOIN distritos DT1     ON PS.iddistrito = DT1.iddistrito
JOIN provincias PV1    ON DT1.idprovincia = PV1.idprovincia
JOIN departamentos DP1 ON PV1.iddepartamento = DP1.iddepartamento

-- distrito/provincia/departamento de la sucursal
JOIN distritos DT2     ON SC.iddistrito = DT2.iddistrito
JOIN provincias PV2    ON DT2.idprovincia = PV2.idprovincia
JOIN departamentos DP2 ON PV2.iddepartamento = DP2.iddepartamento

WHERE CT.fechafin < CURDATE();













CREATE OR REPLACE VIEW vista_asistencia_detallada AS
SELECT
    a.idasistencia,
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
JOIN areas ar ON cg.idarea = ar.idarea;
