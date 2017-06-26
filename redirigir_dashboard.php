<?php
require 'sql.php';
$dashboard=$_GET["dashboard"];
$recursoRol=\sql\ObtenerRolRecurso($_GET["usuario"]);
switch (true) {
	case ($dashboard=="Recurso"):
		header("Location: /dashboard_recurso.php?usuario=" . $_GET["usuario"]);
		break;
	case $dashboard=="Gestor_Recursos" and $recursoRol['Rol_Recurso']=="Manager":
		header("Location: /dashboard_gestor_recursos.php?usuario=" . $_GET["usuario"]);
		break;
	case $dashboard=="Gestor_Proyectos" and $recursoRol['Rol_Recurso']== "Project Manager":
		header("Location: /dashboard_gestor_proyectos.php?usuario=" . $_GET["usuario"]);
		break;
	default:
		header("Location: /inicio.php");
		break;
}
?>