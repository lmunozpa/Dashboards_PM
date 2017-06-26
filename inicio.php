<html>
<head>
<link rel="stylesheet" href="hoja_estilo.css">
<title>Página de inicio</title>
</head>
<body>
<?php
require 'sql.php';
$recursos = \sql\ObtenerListaRecursos();

echo "<h1> Cuadros de Mando</h1>";
echo "<h2> Página de inicio</h2><hr>";
echo "Por favor seleccione un usuario, un cuadro de mando y pulse Entrar<br><br>";
echo "<form action='/redirigir_dashboard.php' method='GET'>";
echo "<select name='usuario'>";
if (count($recursos) > 0) {
	foreach ($recursos as $recurso) {;
		echo "<option value=" . $recurso["ID_Recurso"] . ">" . $recurso["Nombre_Recurso"] . "</option>";
	}
} else {
    echo "0 results";
}
echo "</select> <br><br>";

echo "<input type='radio' name='dashboard' value='Recurso' checked> Cuadro de Mando de Recurso<br>";
echo "<input type='radio' name='dashboard' value='Gestor_Recursos'> Cuadro de Mando de Gestor de Recursos<br>";
echo "<input type='radio' name='dashboard' value='Gestor_Proyectos'> Cuadro de Mando de Gestor de Proyectos<br>";

echo "<input type='submit' value='Entrar'>";
echo "</form>";
?>
</body>
</html>