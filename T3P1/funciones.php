<?php
function conectar(){
  $servername = stripslashes(htmlspecialchars(trim('10.131.1.199')));
  $username = stripslashes(htmlspecialchars(trim('root')));
  $password = stripslashes(htmlspecialchars(trim('rootroot')));
  $dbname = stripslashes(htmlspecialchars(trim('empleadosnm')));
  return mysqli_connect($servername, $username, $password, $dbname);
}
 ?>
