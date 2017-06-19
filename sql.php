<?php
namespace sql;

$config=parse_ini_file('.\config.ini');
$conn = mysqli_connect($config['servername'], $config['username'], $config['password'], $config['dbname']);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

function ObtenerRolRecurso($recursoId) {
	global $conn;
	$sql="	
		SELECT
			recurso.Rol as Rol_Recurso
		FROM
			recurso
		WHERE
			recurso.ID=$recursoId
		";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$rolRecurso = mysqli_fetch_assoc($result);
	}	
	return $rolRecurso;
}

function ObtenerNombreRecurso($recursoId) {
	global $conn;
	$sql="	
		SELECT
			recurso.Nombre as Nombre_Recurso
		FROM
			recurso
		WHERE
			recurso.ID=$recursoId
		";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$nombreRecurso = mysqli_fetch_assoc($result);
	}	
	return $nombreRecurso;
}

function ObtenerListaRecursos() {
	global $conn;
	$sql="	
		SELECT
			recurso.ID as ID_Recurso,
			recurso.Nombre as Nombre_Recurso
		FROM
			recurso
		ORDER BY
			recurso.Nombre ASC
		";
	$result = mysqli_query($conn, $sql);
	$tabla=[];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$tabla[]=$row;
		}	
	}	
	return $tabla;
}

function ObtenerMiUltimaHojaDeHoras($recursoId) {
	global $conn;
	$sql="	
		SELECT
			hoja_horas.Semana as Semana,
			proyecto.nombre as Proyecto,
			hoja_horas.Horas as Horas
		FROM
			hoja_horas,
			recurso,
			proyecto 
		WHERE
			hoja_horas.Recurso=recurso.ID and
			hoja_horas.Proyecto=proyecto.ID and
			recurso.ID=$recursoId and
			semana=(SELECT MAX(semana) FROM hoja_horas where hoja_horas.recurso=$recursoId)
		";
	$result = mysqli_query($conn, $sql);
	$tabla=[];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$tabla[]=$row;
		}	
	}	
	return $tabla;
}

function ObtenerResumenImputacionProyectos($recursoId) {
	global $conn;
	$sql="	
		SELECT DISTINCT
			proyecto.nombre as Proyecto,
			(SELECT SUM(hh2.Horas) FROM hoja_horas hh2 WHERE hh1.Recurso=hh2.Recurso and hh1.Proyecto=hh2.Proyecto) as Suma_Horas
		FROM
			hoja_horas hh1,
			recurso,
			proyecto 
		WHERE
			hh1.Recurso=recurso.ID and
			hh1.Proyecto=proyecto.ID and
			recurso.ID=$recursoId
		";
	$result = mysqli_query($conn, $sql);
	$tabla=[];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$tabla[]=$row;
		}	
	}	
	return $tabla;
}

function ObtenerMiEquipo($gestorRecursosId) {
	global $conn;
	$sql="	
		SELECT DISTINCT
			r1.Nombre as Nombre_Recurso,
			r1.Rol as Rol_Recurso,
			hoja_horas.Semana as Ultima_Hoja_Horas
		FROM
			recurso r2,
			recurso r1
		LEFT JOIN
			hoja_horas
		ON 
			hoja_horas.semana=(SELECT MAX(semana) FROM hoja_horas where hoja_horas.recurso=r1.ID)	
		WHERE
			r1.Manager=r2.ID and
			r1.Manager=$gestorRecursosId
		";
	$result = mysqli_query($conn, $sql);
	$tabla=[];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$tabla[]=$row;
		}	
	}	
	return $tabla;
}

