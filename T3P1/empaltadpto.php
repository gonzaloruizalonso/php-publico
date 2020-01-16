<?php
include 'funciones.php';
$nomdpto = stripslashes(htmlspecialchars(trim($_REQUEST['nomdep'])));
$conn = conectar();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT max(cod_dpto) FROM departamento";
$result = mysqli_query($conn, $sql);
$fila = mysqli_fetch_assoc($result);

$num = substr($fila['max(cod_dpto)'], 1, 3);
$num=(int)$num;
$num++;
$num=str_pad($num, 3, "0", STR_PAD_LEFT);
$cod_dpto = "D".$num;

$sqlprevio = "SELECT nombre_dpto as p FROM DEPARTAMENTO WHERE nombre_dpto='$nomdpto' ";
$result = mysqli_query($conn, $sqlprevio);
$fila = mysqli_fetch_assoc($result);
$nomdepAux = $fila['p'];
if (mysqli_query($conn, $sqlprevio)) {
  if ($nomdpto!=$nomdepAux) {
    //OK
    $sql2 = "INSERT INTO departamento (cod_dpto, nombre_DPTO)
    VALUES (\"".$cod_dpto."\",\"".$nomdpto."\")";
    if (mysqli_query($conn, $sql2)) {
      echo "Departamento agregado correctamente";
    } else {
      echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }
  }else {
    echo "Ya existe ese departamento";
  }
}



mysqli_close($conn);
?>
