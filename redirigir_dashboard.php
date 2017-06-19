<?php
$dashboard=$_GET["dashboard"];
switch ($dashboard) {
	case "Recurso":
		header("Location: /dashboard_recurso.php?usuario=" . $_GET["usuario"]);
		break;
	case "Gestor_Recursos":
		header("Location: /dashboard_gestor_recursos.php?usuario=" . $_GET["usuario"]);
		break;
	case "Gestor_Proyectos":
		header("Location: /dashboard_gestor_proyectos.php?usuario=" . $_GET["usuario"]);
		break;
}
?>