function ObternerRecursosProyectosPlanificadoActual($gestorRecursosId) {
	global $conn;
	$sql="	
		SELECT
			Plan.Nombre_Recurso,
			Plan.Nombre_Proyecto,
			Plan.Horas_Planificadas,
			Actual.Horas_Imputadas	
		FROM
		(
		SELECT
			recurso.Nombre as Nombre_Recurso,
			proyecto.Nombre as Nombre_Proyecto,
			sum(plan_recursos.Horas) as Horas_Planificadas
		FROM
			plan_recursos,
			recurso,
			proyecto
		WHERE
			plan_recursos.recurso=recurso.ID and
			plan_recursos.proyecto=proyecto.ID and
			recurso.Manager=$gestorRecursosId
		GROUP BY
			Nombre_Recurso,
			Nombre_Proyecto
		) AS Plan

		LEFT JOIN 

		(
		SELECT
			recurso.Nombre as Nombre_Recurso,
			proyecto.Nombre as Nombre_Proyecto,
			sum(hoja_horas.Horas) as Horas_Imputadas
		FROM
			hoja_horas,
			recurso,
			proyecto
		WHERE
			hoja_horas.recurso=recurso.ID and
			hoja_horas.proyecto=proyecto.ID and
			recurso.Manager=$gestorRecursosId	
		GROUP BY
			Nombre_Recurso,
			Nombre_Proyecto
		) AS Actual

		ON
			Plan.Nombre_recurso=Actual.Nombre_Recurso and
			Plan.Nombre_Proyecto=Actual.Nombre_Proyecto
			
		UNION	

		SELECT
			Actual.Nombre_Recurso,
			Actual.Nombre_Proyecto,
			Plan.Horas_Planificadas,
			Actual.Horas_Imputadas	
		FROM
		(
		SELECT
			recurso.Nombre as Nombre_Recurso,
			proyecto.Nombre as Nombre_Proyecto,
			sum(plan_recursos.Horas) as Horas_Planificadas
		FROM
			plan_recursos, 
			recurso,
			proyecto
		WHERE
			plan_recursos.recurso=recurso.ID and
			plan_recursos.proyecto=proyecto.ID and
			recurso.Manager=$gestorRecursosId
		GROUP BY
			Nombre_Recurso,
			Nombre_Proyecto
		) AS Plan

		RIGHT JOIN 

		(
		SELECT
			recurso.Nombre as Nombre_Recurso,
			proyecto.Nombre as Nombre_Proyecto,
			sum(hoja_horas.Horas) as Horas_Imputadas
		FROM
			hoja_horas,
			recurso,
			proyecto
		WHERE
			hoja_horas.recurso=recurso.ID and
			hoja_horas.proyecto=proyecto.ID and
			recurso.Manager=$gestorRecursosId	
		GROUP BY
			Nombre_Recurso,
			Nombre_Proyecto
		) AS Actual

		ON
			Plan.Nombre_recurso=Actual.Nombre_Recurso and
			Plan.Nombre_Proyecto=Actual.Nombre_Proyecto
		";
	$result = mysqli_query($conn, $sql);
	$tabla=[];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$tabla[]=$row;
		}	
	}	
	return $tabla;
}

function ObtenerMisProyectosEnEjecucion($projectManagerId) { 
	global $conn;
	$sql="
		SELECT
			proyecto.Nombre Nombre_Proyecto,
			tipo_proyecto.Nombre T_Proyecto,
			fase_proyecto.Nombre F_Proyecto,
			proyecto.Fecha_P_Inicio,
			proyecto.Fecha_P_Fin,	
			proyecto.Presupuesto,
			(SELECT
				sum(plan_recursos.Horas*recurso.Coste_Hora)
				FROM
				plan_recursos,
				recurso
				WHERE
				plan_recursos.Recurso=recurso.ID and
				plan_recursos.Proyecto=proyecto.ID
			) as Gasto_Planificado,
			(SELECT
				sum(hoja_horas.Horas*recurso.Coste_Hora)
				FROM
				hoja_horas,
				recurso
				WHERE
				hoja_horas.Recurso=recurso.ID and
				hoja_horas.Proyecto=proyecto.ID
			) as Gasto_Actual
			
		FROM
			proyecto,
			tipo_proyecto,
			fase_proyecto,
			recurso
		WHERE
			proyecto.Tipo=tipo_proyecto.ID and
			proyecto.fase=fase_proyecto.ID and
			proyecto.PM=recurso.ID and
			fase_proyecto.Nombre<>'Cierre' and
			proyecto.PM=$projectManagerId
		";
		
	$result = mysqli_query($conn, $sql);
	$tabla=[];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$tabla[]=$row;
		}	
	}	
	return $tabla;
}

function ObtenerMisProyectosUltimoSeguimiento($projectManagerId) {
	global $conn;
	$sql="
		SELECT 
			Consulta_Fecha.Proyecto_Nombre,
			Consulta_Fecha.Ultimo_Seguimiento,
			Consulta_Estado.Estado,
			Consulta_Estado.Descripcion
		FROM

		(SELECT
			proyecto.Nombre as Proyecto_Nombre,
			max(seguimiento_proyecto.Fecha_Seguimiento) as Ultimo_Seguimiento
		FROM
			fase_proyecto,
			proyecto
		LEFT JOIN
			seguimiento_proyecto
		ON
			proyecto.ID=seguimiento_proyecto.Proyecto
		WHERE
			proyecto.fase=fase_proyecto.ID and
			fase_proyecto.Nombre<>'Cierre' and
			PM=$projectManagerId
		GROUP BY
			proyecto.Nombre
		) AS Consulta_Fecha

		LEFT JOIN	

		(SELECT
			proyecto.Nombre as Proyecto_Nombre,
			seguimiento_proyecto.Fecha_Seguimiento,
			seguimiento_proyecto.Estado,
			seguimiento_proyecto.Descripcion
		FROM
			fase_proyecto,
			proyecto,
			seguimiento_proyecto
		WHERE
			proyecto.ID=seguimiento_proyecto.Proyecto and
			proyecto.fase=fase_proyecto.ID and
			fase_proyecto.Nombre<>'Cierre' and
			PM=$projectManagerId
		) AS Consulta_Estado

		ON

		Consulta_Fecha.Proyecto_Nombre=Consulta_Estado.Proyecto_Nombre and
		Consulta_Fecha.Ultimo_Seguimiento=Consulta_Estado.Fecha_Seguimiento
		";
	$result = mysqli_query($conn, $sql);
	$tabla=[];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$tabla[]=$row;
		}	
	}	
	return $tabla;
}

