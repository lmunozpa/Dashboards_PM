<html>
<head>
<link rel="stylesheet" href="hoja_estilo.css">
<title>Cuadro de Mando: Gestor de Recursos</title>
</head>
<body>
 
<?php
require 'sql.php';
$GestorRecursosId=$_GET["usuario"];
$GestorRecursos= \sql\ObtenerNombreRecurso($GestorRecursosId)["Nombre_Recurso"];

echo "<div class='cabecera'>";
echo "<h1> Cuadro de Mando: Gestor de Recursos</h1>";
echo "<h2> ID: $GestorRecursosId</h2>";
echo "<h2> Nombre: $GestorRecursos</h2><hr>";		
echo "</div>";

$miEquipo = \sql\ObtenerMiEquipo($GestorRecursosId);

echo "<h3> Mi equipo</h3>";

if (count($miEquipo) > 0) {
    echo "<table><tr><th>Nombre_Recurso</th><th>Rol_Recurso</th><th>Ultima_Hoja_Horas</th></tr>";
    foreach ($miEquipo as $recurso) {
        echo "<tr><td>" . $recurso["Nombre_Recurso"]. "</td><td>" . $recurso["Rol_Recurso"]. "</td><td>" . $recurso["Ultima_Hoja_Horas"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
		
$recursosProyectosPlanificadoActual = \sql\ObternerRecursosProyectosPlanificadoActual($GestorRecursosId);

echo "<h3> Recursos y proyectos: Planificado vs Actual</h3>";

if (count($recursosProyectosPlanificadoActual) > 0) {
    echo "<table><tr><th>Nombre_Recurso</th><th>Nombre_Proyecto</th><th>Horas_Planificadas</th><th>Horas_Imputadas</th></tr>";
    foreach ($recursosProyectosPlanificadoActual as $recurso) {
        echo "<tr><td>" . $recurso["Nombre_Recurso"]. "</td><td>" . $recurso["Nombre_Proyecto"]. "</td><td>" . $recurso["Horas_Planificadas"]. "</td><td>" . $recurso["Horas_Imputadas"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
echo "</div>";
?>
</body>
</html>