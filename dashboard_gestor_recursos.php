<html>
<head>
<title>Cuadro de Mando: Gestor de Recursos</title>
</head>
<body>
 
<?php
require 'sql.php';
$GestorRecursosId=$_GET["usuario"];
$GestorRecursos= \sql\ObtenerNombreRecurso($GestorRecursosId)["Nombre_Recurso"];

echo "<br> Cuadro de Mando: Gestor de Recursos<hr>";
echo "<br> ID: $GestorRecursosId<br>";
echo "<br> Nombre: $GestorRecursos<hr>";		

$miEquipo = \sql\ObtenerMiEquipo($GestorRecursosId);

echo "<br> Mi equipo<br><br>";

if (count($miEquipo) > 0) {
    echo "<table border= 1px solid black><tr><th>Nombre_Recurso</th><th>Rol_Recurso</th><th>Ultima_Hoja_Horas</th></tr>";
    foreach ($miEquipo as $recurso) {
        echo "<tr><td>" . $recurso["Nombre_Recurso"]. "</td><td>" . $recurso["Rol_Recurso"]. "</td><td>" . $recurso["Ultima_Hoja_Horas"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
		
$recursosProyectosPlanificadoActual = \sql\ObternerRecursosProyectosPlanificadoActual($GestorRecursosId);

echo "<hr><br> Recursos y proyectos: Planificado vs Actual<br><br>";

if (count($recursosProyectosPlanificadoActual) > 0) {
    echo "<table border= 1px solid black><tr><th>Nombre_Recurso</th><th>Nombre_Proyecto</th><th>Horas_Planificadas</th><th>Horas_Imputadas</th></tr>";
    foreach ($recursosProyectosPlanificadoActual as $recurso) {
        echo "<tr><td>" . $recurso["Nombre_Recurso"]. "</td><td>" . $recurso["Nombre_Proyecto"]. "</td><td>" . $recurso["Horas_Planificadas"]. "</td><td>" . $recurso["Horas_Imputadas"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
</body>
</html>