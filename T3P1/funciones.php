<?php
function conectar(){
  $servername = stripslashes(htmlspecialchars(trim('localhost')));
  $username = stripslashes(htmlspecialchars(trim('root')));
  $password = stripslashes(htmlspecialchars(trim('rootroot')));
  $dbname = stripslashes(htmlspecialchars(trim('empleados24')));
  return mysqli_connect($servername, $username, $password, $dbname);
}
 ?>
