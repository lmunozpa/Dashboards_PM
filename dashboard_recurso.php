<html>
<head>
<link rel="stylesheet" href="hoja_estilo.css">
<title>Cuadro de Mando: Recurso</title>
</head>
<body>
 
<?php
require 'sql.php';
$recursoId=$_GET["usuario"];
$recurso= \sql\ObtenerNombreRecurso($recursoId)["Nombre_Recurso"];

echo "<div class='cabecera'>";
echo "<h1> Cuadro de Mando: Recurso</h1>";
echo "<h2> ID: $recursoId</h2>";
echo "<h2> Nombre: $recurso</h2><hr>";
echo "</div>";		

$miUltimaHojaDeHoras = \sql\ObtenerMiUltimaHojaDeHoras($recursoId);
echo "<div>";
echo "<h3> Mi última hoja de horas</h3>";

if (count($miUltimaHojaDeHoras) > 0) {
    echo "<table><tr><th>Semana</th><th>Proyecto</th><th>Horas</th></tr>";
    foreach ($miUltimaHojaDeHoras as $hojaDeHoras) {
        echo "<tr><td>" . $hojaDeHoras["Semana"]. "</td><td>" . $hojaDeHoras["Proyecto"]. "</td><td align=\"right\">" . $hojaDeHoras["Horas"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
		
$resumenImputacionProyectos = \sql\ObtenerResumenImputacionProyectos($recursoId);

echo "<h3> Resumen de imputación a proyectos</h3>";

if (count($resumenImputacionProyectos) > 0) {
    echo "<table><tr><th>Proyecto</th><th>Suma_Horas</th></tr>";
    foreach ($resumenImputacionProyectos as $proyecto) {
        echo "<tr><td>" . $proyecto["Proyecto"]. "</td><td align=\"right\">" . $proyecto["Suma_Horas"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
echo "</div>";
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

	// Load the Visualization API and the corechart package.
	google.charts.load('current', {'packages':['corechart']});

	// Set a callback to run when the Google Visualization API is loaded.
	google.charts.setOnLoadCallback(drawChart);

	function drawChart () {
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Proyecto');
		data.addColumn('number', 'Horas');
			
		<?php
			global $recursoId;
			$resumenImputacionProyectos = \sql\ObtenerResumenImputacionProyectos($recursoId);
			if (count($resumenImputacionProyectos) > 0) {
				foreach ($resumenImputacionProyectos as $proyecto) {
					echo "data.addRow(['" . $proyecto["Proyecto"] . "'," . $proyecto["Suma_Horas"] . "]);";
				}
			} else {
				echo "0 results";
			}
		?>			
			
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		var options = {title: 'PieChart'};
		chart.draw(data, options);
		}
 </script>  

<div id="chart_div"></div> 
</body>
</html>