<?php include 'funciones.php'; ?>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>HISTORICO EN UN DEPARTAMENTO</h1>
    <?php
      $conn = conectar();
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }
      mysqli_query($conn, "begin;");
      if (!isset($_POST) || empty($_POST)) {
        $departamentos = obtenerDepartamentos($conn);
        //mostrar formulario
        ?>
        <form action="" method="post">
        <label for="nuevodep">Departamento: </label>
        <select name="nuevodep">
          <?php foreach($departamentos as $departamento) : ?>
      			<option> <?php echo $departamento ?> </option>
      		<?php endforeach; ?> <br>
        </select><br><br>
        <input type="submit" name="enviar" value="Ver lista">
        </form>
      <?php
      }else {
        //ejecutar formulario
        $nuevonomdpto = stripslashes(htmlspecialchars(trim($_REQUEST['nuevodep'])));
        $sqlprevio2 = "SELECT cod_dpto as q FROM departamento
        WHERE nombre_dpto='$nuevonomdpto' ";
        $result = mysqli_query($conn, $sqlprevio2);
        $fila = mysqli_fetch_assoc($result);
        $nuevodpto = $fila['q'];

        $datosEmpleados=obtenerEmpleadosDep($conn,$nuevodpto);
        echo "<br>Empleados que tuvo el departamento $nuevonomdpto";
        echo "<br>";

        foreach ($datosEmpleados as $clave => $valor) {
          echo "$valor <br>";
        }
        mysqli_close($conn);
      }

      ?>
  </body>
</html>
<?php
// Funciones utilizadas en el programa

// Obtengo todos los departamentos
//para mostrarlos en la lista de valores
function obtenerDepartamentos($db) {
	$departamentos = array();
	$sql = "SELECT nombre_dpto FROM departamento";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$departamentos[] = $row['nombre_dpto'];
		}
	}
	return $departamentos;
}
// Obtengo todos los empleados de un departamento
function obtenerEmpleadosDep($db,$depAux) {
	$empleados = array();
	$sql = "SELECT empleado.dni,empleado.nombre,empleado.apellidos,
          empleado_departamento.fecha_ini,empleado_departamento.fecha_fin from EMPLEADO,empleado_departamento where
          empleado.dni=empleado_departamento.dni and empleado_departamento.cod_dpto='$depAux' and
          empleado_departamento.fecha_fin IS NOT NULL and empleado.dni in
  (SELECT DISTINCT dni FROM empleado_departamento where cod_dpto='$depAux' AND fecha_fin is NOT NULL)";
  $resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$empleados[] = $row['dni']." ".$row['nombre']." ".$row['apellidos']." INICIO->".$row['fecha_ini']." FIN->".$row['fecha_fin'];
		}
	}
	return $empleados;
}
?>
