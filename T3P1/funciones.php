<?php
function conectar(){
  $servername = stripslashes(htmlspecialchars(trim('localhost')));
  $username = stripslashes(htmlspecialchars(trim('root')));
  $password = stripslashes(htmlspecialchars(trim('rootroot')));
  $dbname = stripslashes(htmlspecialchars(trim('empleadosnm')));
  return mysqli_connect($servername, $username, $password, $dbname);
}
 ?>
