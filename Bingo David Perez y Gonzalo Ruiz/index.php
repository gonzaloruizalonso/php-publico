<?php
echo "
<!DOCTYPE html>
<html lang=\"es\" dir=\"ltr\">
  <head>
    <meta charset=\"utf-8\">
    <title>BINGO</title>
    <link rel=\"stylesheet\" href=\"./css/estilos.css\">
  </head>
  <body>
  <h1>HOLAAA</h1>
";
    //Creamos el array mas importante del ejercicio, un array que va a ser tridimensional
    //y que va a contener 4 jugadores, en cada jugador habra 3 cartones y cada carton 15 numeros
      $jugadores=array();
      //esta es la funcion que se encarga de generar los jugadores y sus cartones
//    los parametros pasados son el jugador x y el su y numeros de cartones
      function generarCartones($num,$num2){
        //esta es la segunda dimension que sera añadida proximamente al array principal
        $cartonesJugador = array();
        //generamos tablas html y metemos numeros aleatorios que no se repiten
        for ($i=0; $i < $num2; $i++) {
          echo "<table border=1 style=\"
            margin: 0 auto;
          \" >
          <caption>Carton ".($i+1)."</caption>";
          $contTotal=0;
            echo "<tr>";
            $r=(int)rand(4,6);
              $contTotal+=$r;
              $carton = array();
              for ($j=0; $j < 7; $j++) {
                if ($j<$r) {
                  echo "<td>";
                  do {
                    $n=(int)rand(1,60);
                    //este while es para que no se repitan los numeros
                  } while (in_array($n,$carton));
                  array_push($carton,$n);
                  echo $n;
                  echo "</td>";
                }else {
                  echo "<td>";
                  echo "#";
                  echo "</td>";
                }
              }
            echo "</tr>";
            echo "<tr>";
            //lo mismo pero para la fila, no hemos usado una funcion porque
            //de la manera en la que lo hemos puesto en formato de tabla se
            //tiene que hacer de forma ligeramente diferente
            $r=(int)rand(4,6);
            $contTotal+=$r;
              for ($j=0; $j < 7; $j++) {
                if ($j<$r) {
                  echo "<td>";
                  do {
                    $n=(int)rand(1,60);
                  } while (in_array($n,$carton));
                  array_push($carton,$n);
                  echo $n;
                  echo "</td>";
                }else {
                  echo "<td>";
                  echo "#";
                  echo "</td>";
                }
              }
            echo "</tr>";
            echo "<tr>";
            $r=15-$contTotal;
            //tercera fila
            for ($j=0; $j<7 ; $j++) {
              if ($j<$r) {
                echo "<td>";
                do {
                  $n=(int)rand(1,60);
                } while (in_array($n,$carton));
                array_push($carton,$n);
                echo $n;
                echo "</td>";
              }else {
                echo "<td>";
                echo "#";
                echo "</td>";
              }
            }
            echo "</tr>";
          echo "</table><br>";
          //agregamos la tercera dimension
          $cartonesJugador[$i]=$carton;
        }
        //retornamos el array que contiene el jugador y sus 3 cartones
      return $cartonesJugador;
      }
      //Funcion Contador Generamos un Array el cual contiene un contador
      //por cada carton , cada contador es de 15 y estan para todos los
      //los jugadores y los cartones el parametro pasado es el numero de cartones
  function Contador ($num2){
  $contadores = array();
      for ($j=0; $j <=$num2 ; $j++) {
  $p[$j]=15;
      }
    return $p;
  }
  //Funcion ganador su funcionalidad es determinar el ganador de la partida
  //Los parametros pasados son el array de jugadores y de contadores
      function Ganador($jugadores,$contadores){
      //con esto controlaremos que no se repitan los numeros
     $numerosQueHanSalido=array();
       $jugadorGanador="";
       $ganador=false;
         //GENERACION DE NUMEROS
         $VnbIndice=0;
         //Empieza el bucle que controlara quien gana y que numeros salen es hasta
         // que una persona gane o hayan salido los 60 numeros.
        while ($VnbIndice <= 60 && $ganador==false) {
        //  Con esto controlamos que no se repitan los numeros
         do {
           $n=(int)rand(1,60);
         } while (in_array($n,$numerosQueHanSalido));
         array_push($numerosQueHanSalido,$n);
         echo "<img src=\"./img/$n.PNG\">";
         //Aqui se comprueba los valores de los cartones con el numero que ha
         //salido anteriormente y se le resta 1 al contador
         foreach ($jugadores as $key => $value) {
           foreach ($value as $key2 => $value2) {
             foreach ($value2 as $key3 => $value3) {
               $clave=$key;
               $clave2=$key2;
              if ($value3==$n) {
                $contadores[$clave][$clave2]--;
                if ($contadores[$clave][$clave2]==0) {

                 $jugadorGanador=($clave+1)." con el carton ".($clave2+1);
                 echo "<br>";
                 echo "<br>Ha ganado el jugador ".$jugadorGanador;
                 echo "<br>";
                 $ganador=true;
                }
              }
             }
           }
         }
         $VnbIndice++;
         //######################
       }

  echo "<br>";
  }
echo "
    <div class=\"centrado\" style=\"
      margin-bottom: 5px;
      margin-top: 20px;
    \">
      <h1>Bingo</h1>
      <h2>David Perez y Gonzalo Ruiz</h2>
    </div>
    <div class=\"jugador\">
      <h2>Jugador 1</h2>
";
        //unimos los arrays para tener 3 dimensiones
        $numeroCartones=3;
        $jugadores[0]=generarCartones(1,$numeroCartones);
        $contadores[0]=Contador($numeroCartones);
echo "
    </div>
    <div class=\"jugador\">
      <h2>Jugador 2</h2>
";
        // lo mismo para el jugador 2
        $numeroCartones=3;
        $jugadores[1]=generarCartones(2,$numeroCartones);
        $contadores[1]=Contador($numeroCartones);

  echo "
      </div>
      <div class=\"jugador\">
        <h2>Jugador 3</h2>
  ";
      // lo mismo para el jugador 3
        $numeroCartones=3;
        $jugadores[2]=generarCartones(3,$numeroCartones);
        $contadores[2]=Contador($numeroCartones);
    echo "
        </div>
        <div class=\"jugador\">
          <h2>Jugador 4</h2>
    ";
      // lo mismo para el jugador 4
        $numeroCartones=3;
        $jugadores[3]= generarCartones(4,$numeroCartones);
        $contadores[3]=Contador($numeroCartones);
echo "
    </div>";
  echo "  <div class=\"centrado\" style=\"
    margin-top: 252px;
    margin-bottom: 1px;
    clear: left;
    \">
    <h3>Numeros: </h3>
";
Ganador($jugadores,$contadores);


  echo "</div>
  </body>
</html>";
?>
