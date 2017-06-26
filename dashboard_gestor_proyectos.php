<html>
<head>
<link rel="stylesheet" href="hoja_estilo.css">
<title>Cuadro de Mando: Gestor de Proyectos</title>
</head>

<body>
 
<?php
require 'sql.php';
$GestorProyectosId=$_GET["usuario"];
$GestorProyectos= \sql\ObtenerNombreRecurso($GestorProyectosId)["Nombre_Recurso"];

echo "<div class='cabecera'>";
echo "<h1> Cuadro de Mando: Gestor de Proyectos</h1>";
echo "<h2> ID: $GestorProyectosId</h2>";
echo "<h2> Nombre: $GestorProyectos</h2><hr>";	
echo "</div>";

$misProyectosEnEjecucion = \sql\ObtenerMisProyectosEnEjecucion($GestorProyectosId);

echo "<div>";
echo "<h3> Mis proyectos en ejecución</h3>";

if (count($misProyectosEnEjecucion) > 0) {
    echo "<table><tr><th>Nombre_Proyecto</th><th>Tipo_Proyecto</th><th>Fase_Proyecto</th><th>Fecha_Planificada_Inicio</th><th>Fecha_Planificada_Fin</th><th>Presupuesto</th><th>Gasto_Planificado</th><th>Gasto_Actual</th></tr>";
    foreach ($misProyectosEnEjecucion as $proyecto) {
		echo "<tr><td>" . $proyecto["Nombre_Proyecto"]. "</td><td>" . $proyecto["T_Proyecto"]. "</td><td>" . $proyecto["F_Proyecto"]. "</td><td>" . $proyecto["Fecha_P_Inicio"]. "</td><td>" . $proyecto["Fecha_P_Fin"]. "</td><td>" . $proyecto["Presupuesto"]. "</td><td>" . $proyecto["Gasto_Planificado"]. "</td><td>" . $proyecto["Gasto_Actual"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
		
$misProyectosUltimoSeguimiento = \sql\ObtenerMisProyectosUltimoSeguimiento($GestorProyectosId);

echo "<h3> Mis proyectos y ultimo seguimiento</h3>";

if (count($misProyectosUltimoSeguimiento) > 0) {
    echo "<table><tr><th>Nombre_Proyecto</th><th>Ultimo_Seguimiento</th><th>Estado</th><th>Descripcion</th></tr>";
    foreach ($misProyectosUltimoSeguimiento as $proyecto) {
        echo "<tr><td>" . $proyecto["Proyecto_Nombre"]. "</td><td>" . $proyecto["Ultimo_Seguimiento"]. "</td><td>" . $proyecto["Estado"]. "</td><td>" . $proyecto["Descripcion"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}

$misProyectosMonitorizadosPorGasto = \sql\ObtenerMisProyectosMonitorizadosPorGasto($GestorProyectosId);

echo "<h3> Mis proyectos monitorizados por gasto</h3>";

if (count($misProyectosMonitorizadosPorGasto) > 0) {
    echo "<table><tr><th>Nombre_Proyecto</th><th>Presupuesto</th><th>Gasto_Planificado</th><th>Gasto_Actual</th></tr>";
    foreach ($misProyectosMonitorizadosPorGasto as $proyecto) {
        echo "<tr><td>" . $proyecto["Nombre"]. "</td><td>" . $proyecto["Presupuesto"]. "</td><td>" . $proyecto["Gasto_Planificado"]. "</td><td>" . $proyecto["Gasto_Actual"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}

$misProyectosMonitorizadosPorPlazo = \sql\ObtenerMisProyectosMonitorizadosPorPlazo($GestorProyectosId);

echo "<h3> Mis Proyectos monitorizados por plazo</h3>";

if (count($misProyectosMonitorizadosPorPlazo) > 0) {
    echo "<table><tr><th>Nombre_Proyecto</th><th>Fecha_Real_Inicio</th><th>Fecha_Planificada_Fin</th><th>Estado</th><th>Duracion_Estimada_Proyecto</th><th>Dias_Restantes</th></tr>";
    foreach ($misProyectosMonitorizadosPorPlazo as $proyecto) {
        echo "<tr><td>" . $proyecto["Proyecto_Nombre"]. "</td><td>" . $proyecto["Fecha_R_Inicio"]. "</td><td>" . $proyecto["Fecha_P_Fin"]. "</td><td>" . $proyecto["Estado"]. "</td><td>" . $proyecto["Duracion_Estimada_Proyecto"]. "</td><td>" . $proyecto["Dias_Restantes"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
echo "</div>";
?>
</body>
</html>