<html>
<head>
<title>Cuadro de Mando: Gestor de Proyectos</title>
</head>

<body>
 
<?php
require 'sql.php';
$GestorProyectosId=$_GET["usuario"];
$GestorProyectos= \sql\ObtenerNombreRecurso($GestorProyectosId)["Nombre_Recurso"];

echo "<br> Cuadro de Mando: Gestor de Proyectos<hr>";
echo "<br> ID: $GestorProyectosId<br>";
echo "<br> Nombre: $GestorProyectos<hr>";		

$misProyectosEnEjecucion = \sql\ObtenerMisProyectosEnEjecucion($GestorProyectosId);

echo "<br> Mis proyectos en ejecucion<br><br>";

if (count($misProyectosEnEjecucion) > 0) {
    echo "<table border= 1px solid black><tr><th>Nombre_Proyecto</th><th>Tipo_Proyecto</th><th>Fase_Proyecto</th><th>Fecha_Planificada_Inicio</th><th>Fecha_Planificada_Fin</th><th>Presupuesto</th><th>Gasto_Planificado</th><th>Gasto_Actual</th></tr>";
    foreach ($misProyectosEnEjecucion as $proyecto) {
		echo "<tr><td>" . $proyecto["Nombre_Proyecto"]. "</td><td>" . $proyecto["T_Proyecto"]. "</td><td>" . $proyecto["F_Proyecto"]. "</td><td>" . $proyecto["Fecha_P_Inicio"]. "</td><td>" . $proyecto["Fecha_P_Fin"]. "</td><td>" . $proyecto["Presupuesto"]. "</td><td>" . $proyecto["Gasto_Planificado"]. "</td><td>" . $proyecto["Gasto_Actual"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
		
$misProyectosUltimoSeguimiento = \sql\ObtenerMisProyectosUltimoSeguimiento($GestorProyectosId);

echo "<hr><br> Mis proyectos y ultimo seguimiento<br><br>";

if (count($misProyectosUltimoSeguimiento) > 0) {
    echo "<table border= 1px solid black><tr><th>Nombre_Proyecto</th><th>Ultimo_Seguimiento</th><th>Estado</th><th>Descripcion</th></tr>";
    foreach ($misProyectosUltimoSeguimiento as $proyecto) {
        echo "<tr><td>" . $proyecto["Proyecto_Nombre"]. "</td><td>" . $proyecto["Ultimo_Seguimiento"]. "</td><td>" . $proyecto["Estado"]. "</td><td>" . $proyecto["Descripcion"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}

$misProyectosMonitorizadosPorGasto = \sql\ObtenerMisProyectosMonitorizadosPorGasto($GestorProyectosId);

echo "<hr><br> Mis proyectos monitorizados por gasto<br><br>";

if (count($misProyectosMonitorizadosPorGasto) > 0) {
    echo "<table border= 1px solid black><tr><th>Nombre_Proyecto</th><th>Presupuesto</th><th>Gasto_Planificado</th><th>Gasto_Actual</th></tr>";
    foreach ($misProyectosMonitorizadosPorGasto as $proyecto) {
        echo "<tr><td>" . $proyecto["Nombre"]. "</td><td>" . $proyecto["Presupuesto"]. "</td><td>" . $proyecto["Gasto_Planificado"]. "</td><td>" . $proyecto["Gasto_Actual"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}

$misProyectosMonitorizadosPorPlazo = \sql\ObtenerMisProyectosMonitorizadosPorPlazo($GestorProyectosId);

echo "<hr><br> Mis Proyectos monitorizados por plazo<br><br>";

if (count($misProyectosMonitorizadosPorPlazo) > 0) {
    echo "<table border= 1px solid black><tr><th>Nombre_Proyecto</th><th>Fecha_Real_Inicio</th><th>Fecha_Planificada_Fin</th><th>Estado</th><th>Duracion_Estimada_Proyecto</th><th>Dias_Restantes</th></tr>";
    foreach ($misProyectosMonitorizadosPorPlazo as $proyecto) {
        echo "<tr><td>" . $proyecto["Proyecto_Nombre"]. "</td><td>" . $proyecto["Fecha_R_Inicio"]. "</td><td>" . $proyecto["Fecha_P_Fin"]. "</td><td>" . $proyecto["Estado"]. "</td><td>" . $proyecto["Duracion_Estimada_Proyecto"]. "</td><td>" . $proyecto["Dias_Restantes"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
?>
</body>
</html>