<?php include 'funciones.php'; ?>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>CAMBIAR SALARIO A UN EMPLEADO</h1>
    <?php
      $conn = conectar();
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }
      mysqli_query($conn, "begin;");
      if (!isset($_POST) || empty($_POST)) {
        $empleados = obtenerEmpleados($conn);
        //mostrar formulario
        ?>
        <form action="" method="post">
        <label for="dniempleado">DNI: </label>
        <select name="dniempleado">
          <?php foreach($empleados as $empleado) : ?>
      			<option> <?php echo $empleado ?> </option>
      		<?php endforeach; ?> <br>
        </select><br>
        <label for="porcen">Porcentaje ([ej: 23] [ej: -10]): </label>
        <input type="number" name="porcen">% <br>
        <input type="submit" name="enviar" value="Enviar">
        </form>
      <?php
      }else {
        //ejecutar formulario
        $dniform = stripslashes(htmlspecialchars(trim($_REQUEST['dniempleado'])));
        $porcentaje = (int) stripslashes(htmlspecialchars(trim($_REQUEST['porcen'])));
        $sql= "UPDATE empleado SET salario=salario+((salario*$porcentaje)/100) WHERE
               dni='$dniform';";
        //echo $sql;
        echo "<br>";
        if (mysqli_query($conn, $sql)) {
            echo "Salario actualizado<br>";
            //OK
          } else {
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
// Obtengo todos los empleados
//para mostrarlos en la lista de valores
function obtenerEmpleados($db) {
	$empleados = array();
	$sql = "SELECT DISTINCT dni FROM empleado_departamento";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$empleados[] = $row['dni'];
		}
	}
	return $empleados;
}
?>
