<html>
<head>
<title>Cuadro de Mando: Recurso</title>
</head>
<body>
 
<?php
require 'sql.php';
$recursoId=$_GET["usuario"];
$recurso= \sql\ObtenerNombreRecurso($recursoId)["Nombre_Recurso"];

echo "<br> Cuadro de Mando: Recurso<hr>";
echo "<br> ID: $recursoId<br>";
echo "<br> Nombre: $recurso<hr>";		

$miUltimaHojaDeHoras = \sql\ObtenerMiUltimaHojaDeHoras($recursoId);

echo "<br> Mi última hoja de horas<br><br>";

if (count($miUltimaHojaDeHoras) > 0) {
    echo "<table border= 1px solid black><tr><th>Semana</th><th>Proyecto</th><th>Horas</th></tr>";
    foreach ($miUltimaHojaDeHoras as $hojaDeHoras) {
        echo "<tr><td>" . $hojaDeHoras["Semana"]. "</td><td>" . $hojaDeHoras["Proyecto"]. "</td><td>" . $hojaDeHoras["Horas"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}
		
$resumenImputacionProyectos = \sql\ObtenerResumenImputacionProyectos($recursoId);

echo "<hr><br> Resumen de imputación a proyectos<br><br>";

if (count($resumenImputacionProyectos) > 0) {
    echo "<table border= 1px solid black><tr><th>Proyecto</th><th>Suma_Horas</th></tr>";
    foreach ($resumenImputacionProyectos as $proyecto) {
        echo "<tr><td>" . $proyecto["Proyecto"]. "</td><td>" . $proyecto["Suma_Horas"]. "</td></tr>";
    }
	echo "</table>";
} else {
    echo "0 results";
}

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