<html>
<head>
<title>Pagina de inicio</title>
</head>
<body>
<?php
require 'sql.php';
$recursos = \sql\ObtenerListaRecursos();
echo "<br> Pagina de inicio<hr>";
echo "<form action='/redirigir_dashboard.php' method='GET'>";
echo "<select name='usuario'>";
if (count($recursos) > 0) {
	foreach ($recursos as $recurso) {
		echo "<option value=" . $recurso["ID_Recurso"] . ">" . $recurso["Nombre_Recurso"] . "</option>";
	}
} else {
    echo "0 results";
}
echo "</select> <br>";

echo "<input type='radio' name='dashboard' value='Recurso' checked> Dashboard de Recurso<br>";
echo "<input type='radio' name='dashboard' value='Gestor_Recursos'> Dashboard de Gestor de Recursos<br>";
echo "<input type='radio' name='dashboard' value='Gestor_Proyectos'> Dashboard de Gestor de Proyectos<br>";

echo "<input type='submit' value='Entrar'>";
echo "</form>";
?>
</body>
</html>