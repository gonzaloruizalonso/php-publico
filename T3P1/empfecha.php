<?php include 'funciones.php'; ?>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>¿Que ocurria en esta fecha?</h1>
    <?php
      $conn = conectar();
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }
      mysqli_query($conn, "begin;");
      if (!isset($_POST) || empty($_POST)) {
        //mostrar formulario
        ?>
        <form action="" method="post">
        <label for="fech">Fecha: </label>
        <input type="date" name="fech">
        <br>
        <input type="submit" name="enviar" value="Ver lista">
        </form>
      <?php
      }else {
        //ejecutar formulario
        $fechaIntervalo = $_REQUEST['fech'];

        $sql2 = "SELECT sysdate() as hoy";
        $result2 = mysqli_query($conn, $sql2);
        $fila2 = mysqli_fetch_assoc($result2);
        $fechaHoy = $fila2['hoy'];
        if (mysqli_query($conn, $sql2)) {
            //OK
        $finNULL = obtenerFinNULL($conn,$fechaIntervalo,$fechaHoy);
        $finNONULL = obtenerFinNONULL($conn,$fechaIntervalo);
        echo "<br>";
        foreach ($finNULL as $clave => $valor) {
          echo $valor;
          echo "<br>";
        }
        foreach ($finNONULL as $clave => $valor) {
          echo $valor;
          echo "<br>";
        }


        }else {
        echo "Error: <br>" . mysqli_error($conn);
        mysqli_query($conn, "rollback;");
        }
        mysqli_query($conn, "commit;");
        mysqli_close($conn);
      }

      ?>
  </body>
</html>
<?php
// Funciones utilizadas en el programa

// Obtengo todos los registros cuya fecha de fin NO sea null
function obtenerFinNONULL($db,$fechaIntervalo) {
	$empleados = array();
	$sql = "SELECT dni,cod_dpto from empleado_departamento where fecha_fin is NOT NULL
          AND '$fechaIntervalo' BETWEEN fecha_ini AND fecha_fin";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$empleados[] = "El empleado con DNI: ".$row['dni']." trabajaba en ".$row['cod_dpto'];
		}
	}
	return $empleados;
}
// Obtengo todos los registros cuya fecha de fin sea null
function obtenerFinNULL($db,$fechaIntervalo,$fechaHoy) {
	$empleados = array();
	$sql = "SELECT dni,cod_dpto from empleado_departamento where fecha_fin is NULL
          AND '$fechaIntervalo' BETWEEN fecha_ini AND '$fechaHoy'";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$empleados[] = "El empleado con DNI: ".$row['dni']." trabajaba (y sigue trabajando) en ".$row['cod_dpto'];
		}
	}
	return $empleados;
}
?>
