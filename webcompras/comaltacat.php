<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA CATEGORÍAS - Nombre del alumno</h1>
<?php
include "conexion.php";
mysqli_query($conn, "begin;");

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) {

    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Datos Categoría</div>
<div class="card-body">
		<div class="form-group">
        ID CATEGORIA <input type="text" name="idcategoria" placeholder="idcategoria" class="form-control">
        </div>
		<div class="form-group">
        NOMBRE CATEGORIA <input type="text" name="nombre" placeholder="nombre" class="form-control">
        </div>

		</BR>
<?php
	echo '<div><input type="submit" value="Alta Categoría"></div>
	</form>';
} else {
	// Aquí va el código al pulsar submit

    $idcat=stripslashes(htmlspecialchars(trim($_REQUEST['idcategoria'])));
    $nomcat=stripslashes(htmlspecialchars(trim($_REQUEST['nombre'])));

    $sqlprevio = "SELECT nombre as n FROM categoria WHERE nombre='$nomcat' ";
    $result = mysqli_query($conn, $sqlprevio);
    $fila = mysqli_fetch_assoc($result);
    $nomcatAux = $fila['n'];
    if (mysqli_query($conn, $sqlprevio)) {
      if ($nomcat!=$nomcatAux) {
        $sqlprevio2 = "SELECT ID_CATEGORIA as i FROM categoria WHERE ID_CATEGORIA='$idcat' ";
        $result = mysqli_query($conn, $sqlprevio2);
        $fila = mysqli_fetch_assoc($result);
        $idAux = $fila['i'];
        if (mysqli_query($conn, $sqlprevio2)) {
          if ($idcat!=$idAux) {
            $sql="INSERT INTO CATEGORIA (ID_CATEGORIA,NOMBRE)
            VALUES ('$idcat','$nomcat')";
            if (mysqli_query($conn, $sql)) {
              echo "Categoría agregada correctamente";
            } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              mysqli_query($conn, "rollback;");
            }
          }else {
            echo "Ya existe una categoria con ese ID";
          }
        }else {
          echo "Error: " . $sqlprevio2 . "<br>" . mysqli_error($conn);
          mysqli_query($conn, "rollback;");
        }
      }else {
        echo "Ya existe una categoria con ese nombre";
      }
    }else {
      echo "Error: " . $sqlprevio . "<br>" . mysqli_error($conn);
      mysqli_query($conn, "rollback;");
    }
}
mysqli_query($conn, "commit;");
mysqli_close($conn);
?>

<?php
// Funciones utilizadas en el programa








?>



</body>

</html>
