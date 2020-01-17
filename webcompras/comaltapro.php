<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA PRODUCTOS - Nombre del alumno</h1>
<?php
include "conexion.php";
mysqli_query($conn, "begin;");
$categorias = obtenerCategorias($conn);
/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) {

    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Datos Producto</div>
<div class="card-body">
		<div class="form-group">
        ID PRODUCTO <input type="text" name="idproducto" placeholder="idproducto" class="form-control">
        </div>
		<div class="form-group">
        NOMBRE PRODUCTO <input type="text" name="nombre" placeholder="nombre" class="form-control">
        </div>
		<div class="form-group">
        PRECIO PRODUCTO <input type="text" name="precio" placeholder="precio" class="form-control">
        </div>
	<div class="form-group">
	<label for="categoria">Categorías:</label>
	<select name="categoria">
    <?php foreach($categorias as $c) : ?>
      <option> <?php echo $c ?> </option>
    <?php endforeach; ?> <br>
	</select>
	</div>
	</BR>
<?php
	echo '<div><input type="submit" value="Alta Producto"></div>
	</form>';
} else {
	// Aquí va el código al pulsar submit
  $idprod = stripslashes(htmlspecialchars(trim($_REQUEST['idproducto'])));
  $nomprod = stripslashes(htmlspecialchars(trim($_REQUEST['nombre'])));
  $precioprod = stripslashes(htmlspecialchars(trim($_REQUEST['precio'])));
  $nomcat = stripslashes(htmlspecialchars(trim($_REQUEST['categoria'])));

  $sqlprevio = "SELECT ID_CATEGORIA FROM CATEGORIA WHERE NOMBRE='$nomcat' ";
  $result = mysqli_query($conn, $sqlprevio);
  $fila = mysqli_fetch_assoc($result);
  $idcat = $fila['ID_CATEGORIA'];
  if (mysqli_query($conn, $sqlprevio)) {
    //-----------
    $sqlprevio1 = "SELECT nombre as n FROM producto WHERE nombre='$nomprod' ";
    $result = mysqli_query($conn, $sqlprevio1);
    $fila = mysqli_fetch_assoc($result);
    $nomprodAux = $fila['n'];
    if (mysqli_query($conn, $sqlprevio1)) {
      if ($nomprod!=$nomprodAux) {
        $sqlprevio2 = "SELECT ID_PRODUCTO as i FROM PRODUCTO WHERE ID_PRODUCTO='$idprod' ";
        $result = mysqli_query($conn, $sqlprevio2);
        $fila = mysqli_fetch_assoc($result);
        $idAux = $fila['i'];
        if (mysqli_query($conn, $sqlprevio2)) {
          if ($idprod!=$idAux) {
            $sql="INSERT INTO PRODUCTO (ID_PRODUCTO,NOMBRE,PRECIO,ID_CATEGORIA)
            VALUES ('$idprod','$nomprod','$precioprod','$idcat')";
            if (mysqli_query($conn, $sql)) {
              echo "Producto agregado correctamente";
            } else {
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
              mysqli_query($conn, "rollback;");
            }
          }else {
            echo "Ya existe un producto con ese ID";
          }
        }else {
          echo "Error: " . $sqlprevio2 . "<br>" . mysqli_error($conn);
          mysqli_query($conn, "rollback;");
        }
      }else {
        echo "Ya existe un producto con ese nombre";
      }
    }else {
      echo "Error: " . $sqlprevio1 . "<br>" . mysqli_error($conn);
      mysqli_query($conn, "rollback;");
    }
    //-----------
  }else {
    echo "Error: <br>" . mysqli_error($conn);
    mysqli_query($conn, "rollback;");
  }
  mysqli_query($conn, "commit;");
  mysqli_close($conn);
}
?>

<?php
// Funciones utilizadas en el programa
function obtenerCategorias($db) {
	$categorias = array();
	$sql = "SELECT nombre FROM categoria";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$categorias[] = $row['nombre'];
		}
	}
	return $categorias;
}







?>



</body>

</html>
