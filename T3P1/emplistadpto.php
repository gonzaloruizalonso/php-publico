<?php include 'funciones.php'; ?>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>LISTA DE EMPLEADOS EN UN DEPARTAMENTO</h1>
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
        echo "<br>Empleados del departamento $nuevonomdpto";
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
	$sql = "SELECT dni,nombre,apellidos from EMPLEADO where dni in
  (SELECT DISTINCT dni FROM empleado_departamento where cod_dpto='$depAux' AND fecha_fin is NULL)";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$empleados[] = $row['dni']." ".$row['nombre']." ".$row['apellidos'];
		}
	}
	return $empleados;
}
?>
