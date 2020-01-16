<?php include 'funciones.php'; ?>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>CAMBIAR DEPARTAMENTO A UN EMPLEADO</h1>
    <?php
      $conn = conectar();
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }
      mysqli_query($conn, "begin;");
      if (!isset($_POST) || empty($_POST)) {
        $departamentos = obtenerDepartamentos($conn);
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
        <label for="nuevodep">Nuevo departamento: </label>
        <select name="nuevodep">
          <?php foreach($departamentos as $departamento) : ?>
      			<option> <?php echo $departamento ?> </option>
      		<?php endforeach; ?> <br>
        </select><br><br>
        <input type="submit" name="enviar" value="Enviar">
        </form>
      <?php
      }else {
        //ejecutar formulario
        $nuevonomdpto = stripslashes(htmlspecialchars(trim($_REQUEST['nuevodep'])));
        //Selecciono el codigo
        $sqlprevio2 = "SELECT cod_dpto as q FROM departamento
        WHERE nombre_dpto='$nuevonomdpto' ";
        $result = mysqli_query($conn, $sqlprevio2);
        $fila = mysqli_fetch_assoc($result);
        $nuevodpto = $fila['q'];;
        if (mysqli_query($conn, $sqlprevio2)) {
          //ok
          $dniempleado = stripslashes(htmlspecialchars(trim($_REQUEST['dniempleado'])));

          $sql1 = "SELECT cod_dpto as q FROM empleado_departamento
          WHERE dni='$dniempleado' AND fecha_fin IS NULL";

          $result = mysqli_query($conn, $sql1);
          $fila = mysqli_fetch_assoc($result);
          $codidptoantiguo = $fila['q'];
          //echo "<br>".$sql1."<br>";
          if (mysqli_query($conn, $sql1)) {
              echo "Comprobando departamento..<br>";
              //ok
              if ($codidptoantiguo==$nuevodpto){
                echo "Ya esta en ese departamento <br>";
              }else {
                  $sql2 = "SELECT sysdate() as hoy";
                  $result2 = mysqli_query($conn, $sql2);
                  $fila2 = mysqli_fetch_assoc($result2);
                  $fecha_hoy = $fila2['hoy'];
                  if (mysqli_query($conn, $sql2)) {
                      echo "Fecha de hoy seleccionada correctamente<br>";
                      //OK
                      //update
                      $sql3 = "UPDATE empleado_departamento
                      SET fecha_fin='$fecha_hoy'
                      WHERE dni='$dniempleado' AND cod_dpto='$codidptoantiguo'";
                      //echo "<br>".$sql3."<br>";
                      if (mysqli_query($conn, $sql3)) {
                          echo "Actualizando antiguo departamento..<br>";
                          //OK
                          //insert
                          $sql4 = "INSERT INTO empleado_departamento (dni,cod_dpto,fecha_ini,fecha_fin)
                          VALUES (\"".$dniempleado."\",\"".$nuevodpto."\",'$fecha_hoy',null)";
                          //echo "<br>".$sql4."<br>";
                          if (mysqli_query($conn, $sql4)) {
                            echo "Departamento cambiado correctamente<br>";
                            echo "Empleado con DNI".$dniempleado." ha cambiado de ".$codidptoantiguo." a ".$nuevodpto." correctamente";
                            mysqli_query($conn, "commit;");
                          } else {
                              echo "Error: <br>" . mysqli_error($conn);
                              mysqli_query($conn, "rollback;");
                          }
                        } else {
                          echo "Error: <br>" . mysqli_error($conn);
                          mysqli_query($conn, "rollback;");
                      }
                  } else {
                      echo "Error: <br>" . mysqli_error($conn);
                      mysqli_query($conn, "rollback;");
                  }
                }
          } else {
              echo "Error: <br>" . mysqli_error($conn);
              mysqli_query($conn, "rollback;");
          }

        } else {
            echo "Error: <br>" . mysqli_error($conn);
            mysqli_query($conn, "rollback;");
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
