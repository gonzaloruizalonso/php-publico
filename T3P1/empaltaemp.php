<?php include 'funciones.php'; ?>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>ALTA EMPLEADO</h1>
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
        <label for="dni">DNI: </label><input type="text" name="dni" required><br>
        <label for="nom">Nombre empleado: </label><input type="text" name="nom" required><br>
        <label for="apellidos">Apellidos: </label><input type="text" name="apellidos" required><br>
        <label for="fecha_nac">Fecha nacimiento: </label><input type="date" name="fecha_nac" required><br>
        <label for="salario">Salario: </label><input type="text" name="salario" required><br>
        <label for="nomdep">Nombre departamento: </label>
        <select name="nomdep">
          <?php foreach($departamentos as $departamento) : ?>
      			<option> <?php echo $departamento ?> </option>
      		<?php endforeach; ?> <br>
        </select>
        <input type="submit" name="enviar" value="Enviar">
        </form>
      <?php
      }else {
        //ejecutar formulario
        $dni = stripslashes(htmlspecialchars(trim($_REQUEST['dni'])));
        $nomb = stripslashes(htmlspecialchars(trim($_REQUEST['nom'])));
        $apell = stripslashes(htmlspecialchars(trim($_REQUEST['apellidos'])));
        $fechanac = stripslashes(htmlspecialchars(trim($_REQUEST['fecha_nac'])));
        $salario = stripslashes(htmlspecialchars(trim($_REQUEST['salario'])));
        $nomdpto = stripslashes(htmlspecialchars(trim($_REQUEST['nomdep'])));

        $sqlprevio = "SELECT DNI FROM EMPLEADO WHERE DNI='$dni' ";
        $result = mysqli_query($conn, $sqlprevio);
        $fila = mysqli_fetch_assoc($result);
        $dniAux = $fila['DNI'];
        if (mysqli_query($conn, $sqlprevio)) {
          if ($dni!=$dniAux) {
            echo "Empleado creado correctamente<br>";
            //OK
            $sql = "INSERT INTO empleado (dni,nombre,apellidos,fecha_nac,salario)
            VALUES (\"".$dni."\",\"".$nomb."\",\"".$apell."\",\"".$fechanac."\",\"".$salario."\")";
            if (mysqli_query($conn, $sql)) {
                echo "Empleado creado correctamente<br>";
                //OK
                $sql2 = "SELECT cod_dpto as q FROM departamento
                WHERE nombre_dpto=\"".$nomdpto."\"";
                $result = mysqli_query($conn, $sql2);
                $fila = mysqli_fetch_assoc($result);
                $codidpto = $fila['q'];
                if (mysqli_query($conn, $sql2)) {
                    echo "Buscando departamento..<br>";
                    //OK
                                    $sql3 = "SELECT sysdate() as hoy";
                                    $result2 = mysqli_query($conn, $sql3);
                                    $fila2 = mysqli_fetch_assoc($result2);
                                    $fecha_hoy = $fila2['hoy'];

                                    if (mysqli_query($conn, $sql3)) {
                                        echo "Fecha de hoy seleccionada correctamente<br>";
                                        //OK
                                        $sql4 = "INSERT INTO empleado_departamento (dni,cod_dpto,fecha_ini)
                                        VALUES (\"".$dni."\",\"".$codidpto."\",\"".$fecha_hoy."\")";
                                        if (mysqli_query($conn, $sql4)) {
                                            echo "Empleado agregado al departamento correctamente<br>";
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
            } else {
                echo "Error: <br>" . mysqli_error($conn);
                mysqli_query($conn, "rollback;");
            }
          }else {
            echo "Ya existe un empleado con ese DNI<br>";
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
	$sql = "SELECT cod_dpto,nombre_dpto FROM departamento";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$departamentos[] = $row['nombre_dpto'];
		}
	}
	return $departamentos;
}
?>