function ObtenerMisProyectosMonitorizadosPorGasto($projectManagerId) {
	global $conn;
	$sql="
		SELECT
			proyecto.Nombre,
			proyecto.Presupuesto,
			(SELECT
				sum(plan_recursos.Horas*recurso.Coste_Hora)
				FROM
				plan_recursos,
				recurso
				WHERE
				plan_recursos.Recurso=recurso.ID and
				plan_recursos.Proyecto=proyecto.ID
			) as Gasto_Planificado,
			(SELECT
				sum(hoja_horas.Horas*recurso.Coste_Hora)
				FROM
				hoja_horas,
				recurso
				WHERE
				hoja_horas.Recurso=recurso.ID and
				hoja_horas.Proyecto=proyecto.ID
			) as Gasto_Actual
			
		FROM
			proyecto,
			fase_proyecto
		WHERE
			proyecto.fase=fase_proyecto.ID and
			fase_proyecto.Nombre<>'Cierre' and
			proyecto.PM=$projectManagerId

		";
	$result = mysqli_query($conn, $sql);
	$tabla=[];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$tabla[]=$row;
		}	
	}	
	return $tabla;	
}

function ObtenerMisProyectosMonitorizadosPorPlazo($projectManagerId) {
	global $conn;
	$sql="
		SELECT 
			Consulta_Fecha.Proyecto_Nombre,
			Consulta_Fecha.Fecha_R_Inicio,
			Consulta_Fecha.Fecha_P_Fin,
			Consulta_Estado.Estado,
			Consulta_Fecha.Duracion_Estimada_Proyecto,
			Consulta_Fecha.Dias_Restantes
		FROM

		(SELECT
			proyecto.Nombre as Proyecto_Nombre,
			proyecto.Fecha_R_Inicio,
			proyecto.Fecha_P_Fin,
			DATEDIFF(proyecto.Fecha_P_Fin,proyecto.Fecha_R_Inicio) as Duracion_Estimada_Proyecto,
			DATEDIFF(proyecto.Fecha_P_Fin,CURDATE()) as Dias_Restantes,
			max(seguimiento_proyecto.Fecha_Seguimiento) as Ultimo_Seguimiento
		FROM
			fase_proyecto,
			proyecto
		LEFT JOIN
			seguimiento_proyecto
		ON
			proyecto.ID=seguimiento_proyecto.Proyecto
		WHERE
			proyecto.fase=fase_proyecto.ID and
			fase_proyecto.Nombre<>'Cierre' and
			DATEDIFF(proyecto.Fecha_P_Fin,CURDATE())<=1*DATEDIFF(proyecto.Fecha_P_Fin,proyecto.Fecha_R_Inicio) and
			proyecto.PM=$projectManagerId
		GROUP BY
			proyecto.Nombre
		) AS Consulta_Fecha

		LEFT JOIN	

		(SELECT
			proyecto.Nombre as Proyecto_Nombre,
			seguimiento_proyecto.Fecha_Seguimiento,
			seguimiento_proyecto.Estado
		FROM
			fase_proyecto,
			proyecto,
			seguimiento_proyecto
		WHERE
			proyecto.ID=seguimiento_proyecto.Proyecto and
			proyecto.fase=fase_proyecto.ID and
			fase_proyecto.Nombre<>'Cierre' and
			PM=$projectManagerId
		) AS Consulta_Estado

		ON
			Consulta_Fecha.Proyecto_Nombre=Consulta_Estado.Proyecto_Nombre and
			Consulta_Fecha.Ultimo_Seguimiento=Consulta_Estado.Fecha_Seguimiento
		";
	$result = mysqli_query($conn, $sql);
	$tabla=[];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$tabla[]=$row;
		}	
	}	
	return $tabla;	
}
?>